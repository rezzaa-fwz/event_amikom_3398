<x-guest-layout>
    <!-- Top Header -->
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-6 group">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-200">
                AH
            </div>
            <span class="text-xl font-bold tracking-tight text-slate-900">AmikomEventHub</span>
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Buat Akun Baru ✨
        </h1>
        <p class="text-slate-400 font-medium text-sm mt-2">
            Daftar sekarang untuk mulai pesan tiket event seru.
        </p>
    </div>

    <!-- Register Card -->
    <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-xl shadow-slate-200/50 border border-slate-100">
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-slate-700 font-bold text-sm mb-2">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    placeholder="Nama Anda"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200/80 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white text-slate-800 placeholder-slate-400 font-medium transition duration-200">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-rose-500 font-semibold" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-slate-700 font-bold text-sm mb-2">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="email@contoh.com"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200/80 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white text-slate-800 placeholder-slate-400 font-medium transition duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-500 font-semibold" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-slate-700 font-bold text-sm mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200/80 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white text-slate-800 placeholder-slate-400 font-medium transition duration-200">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-500 font-semibold" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-slate-700 font-bold text-sm mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200/80 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white text-slate-800 placeholder-slate-400 font-medium transition duration-200">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-rose-500 font-semibold" />
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 mt-2 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white font-bold text-base rounded-2xl shadow-lg shadow-indigo-200 transition-all duration-200">
                Daftar Sekarang
            </button>
        </form>

        <!-- Divider -->
        <div class="relative flex items-center justify-center my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <span class="relative px-4 bg-white text-xs font-bold text-slate-400 tracking-wider">ATAU</span>
        </div>

        <!-- Google Register Button -->
        <a href="{{ route('auth.google.redirect') }}"
            class="w-full py-3.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-sm rounded-2xl flex items-center justify-center gap-3 transition-colors shadow-xs">
            <svg class="w-5 h-5" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
            </svg>
            Lanjutkan dengan Google
        </a>

        <div class="mt-6 text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">
                Masuk di sini
            </a>
        </div>
    </div>

    <!-- Bottom Link -->
    <div class="mt-8 text-center">
        <a href="{{ route('home') }}" class="inline-block text-xs font-medium text-slate-400 hover:text-slate-600 transition">
            ← Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>
