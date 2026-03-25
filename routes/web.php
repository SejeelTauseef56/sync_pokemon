<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('pokemon.index')
        : view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::redirect('/dashboard', '/pokemon')->name('dashboard');

    Route::prefix('pokemon')->name('pokemon.')->group(function () {
        Route::get('/', [PokemonController::class, 'index'])->name('index');
        Route::post('/sync', [PokemonController::class, 'sync'])->name('sync');
        Route::post('/{pokemon}/sync', [PokemonController::class, 'syncOne'])->name('sync-one');
        Route::get('/{pokemon}', [PokemonController::class, 'show'])->name('show');
        Route::get('/{pokemon}/edit', [PokemonController::class, 'edit'])->name('edit');
        Route::put('/{pokemon}', [PokemonController::class, 'update'])->name('update');
    });
});