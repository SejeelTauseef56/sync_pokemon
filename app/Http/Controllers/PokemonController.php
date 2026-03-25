<?php

namespace App\Http\Controllers;

use App\Jobs\SyncAllPokemon;
use App\Models\Pokemon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function edit(Pokemon $pokemon): View
    {
        return view('pokemon.edit', compact('pokemon'));
    }

    public function index(): View
    {
        $pokemons = Pokemon::query()
            ->latest()
            ->paginate(15);

        return view('pokemon.index', compact('pokemons'));
    }

    public function show(Pokemon $pokemon): View
    {
        return view('pokemon.show', compact('pokemon'));
    }

    public function sync(): RedirectResponse
    {
        SyncAllPokemon::dispatch();

        return redirect()
            ->route('pokemon.index')
            ->with('success', 'Pokémon sync started. It may take a while to complete.');
    }

    public function syncOne(Pokemon $pokemon): RedirectResponse
    {
        $response = Http::get($pokemon->api_url);

        if (!$response->successful()) {
            return redirect()
                ->route('pokemon.show', $pokemon)
                ->with('error', 'Failed to sync Pokémon.');
        }

        $data = $response->json();

        $pokemon->update([
            'external_id' => $data['id'],
            'name' => $data['name'],
            'height' => $data['height'],
            'weight' => $data['weight'],
            'base_experience' => $data['base_experience'],
            'api_url' => $pokemon->api_url,
        ]);

        return redirect()
            ->route('pokemon.show', $pokemon)
            ->with('success', 'Pokémon synced successfully.');
    }

    public function update(Request $request, Pokemon $pokemon): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'height' => ['required', 'integer', 'min:1'],
            'weight' => ['required', 'integer', 'min:1'],
            'base_experience' => ['nullable', 'integer', 'min:0'],
        ]);

        $pokemon->update($validated);

        return redirect()
            ->route('pokemon.show', $pokemon)
            ->with('success', 'Pokémon updated successfully.');
    }
}
