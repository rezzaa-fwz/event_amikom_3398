<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login - Praktikum Digital Bisnis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang</h2>
            <p class="text-sm text-gray-500">Silakan masuk ke akun Anda</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="nama@email.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                >
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 shadow-sm"
                >
                    Masuk
                </button>
            </div>

        </form>

        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="mx-4 text-sm text-gray-400">atau</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <a href="{{ route('admin.auth.google.redirect') }}"
            class="w-full flex items-center justify-center gap-3 border border-gray-300 rounded-lg py-2.5 px-4 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
            <svg class="w-5 h-5" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12
                    c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24
                    c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039
                    l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36
                    c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571
                    c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24
                    C44,22.659,43.862,21.35,43.611,20.083z"/>
            </svg>
            Continue with Google
        </a>
        <p class="text-center text-xs text-gray-400 mt-3">Khusus untuk akun yang sudah terdaftar sebagai Admin.</p>
    </div>

</body>
</html>