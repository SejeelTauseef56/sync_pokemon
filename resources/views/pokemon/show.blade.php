<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pokemon->name }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

    <header class="bg-white border-b">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Pokémon Detail</h1>

            <div class="flex items-center gap-4">
                <a href="{{ route('pokemon.index') }}" class="text-sm text-gray-600 hover:text-black">
                    Back to Pokémon
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                    @csrf
                    <button type="submit" class="inline-flex items-center text-sm text-gray-600 hover:text-black">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center">
                @if (session('success'))
                    <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                <h2 class="text-xl font-semibold capitalize">{{ $pokemon->name }}</h2>

                <div class="flex gap-2">
                    <a href="{{ route('pokemon.edit', $pokemon) }}"
                        class="bg-gray-900 text-white text-sm px-4 py-2 rounded-md">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('pokemon.sync-one', $pokemon) }}">
                        @csrf
                        <button class="bg-gray-200 text-gray-800 text-sm px-4 py-2 rounded-md">
                            Sync This Pokémon
                        </button>
                    </form>
                </div>
            </div>
            <dl class="mt-6 space-y-4 text-sm">
                <div class="flex justify-between border-b pb-3">
                    <dt class="font-medium text-gray-600">External ID</dt>
                    <dd>{{ $pokemon->external_id }}</dd>
                </div>

                <div class="flex justify-between border-b pb-3">
                    <dt class="font-medium text-gray-600">Height</dt>
                    <dd>{{ $pokemon->height }}</dd>
                </div>

                <div class="flex justify-between border-b pb-3">
                    <dt class="font-medium text-gray-600">Weight</dt>
                    <dd>{{ $pokemon->weight }}</dd>
                </div>

                <div class="flex justify-between border-b pb-3">
                    <dt class="font-medium text-gray-600">Base Experience</dt>
                    <dd>{{ $pokemon->base_experience }}</dd>
                </div>

                <div class="flex justify-between pb-3">
                    <dt class="font-medium text-gray-600">API URL</dt>
                    <dd class="text-right break-all">{{ $pokemon->api_url }}</dd>
                </div>
            </dl>
        </div>
    </main>

</body>

</html>
