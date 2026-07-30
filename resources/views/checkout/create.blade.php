@extends('layouts.main')

@section('title', 'Checkout - ' . $event->title)

@section('content')
<!-- Back to Event Link -->
<div class="max-w-xl mx-auto px-4 pt-6 text-center">
    <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center gap-1.5 text-indigo-600 font-bold text-xs hover:underline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Event
    </a>
</div>

<main class="max-w-xl mx-auto px-4 py-6 space-y-6">

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl font-bold text-sm text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Card 1: Pesanan Anda -->
    <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm">
        <h3 class="text-lg font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Pesanan Anda</h3>
        
        <div class="flex gap-4 items-center">
            <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) ? asset('storage/' . $event->poster_path) : (file_exists(public_path($event->poster_path ?? '')) ? asset($event->poster_path) : 'https://placehold.co/200x200') }}"
                 alt="{{ $event->title }}" 
                 class="w-20 h-20 rounded-2xl object-cover shadow-xs flex-shrink-0">
            <div>
                <h4 class="font-extrabold text-slate-900 text-base leading-tight mb-1">{{ $event->title }}</h4>
                <p class="text-slate-400 text-xs font-medium">
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}
                </p>
                <p class="text-indigo-600 font-bold text-sm mt-1">1 x Rp {{ number_format($event->price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 pt-5 border-t border-slate-100 space-y-2.5">
            <div class="flex justify-between text-xs text-slate-500 font-medium">
                <span>Harga Tiket</span>
                <span class="text-slate-700 font-semibold">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-xs text-slate-500 font-medium">
                <span>Biaya Layanan</span>
                <span class="text-slate-700 font-semibold">Rp 5.000</span>
            </div>
            <div class="flex justify-between items-center text-xl font-bold mt-4 pt-4 border-t border-slate-100">
                <span class="text-slate-900 font-extrabold text-base">Total Bayar</span>
                <span class="text-indigo-600 font-black text-2xl">Rp {{ number_format($event->price + 5000, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Data Pemesan -->
    <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm">
        <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
            <span>📦</span> Data Pemesan
        </h3>

        <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-4">
            @csrf

            <!-- NAMA LENGKAP -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" name="customer_name" 
                       value="{{ auth()->user()->name ?? '' }}" 
                       placeholder="Masukkan nama sesuai identitas" 
                       class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition" 
                       readonly>
            </div>

            <!-- EMAIL & PHONE GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email Aktif</label>
                    <input type="email" name="customer_email" 
                           value="{{ auth()->user()->email ?? '' }}" 
                           placeholder="contoh@gmail.com" 
                           class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition" 
                           readonly>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">No. WhatsApp</label>
                    <input type="tel" name="customer_phone" 
                           value="{{ old('customer_phone') }}" 
                           placeholder="08xxxxxxx" 
                           class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition" 
                           required>
                </div>
            </div>

            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-1 mb-6">*E-TICKET AKAN DIKIRIM KE EMAIL INI</p>

            <button type="submit"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white font-bold text-base rounded-2xl shadow-lg shadow-indigo-200 transition-all duration-200">
                Lanjut Pembayaran
            </button>
            <p class="text-center text-[10px] text-slate-400 font-medium mt-3">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.</p>
        </form>
    </div>

</main>
@endsection