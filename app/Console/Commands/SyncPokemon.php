<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

#[Signature('pokemon:sync')]
#[Description('Sync Pokemon from PokeAPI')]
class SyncPokemon extends Command
{
    public function handle(): void
    {
        $this->info('Fetching Pokemon list...');

        // Fetch the list of all Pokemon with retry logic (3 attempts, 100ms delay) and don't throw exceptions on failure
        $response = Http::retry(3, 100, throw: false)->get('https://pokeapi.co/api/v2/pokemon?limit=100000&offset=0');

        if ($response->failed()) {
            $this->error('Failed to fetch Pokemon list.');
            return;
        }

        $results = $response->json()['results'];
        $total = count($results);

        $this->info("Found {$total} Pokemon. Starting sync...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        // One failed response should not stop the rest of the sync.
        foreach ($results as $pokemon) {
            try {
                // Same retry logic for individual Pokemon details.
                $detail = Http::retry(3, 100, throw: false)->get($pokemon['url']);

                if ($detail->failed()) {
                    $this->newLine();
                    $this->warn("Skipping {$pokemon['name']} — request failed.");
                    $bar->advance();
                    continue;
                }

                $data = $detail->json();

                // Re-syncs should refresh the same row instead of creating duplicates.
                Pokemon::updateOrCreate(
                    ['external_id' => $data['id']],
                    [
                        'name' => $data['name'],
                        'height' => $data['height'],
                        'weight' => $data['weight'],
                        'base_experience' => $data['base_experience'],
                        'api_url' => $pokemon['url'],
                    ]
                );
            } catch (\Exception $e) {
                $this->newLine();
                $this->warn("Skipping {$pokemon['name']} — {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Sync complete!');
    }
}
