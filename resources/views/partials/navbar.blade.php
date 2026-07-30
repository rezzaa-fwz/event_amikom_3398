<nav class="max-w-7xl mx-auto my-4 px-6 py-3 bg-white rounded-2xl border border-slate-100 shadow-md shadow-slate-200/40 flex items-center justify-between sticky top-4 z-50 transition-all duration-300">
    <!-- Logo & Brand -->
    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-200">
            AH
        </div>
        <span class="text-xl font-bold tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors">AmikomEventHub</span>
    </a>

    <!-- Navigation Links -->
    <div class="hidden md:flex items-center gap-8 font-medium text-sm text-slate-700">
        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors {{ request()->is('/') ? 'text-indigo-600 font-semibold' : '' }}">
            Jelajahi
        </a>
        <a href="{{ url('/katalog') }}" class="hover:text-indigo-600 transition-colors {{ request()->is('katalog') ? 'text-indigo-600 font-semibold' : '' }}">
            Katalog
        </a>
        <a href="{{ url('/ticket') }}" class="hover:text-indigo-600 transition-colors {{ request()->is('ticket') || request()->is('my-ticket') ? 'text-indigo-600 font-semibold' : '' }}">
            Tiket Saya
        </a>
        <a href="{{ url('/profil') }}" class="hover:text-indigo-600 transition-colors {{ request()->is('profil') || request()->is('profile') ? 'text-indigo-600 font-semibold' : '' }}">
            Profil
        </a>
        <a href="{{ url('/bantuan') }}" class="hover:text-indigo-600 transition-colors {{ request()->is('bantuan') ? 'text-indigo-600 font-semibold' : '' }}">
            Bantuan
        </a>
    </div>

    <!-- Action Buttons (Login & Daftar atau Profil User) -->
    <div class="flex items-center gap-3">
        @auth
            <a href="{{ url('/profil') }}" class="flex items-center gap-3 bg-slate-50 border border-slate-200/80 pl-2 pr-4 py-1.5 rounded-2xl hover:bg-slate-100/80 transition duration-200 group">
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="text-left">
                    <p class="text-xs font-bold text-slate-800 leading-tight truncate max-w-[120px]">{{ auth()->user()->name }}</p>
                    <span class="inline-block px-1.5 py-0.5 text-[9px] font-extrabold bg-indigo-100 text-indigo-700 rounded-md uppercase tracking-wider">
                        {{ auth()->user()->role ?? 'User' }}
                    </span>
                </div>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-3.5 py-2 text-rose-600 hover:bg-rose-50 border border-rose-100 rounded-xl font-semibold text-xs transition duration-200">
                    Keluar
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="px-5 py-2 text-slate-700 bg-white border border-slate-200 rounded-xl font-semibold text-sm hover:border-indigo-600 hover:text-indigo-600 transition duration-200">
                Login
            </a>
            <a href="{{ route('register') }}" class="px-5 py-2 text-white bg-indigo-600 rounded-xl font-semibold text-sm hover:bg-indigo-700 transition duration-200 shadow-md shadow-indigo-200">
                Daftar
            </a>
        @endauth
    </div>
</nav>
