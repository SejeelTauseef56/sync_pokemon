<?php

namespace Tests\Feature;

use App\Models\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PokemonImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_pokemon_can_be_imported_from_api(): void
    {
        // Prevent any real HTTP requests from going out during this test. We will fake the specific endpoints we expect to be called.
        Http::preventStrayRequests();

        Http::fake([
            'https://pokeapi.co/api/v2/pokemon?limit=100000&offset=0' => Http::response([
                'results' => [
                    [
                        'name' => 'pikachu',
                        'url' => 'https://pokeapi.co/api/v2/pokemon/25',
                    ],
                ],
            ], 200),

            'https://pokeapi.co/api/v2/pokemon/25' => Http::response([
                'id' => 25,
                'name' => 'pikachu',
                'height' => 4,
                'weight' => 60,
                'base_experience' => 112,
            ], 200),
        ]);

        $this->artisan('pokemon:sync')
            ->assertExitCode(0);

        $this->assertDatabaseCount('pokemon', 1);

        $this->assertDatabaseHas('pokemon', [
            'external_id' => 25,
            'name' => 'pikachu',
            'height' => 4,
            'weight' => 60,
            'base_experience' => 112,
        ]);
    }

    public function test_existing_pokemon_is_updated_when_sync_runs_again(): void
    {
        Http::preventStrayRequests();

        Pokemon::create([
            'external_id' => 25,
            'name' => 'old-pikachu',
            'height' => 1,
            'weight' => 1,
            'base_experience' => 1,
            'api_url' => 'https://pokeapi.co/api/v2/pokemon/25',
        ]);

        Http::fake([
            'https://pokeapi.co/api/v2/pokemon?limit=100000&offset=0' => Http::response([
                'results' => [
                    [
                        'name' => 'pikachu',
                        'url' => 'https://pokeapi.co/api/v2/pokemon/25',
                    ],
                ],
            ], 200),

            'https://pokeapi.co/api/v2/pokemon/25' => Http::response([
                'id' => 25,
                'name' => 'pikachu',
                'height' => 4,
                'weight' => 60,
                'base_experience' => 112,
            ], 200),
        ]);

        $this->artisan('pokemon:sync')
            ->assertExitCode(0);

        $this->assertDatabaseCount('pokemon', 1);

        $this->assertDatabaseHas('pokemon', [
            'external_id' => 25,
            'name' => 'pikachu',
            'height' => 4,
            'weight' => 60,
            'base_experience' => 112,
        ]);
    }
}
