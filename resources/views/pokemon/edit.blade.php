<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $pokemon->name }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">

<header class="bg-white border-b">
    <div class="max-w-3xl mx-auto px-4 py-3 flex justify-between items-center">
        <h1 class="text-lg font-semibold">Edit Pokémon</h1>

        <a href="{{ route('pokemon.show', $pokemon) }}" class="text-sm text-gray-600 hover:text-black">
            Back
        </a>
    </div>
</header>

<main class="max-w-3xl mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold capitalize mb-6">{{ $pokemon->name }}</h2>

        @if ($errors->any())
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('pokemon.update', $pokemon) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-sm font-medium text-gray-700">Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $pokemon->name) }}"
                    required
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm"
                >
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Height</label>
                <input
                    type="number"
                    name="height"
                    value="{{ old('height', $pokemon->height) }}"
                    required
                    min="1"
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm"
                >
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Weight</label>
                <input
                    type="number"
                    name="weight"
                    value="{{ old('weight', $pokemon->weight) }}"
                    required
                    min="1"
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm"
                >
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Base Experience</label>
                <input
                    type="number"
                    name="base_experience"
                    value="{{ old('base_experience', $pokemon->base_experience) }}"
                    min="0"
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm"
                >
            </div>

            <button class="bg-gray-900 text-white text-sm px-4 py-2 rounded-md">
                Save Changes
            </button>
        </form>
    </div>
</main>

</body>
</html>
