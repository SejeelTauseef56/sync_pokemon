<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <header class="bg-white border-b border-gray-300">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-semibold">Pokémon</h1>

            <nav class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('pokemon.index') }}" class="text-gray-600 hover:text-black">
                        Open app
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-black">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-md bg-gray-900 px-4 py-2 text-white hover:bg-black">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-16">
        <section class="rounded-2xl bg-white p-8 shadow sm:p-10">
            <h2 class="max-w-2xl text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">
                Manage Pokémon records.
            </h2>
            <p class="mt-4 max-w-xl text-base leading-7 text-gray-600">
                Log in to view, sync, and update Pokémon data.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <a href="{{ route('pokemon.index') }}" class="rounded-md bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black">
                        Go to Pokémon
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-md bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-md border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 hover:border-gray-900 hover:text-gray-900">
                            Create account
                        </a>
                    @endif
                @endauth
            </div>
        </section>
    </main>
</body>
</html>
