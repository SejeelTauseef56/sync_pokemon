<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

    <header class="bg-white border-b">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Pokémon</h1>

            <div class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                    @csrf
                    <button type="submit" class="inline-flex items-center text-sm text-gray-600 hover:text-black">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6">

        <div class="bg-white rounded-lg shadow p-6">

            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-md font-semibold">All Pokémon</h2>

                <form method="POST" action="{{ route('pokemon.sync') }}">
                    @csrf
                    <button class="bg-gray-900 text-white text-sm px-4 py-2 rounded-md">
                        Sync All
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="border-b text-gray-600">
                        <tr>
                            <th class="py-2">Name</th>
                            <th class="py-2">Height</th>
                            <th class="py-2">Weight</th>
                            <th class="py-2">Base Exp</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($pokemons as $pokemon)
                            <tr>
                                <td class="py-2 font-medium">
                                    <a href="{{ route('pokemon.show', $pokemon) }}"
                                        class="text-gray-900 hover:underline">
                                        {{ $pokemon->name }}
                                    </a>
                                </td>
                                <td class="py-2">
                                    {{ $pokemon->height }}
                                </td>
                                <td class="py-2">
                                    {{ $pokemon->weight }}
                                </td>
                                <td class="py-2">
                                    {{ $pokemon->base_experience }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">
                                    No Pokémon yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $pokemons->links() }}
            </div>

        </div>

    </main>

</body>

</html>
