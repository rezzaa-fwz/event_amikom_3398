<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-link { @apply flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200; }
        .nav-link.active { @apply bg-white/20 text-white shadow-inner; }
        .nav-link:not(.active) { @apply text-indigo-200 hover:bg-white/10 hover:text-white; }
        .stat-card { @apply bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    {{-- ==================== SIDEBAR ==================== --}}
    <aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-950 text-indigo-100 flex flex-col sticky top-0 h-screen overflow-y-auto">

        {{-- Logo --}}
        <div class="flex items-center gap-3 p-6 pb-4">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-black text-lg shadow">AH</div>
            <div>
                <span class="text-base font-black text-white tracking-tight block">AmikomEventHub</span>
                <span class="text-[10px] text-indigo-400 font-medium">Admin Panel</span>
            </div>
        </div>

        {{-- Identitas Organisasi --}}
        @auth
        <div class="mx-4 mb-4 p-3 bg-white/10 rounded-2xl border border-white/10">
            @if(auth()->user()->isSuperAdmin())
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-amber-400 rounded-xl flex items-center justify-center text-amber-900 font-black text-xs shadow flex-shrink-0">SA</div>
                    <div class="min-w-0">
                        <p class="text-white font-bold text-xs truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-block px-2 py-0.5 bg-amber-400 text-amber-900 rounded-full text-[10px] font-black mt-0.5">SUPERADMIN</span>
                    </div>
                </div>
            @else
                @php $org = auth()->user()->organization; @endphp
                <div class="flex items-center gap-2.5">
                    @if($org && $org->logo_path)
                        <img src="{{ Storage::url($org->logo_path) }}" class="w-9 h-9 rounded-xl object-cover flex-shrink-0 shadow">
                    @else
                        <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center text-white font-black text-xs flex-shrink-0 shadow">
                            {{ strtoupper(substr($org->name ?? 'O', 0, 2)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <p class="text-white font-bold text-xs truncate">{{ $org->name ?? 'Organisasi Saya' }}</p>
                        @if($org)
                            @if($org->status === 'approved')
                                <span class="inline-block px-2 py-0.5 bg-green-400 text-green-900 rounded-full text-[10px] font-black mt-0.5">✓ AKTIF</span>
                            @elseif($org->status === 'pending')
                                <span class="inline-block px-2 py-0.5 bg-amber-400 text-amber-900 rounded-full text-[10px] font-black mt-0.5">⏳ PENDING</span>
                            @else
                                <span class="inline-block px-2 py-0.5 bg-red-400 text-red-900 rounded-full text-[10px] font-black mt-0.5">⛔ SUSPENDED</span>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        </div>
        @endauth

        {{-- Navigasi Utama --}}
        <nav class="flex-1 px-4 space-y-1">
            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-500 mb-3 px-2">Main Menu</p>

            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Kelola Event
            </a>

            <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Laporan Transaksi
            </a>

            {{-- Superadmin-only --}}
            @auth
            @if(auth()->user()->isSuperAdmin())
                <div class="pt-4">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-500 mb-3 px-2">Superadmin</p>
                </div>

                <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A4.002 4.002 0 017 3z"></path>
                    </svg>
                    Kelola Kategori
                </a>

                <a href="{{ route('admin.partners.index') }}" class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Kelola Partner
                </a>

                <a href="{{ route('admin.organizations.index') }}" class="nav-link {{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"></path>
                    </svg>
                    Kelola Organisasi
                    @php
                        $pendingCount = \App\Models\Organization::where('status','pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto bg-amber-400 text-amber-900 text-[10px] font-black px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            @else
                {{-- Profil Organisasi untuk admin tenant --}}
                <div class="pt-4">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-500 mb-3 px-2">Organisasi</p>
                </div>
                <a href="{{ route('admin.org.profile') }}" class="nav-link {{ request()->routeIs('admin.org.profile') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Profil Organisasi
                </a>
            @endif
            @endauth
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-white/10">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-indigo-300 hover:text-white hover:bg-white/10 rounded-xl font-semibold text-sm transition-all duration-200">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ==================== MAIN CONTENT ==================== --}}
    <main class="flex-1 overflow-y-auto">
        {{-- Top Header --}}
        <header class="bg-white border-b border-slate-100 px-10 py-5 flex justify-between items-center sticky top-0 z-10">
            <div>
                <h1 class="text-2xl font-black text-slate-900">@yield('page_title', 'Dashboard')</h1>
                <p class="text-slate-400 text-sm font-medium mt-0.5">@yield('page_subtitle', 'Selamat datang kembali!')</p>
            </div>
            <div class="flex items-center gap-4">
                @auth
                <div class="text-right hidden md:block">
                    <p class="font-bold text-sm text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->isSuperAdmin() ? 'Superadmin' : (auth()->user()->organization->name ?? 'Admin') }}</p>
                </div>
                <div class="w-11 h-11 bg-indigo-100 rounded-2xl shadow-sm flex items-center justify-center overflow-hidden">
                    @if(auth()->user()->isSuperAdmin())
                        <span class="text-indigo-700 font-black text-sm">SA</span>
                    @elseif(auth()->user()->organization && auth()->user()->organization->logo_path)
                        <img src="{{ Storage::url(auth()->user()->organization->logo_path) }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" class="rounded-2xl">
                    @endif
                </div>
                @endauth
            </div>
        </header>

        <div class="p-10">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 font-semibold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6 font-semibold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>