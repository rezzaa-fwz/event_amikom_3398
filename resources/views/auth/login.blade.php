<x-guest-layout>
    <!-- Top Header -->
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-6 group">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-200">
                AH
            </div>
            <span class="text-xl font-bold tracking-tight text-slate-900">AmikomEventHub</span>
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center justify-center gap-2">
            Selamat Datang! <span class="inline-block animate-pulse">👋</span>
        </h1>
        <p class="text-slate-400 font-medium text-sm mt-2">
            Masuk ke akun Anda untuk memesan tiket.
        </p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-xl shadow-slate-200/50 border border-slate-100">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if (session('error'))
            <div class="mb-4 p-3.5 rounded-2xl bg-rose-50 text-rose-600 text-sm font-semibold border border-rose-100">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Alamat Email -->
            <div>
                <label for="email" class="block text-slate-700 font-bold text-sm mb-2">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="email@contoh.com"
                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white text-slate-800 placeholder-slate-400 font-medium transition duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-500 font-semibold" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-slate-700 font-bold text-sm mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white text-slate-800 placeholder-slate-400 font-medium transition duration-200">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-500 font-semibold" />
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white font-bold text-base rounded-2xl shadow-lg shadow-indigo-200 transition-all duration-200">
                Masuk Sekarang
            </button>
        </form>

        <!-- Divider -->
        <div class="relative flex items-center justify-center my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <span class="relative px-4 bg-white text-xs font-bold text-slate-400 tracking-wider">ATAU</span>
        </div>

        <!-- Google Login Button -->
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
    </div>

    <!-- Bottom Links -->
    <div class="mt-8 text-center space-y-3">
        <p class="text-xs font-medium text-slate-400">
            Memiliki peran khusus di platform?
        </p>
        <div class="flex items-center justify-center gap-3 text-xs font-bold">
            <a href="{{ route('organizations.register') }}" class="text-emerald-600 hover:text-emerald-700 flex items-center gap-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Login Partner
            </a>
            <span class="text-slate-300">•</span>
            <a href="{{ route('admin.login') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center gap-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Login Admin
            </a>
        </div>
        <a href="{{ route('home') }}" class="inline-block text-xs font-medium text-slate-400 hover:text-slate-600 transition mt-2">
            ← Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>