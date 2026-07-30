<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .tab-btn.active {
            color: #0f172a;
            border-bottom: 3px solid #0f172a;
            font-weight: 800;
        }
    </style>
</head>

<body class="bg-white text-slate-900 antialiased">

    <!-- Navigation Header -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-6 md:py-10">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-slate-700">Beranda</a>
            <span>•</span>
            <a href="{{ url('/katalog') }}" class="hover:text-slate-700">{{ $event->category->name ?? 'Event' }}</a>
            <span>•</span>
            <span class="text-slate-900 truncate max-w-[200px] md:max-w-none">{{ $event->title }}</span>
        </div>

        {{-- TOP SECTION: 2 COLUMNS (POSTER vs DETAIL) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start mb-16">
            
            {{-- Left Column: Poster & Gallery Showcase --}}
            <div class="lg:col-span-6 space-y-4">
                {{-- Main Big Poster Container --}}
                <div class="relative overflow-hidden rounded-[2rem] bg-stone-100 border border-slate-100 aspect-[4/3] md:aspect-[1/1] shadow-sm flex items-center justify-center p-4">
                    <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) ? asset('storage/' . $event->poster_path) : 'https://placehold.co/600x600/f5f5f4/1c1917?text='.urlencode($event->title) }}" 
                        alt="{{ $event->title }}" 
                        class="w-full h-full object-contain rounded-2xl">
                </div>

                {{-- Thumbnail Gallery Preview --}}
                <div class="grid grid-cols-5 gap-3">
                    <div class="aspect-square rounded-2xl bg-stone-100 border-2 border-slate-900 overflow-hidden cursor-pointer p-1">
                        <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) ? asset('storage/' . $event->poster_path) : 'https://placehold.co/150x150/f5f5f4/1c1917' }}" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <div class="aspect-square rounded-2xl bg-stone-100 border border-slate-200 overflow-hidden cursor-pointer opacity-70 hover:opacity-100 transition p-1">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=300" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <div class="aspect-square rounded-2xl bg-stone-100 border border-slate-200 overflow-hidden cursor-pointer opacity-70 hover:opacity-100 transition p-1">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=300" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <div class="aspect-square rounded-2xl bg-stone-100 border border-slate-200 overflow-hidden cursor-pointer opacity-70 hover:opacity-100 transition p-1">
                        <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=300" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <div class="aspect-square rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center font-bold text-xs text-slate-500 cursor-pointer hover:bg-slate-100 transition">
                        +2 Foto
                    </div>
                </div>
            </div>

            {{-- Right Column: Event Details & Action --}}
            <div class="lg:col-span-6 space-y-6">

                {{-- Penyelenggara & Code --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-slate-900 text-white font-black text-xs flex items-center justify-center">
                            {{ $event->organization ? strtoupper(substr($event->organization->name, 0, 2)) : 'AH' }}
                        </div>
                        <span class="font-bold text-sm text-slate-800">{{ $event->organization->name ?? ($event->partner->name ?? 'Amikom Event Partner') }}</span>
                    </div>
                    <span class="text-xs font-mono font-medium text-slate-400">EVT-{{ str_pad($event->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>

                {{-- Event Title --}}
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $event->title }}
                </h1>

                {{-- Rating Summary --}}
                @php
                    $avgRating = method_exists($event, 'averageRating') ? $event->averageRating() : null;
                    $reviews = method_exists($event, 'reviews') ? $event->reviews()->with('user')->latest()->get() : collect();
                    $reviewsCount = $reviews->count();
                @endphp
                <div class="flex items-center gap-2">
                    <div class="flex text-amber-400 text-sm">
                        ★★★★★
                    </div>
                    <span class="font-bold text-sm text-slate-800">{{ number_format($avgRating ?: 5.0, 1) }}</span>
                    <span class="text-slate-400 text-xs font-medium">•</span>
                    <a href="#reviews-section" class="text-xs font-semibold text-slate-500 hover:text-slate-900 underline">
                        {{ $reviewsCount }} ulasan
                    </a>
                </div>

                {{-- Price Tag --}}
                <div class="pt-2">
                    <span class="text-4xl md:text-5xl font-black text-slate-900">
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400 ml-1">/ tiket</span>
                </div>

                <hr class="border-slate-100">

                {{-- Event Specifications Grid (Date, Time, Location, Stock) --}}
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Tanggal & Waktu</p>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-800 rounded-xl font-bold text-sm">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($event->date)->translatedFormat('l, d F Y · H:i') }} WIB
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Lokasi Acara</p>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-800 rounded-xl font-bold text-sm">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $event->location }}
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Ketersediaan Tiket</p>
                        <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-extrabold">
                            ✓ Tersedia (Tersisa {{ $event->stock }} tiket)
                        </span>
                    </div>
                </div>

                {{-- Primary Action Buttons --}}
                <div class="pt-4 flex items-center gap-3">
                    <a href="{{ url('checkout/'.$event->id) }}" 
                        class="flex-1 py-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-bold text-base rounded-2xl flex items-center justify-center gap-3 transition shadow-lg shadow-slate-900/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Pesan Tiket Sekarang
                    </a>
                    <button type="button" class="w-14 h-14 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl flex items-center justify-center transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>

                {{-- Guaranteed Features List --}}
                <div class="pt-2 space-y-2 text-xs font-semibold text-slate-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        E-Ticket instan dikirim ke email Anda setelah pembayaran
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Proses Check-in Cepat via QR Code saat tiba di lokasi
                    </div>
                </div>

            </div>
        </div>

        {{-- BOTTOM SECTION: TABBED NAVIGATION (DETAILS | REVIEWS | DISCUSSIONS) --}}
        <div id="reviews-section" class="border-t border-slate-200 pt-10">

            {{-- Tabs Bar --}}
            <div class="flex items-center gap-8 border-b border-slate-200 mb-10 text-slate-400 font-bold text-lg pb-1">
                <button type="button" class="tab-btn active pb-3 transition">Detail Event</button>
                <button type="button" class="tab-btn pb-3 hover:text-slate-900 transition">Ulasan ({{ $reviewsCount }})</button>
                <button type="button" class="tab-btn pb-3 hover:text-slate-900 transition">Kebijakan</button>
            </div>

            {{-- Grid Section: Left (Reviews & Description) vs Right (Rating Breakdown Chart) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                {{-- Left Column: Event Description + Reviews List & Form --}}
                <div class="lg:col-span-7 space-y-10">

                    {{-- Deskripsi Event --}}
                    <div>
                        <h3 class="text-xl font-black text-slate-900 mb-4">Tentang Event Ini</h3>
                        <p class="text-slate-600 leading-relaxed font-medium text-base whitespace-pre-line">
                            {{ $event->description }}
                        </p>
                    </div>

                    <hr class="border-slate-100">

                    {{-- Section Header Ulasan --}}
                    <div>
                        <h3 class="text-xl font-black text-slate-900 mb-6">Ulasan Peserta</h3>

                        {{-- Alert Messages --}}
                        @if (session('success'))
                            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl mb-6 text-xs font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl mb-6 text-xs font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Form Review Eligibility --}}
                        @php
                            $currentUser = auth()->user();
                            $hasPurchased = false;
                            $alreadyReviewed = false;
                            $eventPassed = \Carbon\Carbon::parse($event->date)->isPast();

                            if ($currentUser) {
                                $hasPurchased = \App\Models\Transaction::where('event_id', $event->id)
                                    ->where(function ($q) use ($currentUser) {
                                        $q->where('user_id', $currentUser->id)
                                          ->orWhere('customer_email', $currentUser->email);
                                    })
                                    ->whereIn('status', ['success', 'settlement'])
                                    ->exists();

                                $alreadyReviewed = \App\Models\Review::where('user_id', $currentUser->id)
                                    ->where('event_id', $event->id)
                                    ->exists();
                            }
                        @endphp

                        @guest
                            <div class="bg-slate-50 border border-slate-200/60 p-4 rounded-2xl text-xs text-slate-500 font-medium mb-8">
                                Silakan <a href="{{ route('login') }}" class="text-indigo-600 font-bold underline">login</a> terlebih dahulu untuk memberikan ulasan.
                            </div>
                        @else
                            @if ($alreadyReviewed)
                                <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-2xl text-xs text-indigo-700 font-semibold mb-8 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Anda telah memberikan ulasan untuk event ini. Terima kasih!
                                </div>
                            @elseif (! $hasPurchased)
                                <div class="bg-amber-50 border border-amber-100 p-4 rounded-2xl text-xs text-amber-800 font-medium mb-8 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Ulasan hanya dapat diberikan oleh peserta yang telah membeli tiket dan pembayaran lunas.
                                </div>
                            @elseif (! $eventPassed)
                                <div class="bg-amber-50 border border-amber-100 p-4 rounded-2xl text-xs text-amber-800 font-medium mb-8 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Ulasan dapat diberikan setelah Anda mengikuti event ini (acara diselenggarakan pada {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}).
                                </div>
                            @else
                                <!-- Form Ulasan Peserta -->
                                <form action="{{ route('events.review.store', $event) }}" method="POST" class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 mb-8 space-y-4">
                                    @csrf
                                    <p class="font-bold text-sm text-slate-800">Tulis Ulasan Anda</p>
                                    <div class="flex gap-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer text-2xl">
                                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                                <span class="text-slate-300 peer-checked:text-amber-400 hover:text-amber-400 transition-colors">★</span>
                                            </label>
                                        @endfor
                                    </div>
                                    <textarea name="comment" rows="3" placeholder="Bagikan kesan & pengalaman Anda mengikuti event ini..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-slate-900 outline-none font-medium"></textarea>
                                    <button type="submit" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs hover:bg-slate-800 transition">Kirim Ulasan</button>
                                </form>
                            @endif
                        @endguest

                        {{-- Individual Reviews List (Style matching uploaded screenshot) --}}
                        <div class="space-y-6">
                            @forelse ($reviews as $review)
                                <div class="flex gap-4 items-start border-b border-slate-100 pb-6">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center font-bold text-slate-600 text-xs">
                                        @if($review->user && $review->user->avatar_path)
                                            <img src="{{ Storage::url($review->user->avatar_path) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($review->user->name ?? 'P', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <p class="font-bold text-slate-900 text-sm">{{ $review->user->name ?? 'Peserta' }}</p>
                                            <span class="text-xs text-slate-400 font-normal">• {{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="text-amber-400 text-xs mb-2">
                                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                        </div>
                                        @if ($review->comment)
                                            <p class="text-slate-600 text-sm font-medium leading-relaxed">{{ $review->comment }}</p>
                                        @endif
                                        <div class="flex items-center gap-4 mt-3 text-xs font-semibold text-slate-400">
                                            <button type="button" class="hover:text-slate-700 transition">Balas</button>
                                            <button type="button" class="hover:text-slate-700 transition flex items-center gap-1">
                                                👍 <span>12</span>
                                            </button>
                                            <button type="button" class="hover:text-slate-700 transition flex items-center gap-1">
                                                👎 <span>0</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 text-center text-slate-400 text-sm font-medium">
                                    Belum ada ulasan untuk event ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right Column: Rating Breakdown Chart (Exact layout matching screenshot) --}}
                <div class="lg:col-span-5 space-y-8">
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                        
                        {{-- Overall Rating Summary Header --}}
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex text-amber-400 text-xl gap-1">
                                ★★★★★
                            </div>
                            <span class="text-4xl font-black text-slate-900">{{ number_format($avgRating ?: 5.0, 1) }}</span>
                        </div>

                        {{-- Rating Stars Breakdown Progress Bars --}}
                        @php
                            $totalRev = max($reviewsCount, 1);
                            $star5 = $reviews->where('rating', 5)->count();
                            $star4 = $reviews->where('rating', 4)->count();
                            $star3 = $reviews->where('rating', 3)->count();
                            $star2 = $reviews->where('rating', 2)->count();
                            $star1 = $reviews->where('rating', 1)->count();
                        @endphp
                        <div class="space-y-3 font-medium text-xs text-slate-500">
                            {{-- 5 Stars --}}
                            <div class="flex items-center gap-3">
                                <span class="w-3 text-right">5</span>
                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full" style="width: {{ ($star5 / $totalRev) * 100 }}%"></div>
                                </div>
                                <span class="w-6 text-right font-bold text-slate-700">{{ $star5 }}</span>
                            </div>
                            {{-- 4 Stars --}}
                            <div class="flex items-center gap-3">
                                <span class="w-3 text-right">4</span>
                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full" style="width: {{ ($star4 / $totalRev) * 100 }}%"></div>
                                </div>
                                <span class="w-6 text-right font-bold text-slate-700">{{ $star4 }}</span>
                            </div>
                            {{-- 3 Stars --}}
                            <div class="flex items-center gap-3">
                                <span class="w-3 text-right">3</span>
                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full" style="width: {{ ($star3 / $totalRev) * 100 }}%"></div>
                                </div>
                                <span class="w-6 text-right font-bold text-slate-700">{{ $star3 }}</span>
                            </div>
                            {{-- 2 Stars --}}
                            <div class="flex items-center gap-3">
                                <span class="w-3 text-right">2</span>
                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full" style="width: {{ ($star2 / $totalRev) * 100 }}%"></div>
                                </div>
                                <span class="w-6 text-right font-bold text-slate-700">{{ $star2 }}</span>
                            </div>
                            {{-- 1 Star --}}
                            <div class="flex items-center gap-3">
                                <span class="w-3 text-right">1</span>
                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full" style="width: {{ ($star1 / $totalRev) * 100 }}%"></div>
                                </div>
                                <span class="w-6 text-right font-bold text-slate-700">{{ $star1 }}</span>
                            </div>
                        </div>

                    </div>

                    {{-- Highlight Banner Penyelenggara --}}
                    <div class="bg-stone-100 rounded-3xl p-8 border border-stone-200/70 space-y-3">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Penyelenggara Resmi</span>
                        <h4 class="text-xl font-black text-slate-900">{{ $event->organization->name ?? ($event->partner->name ?? 'Amikom Event Organizer') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Organisasi penyelenggara terverifikasi di AmikomEventHub. Semua tiket dijamin resmi dan memiliki validasi sertifikat QR Code.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>