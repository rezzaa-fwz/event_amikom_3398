@extends('layouts.admin')
@section('title', $organization->name . ' — Detail')
@section('page_title', $organization->name)
@section('page_subtitle', 'Detail analitik & riwayat transaksi organisasi ini.')

@section('content')

{{-- Back --}}
<a href="{{ route('admin.organizations.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-semibold text-sm mb-6 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    Kembali ke Daftar Organisasi
</a>

{{-- Header Org --}}
<div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-3xl p-7 mb-8 flex items-center gap-6 shadow-lg">
    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0 overflow-hidden">
        @if($organization->logo_path)
            <img src="{{ (str_starts_with($organization->logo_path ?? '', 'http') ? $organization->logo_path : Storage::url($organization->logo_path)) }}" class="w-full h-full object-cover rounded-2xl">
        @else
            <span class="text-white font-black text-2xl">{{ strtoupper(substr($organization->name, 0, 2)) }}</span>
        @endif
    </div>
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-black truncate">{{ $organization->name }}</h2>
        <p class="text-indigo-200 text-sm mt-0.5">{{ $organization->description ?? 'Tidak ada deskripsi.' }}</p>
        <div class="flex items-center gap-3 mt-3">
            <span class="text-xs text-indigo-200">Admin: <strong class="text-white">{{ $organization->owner->name ?? '—' }}</strong></span>
            <span class="text-indigo-400">·</span>
            <span class="text-xs text-indigo-200">{{ $organization->owner->email ?? '' }}</span>
            <span class="text-indigo-400">·</span>
            <span class="text-xs text-indigo-200">Daftar: {{ $organization->created_at->format('d M Y') }}</span>
        </div>
    </div>
    <div class="flex flex-col items-end gap-3 flex-shrink-0">
        @if ($organization->status === 'approved')
            <span class="px-4 py-1.5 bg-green-400 text-green-900 rounded-full text-sm font-black">✓ Approved</span>
        @elseif ($organization->status === 'pending')
            <span class="px-4 py-1.5 bg-amber-400 text-amber-900 rounded-full text-sm font-black">⏳ Pending</span>
        @else
            <span class="px-4 py-1.5 bg-red-400 text-red-900 rounded-full text-sm font-black">⛔ Suspended</span>
        @endif
        <div class="flex gap-2">
            @if ($organization->status !== 'approved')
            <form action="{{ route('admin.organizations.approve', $organization) }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-white text-indigo-700 rounded-xl text-xs font-bold hover:bg-indigo-50 transition">Approve</button>
            </form>
            @endif
            @if ($organization->status !== 'suspended')
            <form action="{{ route('admin.organizations.suspend', $organization) }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-red-500 text-white rounded-xl text-xs font-bold hover:bg-red-600 transition">Suspend</button>
            </form>
            @endif
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
        $statsConfig = [
            ['label' => 'Total Revenue', 'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'), 'color' => 'indigo'],
            ['label' => 'Tiket Terjual', 'value' => number_format($stats['tickets_sold'], 0, ',', '.'), 'color' => 'green'],
            ['label' => 'Event Aktif', 'value' => $stats['active_events'], 'color' => 'orange'],
            ['label' => 'Pending Order', 'value' => $stats['pending_orders'], 'color' => 'rose'],
            ['label' => 'Total Event', 'value' => $stats['total_events'], 'color' => 'violet'],
        ];
    @endphp
    @foreach($statsConfig as $stat)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 text-center">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ $stat['label'] }}</p>
        <p class="font-black text-slate-900 text-lg">{{ $stat['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- Daftar Event & Transaksi Terakhir --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Daftar Event --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b">
            <h3 class="font-black text-base">Event Milik Organisasi</h3>
        </div>
        <div class="divide-y max-h-80 overflow-y-auto">
            @forelse($organization->events->take(10) as $event)
            <div class="px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 overflow-hidden flex-shrink-0">
                    @if($event->poster_path)
                        <img src="{{ (str_starts_with($event->poster_path ?? '', 'http') ? $event->poster_path : Storage::url($event->poster_path)) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-sm text-slate-800 truncate">{{ $event->title }}</p>
                    <p class="text-xs text-slate-400">{{ $event->date ? $event->date->format('d M Y') : '—' }}</p>
                </div>
                <span class="text-xs font-bold text-indigo-600 whitespace-nowrap">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
            </div>
            @empty
            <div class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada event.</div>
            @endforelse
        </div>
    </div>

    {{-- Transaksi Terakhir --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b">
            <h3 class="font-black text-base">10 Transaksi Terakhir</h3>
        </div>
        <div class="divide-y max-h-80 overflow-y-auto">
            @forelse($recentTransactions as $trx)
            <div class="px-6 py-4 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-slate-800 truncate">{{ $trx->customer_name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ $trx->event->title ?? '—' }} · {{ $trx->created_at->format('d M y') }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="font-black text-indigo-600 text-sm">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                    @if(in_array($trx->status, ['settlement','success']))
                        <span class="text-[10px] font-bold text-green-600">SUCCESS</span>
                    @elseif($trx->status === 'pending')
                        <span class="text-[10px] font-bold text-amber-600">PENDING</span>
                    @else
                        <span class="text-[10px] font-bold text-red-600">{{ strtoupper($trx->status) }}</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada transaksi.</div>
            @endforelse
        </div>
    </div>
</div>

@endsection
