<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class SyncAllPokemon implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // A full import can take a while once every Pokemon is fetched one by one.
    public int $timeout = 3600;

    public function handle(): void
    {
        // Reuse the command so the queued flow and terminal flow stay in sync.
        Artisan::call('pokemon:sync');
    }
}
