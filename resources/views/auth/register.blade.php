<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-semibold text-gray-900">Register</h1>
        <p class="text-sm text-gray-500 mb-6">Create your account</p>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium text-gray-700">Name</label>
                <input
                    type="text"
                    name="name"
                    required
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-gray-900 focus:ring-0"
                >
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    name="email"
                    autocomplete="off"
                    required
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-gray-900 focus:ring-0"
                >
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Password</label>
                <input
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    required
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-gray-900 focus:ring-0"
                >
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    required
                    class="p-2 mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-gray-900 focus:ring-0"
                >
            </div>

            <button class="w-full bg-gray-900 text-white py-2 rounded-md text-sm font-medium hover:bg-black">
                Register
            </button>
        </form>

        <p class="text-sm text-center mt-4 text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="underline text-gray-900">Login</a>
        </p>
    </div>

</body>
</html>
