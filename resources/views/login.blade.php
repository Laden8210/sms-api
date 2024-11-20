<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FIEND</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 text-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-3xl font-bold text-center text-violet-500 mb-6">Login to FIEND</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="phone" class="block text-lg font-semibold mb-2">Phone Number</label>
                <input type="phone" id="phone" name="phone" required
                    class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            </div>

            <div class="text-center">
                <button type="submit"
                    class="px-6 py-3 bg-violet-500 text-white font-bold rounded-lg shadow-md hover:bg-violet-600 transition">
                    Login
                </button>
            </div>
        </form>

    </div>
</body>

</html>
