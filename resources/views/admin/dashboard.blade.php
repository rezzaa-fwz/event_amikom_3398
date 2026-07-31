@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', auth()->user()->isSuperAdmin() ? 'Dashboard Global' : 'Dashboard Organisasi')
@section('page_subtitle',
    auth()->user()->isSuperAdmin()
        ? 'Ringkasan platform AmikomEventHub secara keseluruhan'
        : 'Analitik & performa organisasi ' . (auth()->user()->organization->name ?? '')
)

@section('content')

{{-- Banner Identitas Organisasi (untuk admin tenant) --}}
@if(!auth()->user()->isSuperAdmin() && auth()->user()->organization)
@php $org = auth()->user()->organization; @endphp
<div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-3xl p-6 mb-8 flex items-center gap-5 shadow-lg">
    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0 overflow-hidden">
        @if($org->logo_path)
            <img src="{{ (str_starts_with($org->logo_path ?? '', 'http') ? $org->logo_path : Storage::url($org->logo_path)) }}" class="w-full h-full object-cover rounded-2xl">
        @else
            <span class="text-white font-black text-xl">{{ strtoupper(substr($org->name, 0, 2)) }}</span>
        @endif
    </div>
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-black truncate">{{ $org->name }}</h2>
        <p class="text-indigo-200 text-sm mt-0.5">{{ $org->description ?? 'Kelola event & analitik organisasimu di sini.' }}</p>
    </div>
    <div class="text-right flex-shrink-0">
        <p class="text-indigo-200 text-xs font-medium mb-1">Status Akun</p>
        <span class="inline-block px-4 py-1.5 bg-green-400 text-green-900 rounded-full text-sm font-black">✓ Aktif</span>
    </div>
</div>
@endif

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="stat-card group">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        <p class="text-xs text-green-600 font-semibold mt-2">Dari tiket yang terbayar lunas</p>
    </div>

    <div class="stat-card group">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
        </div>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tiket Terjual</p>
        <h3 class="text-2xl font-black text-slate-900">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
        <p class="text-xs text-green-600 font-semibold mt-2">Transaksi berhasil</p>
    </div>

    <div class="stat-card group">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-orange-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Event Aktif</p>
        <h3 class="text-2xl font-black text-slate-900">{{ $activeEvents }}</h3>
        <p class="text-xs text-orange-600 font-semibold mt-2">Event mendatang</p>
    </div>

    <div class="stat-card group">
        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-rose-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Pesanan Pending</p>
        <h3 class="text-2xl font-black text-slate-900">{{ $pendingOrders }}</h3>
        <p class="text-xs text-rose-600 font-semibold mt-2">Belum dibayar / expired</p>
    </div>
</div>

{{-- Superadmin: ringkasan per-org --}}
@if(auth()->user()->isSuperAdmin())
<div class="bg-amber-50 border border-amber-200 rounded-3xl p-6 mb-8 flex items-start gap-4">
    <div class="w-10 h-10 bg-amber-400 rounded-xl flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
    </div>
    <div>
        <h3 class="font-black text-amber-900 text-base">Mode Superadmin Aktif</h3>
        <p class="text-amber-700 text-sm mt-0.5">Anda melihat data dari <strong>seluruh organisasi</strong> di platform. Gunakan menu "Kelola Organisasi" untuk approve/suspend kepanitiaan.
            @php $pendingOrgs = \App\Models\Organization::where('status','pending')->count(); @endphp
            @if($pendingOrgs > 0)
                <a href="{{ route('admin.organizations.index') }}" class="underline font-bold">Ada {{ $pendingOrgs }} organisasi menunggu approval →</a>
            @endif
        </p>
    </div>
</div>
@endif

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <h3 class="font-black text-lg mb-1">Pertumbuhan Event</h3>
        <p class="text-slate-400 text-xs mb-6">Jumlah event baru per bulan, 6 bulan terakhir</p>
        <canvas id="eventGrowthChart" height="220"></canvas>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <h3 class="font-black text-lg mb-1">Tren Pendapatan</h3>
        <p class="text-slate-400 text-xs mb-6">Total pendapatan per bulan, 6 bulan terakhir</p>
        <canvas id="revenueTrendChart" height="220"></canvas>
    </div>
</div>

{{-- Tabel Transaksi Terakhir --}}
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-8 py-6 border-b flex justify-between items-center">
        <div>
            <h3 class="font-black text-xl">Transaksi Terakhir</h3>
            <p class="text-slate-400 text-sm font-medium">5 transaksi terkini</p>
        </div>
        <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline text-sm flex items-center gap-1">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Tanggal & ID</th>
                    <th class="px-8 py-4">Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentTransactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-5 text-sm text-slate-600">
                        {{ $trx->created_at->format('d M y · H:i') }}<br>
                        <span class="text-xs text-slate-400 font-mono">{{ $trx->order_id }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-bold text-sm truncate max-w-[140px]">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-[140px]">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-medium max-w-xs truncate">
                        {{ $trx->event->title ?? '—' }}
                    </td>
                    <td class="px-8 py-5">
                        @if(in_array($trx->status, ['settlement','success']))
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">SUCCESS</span>
                        @elseif($trx->status === 'pending')
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold">PENDING</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold">{{ strtoupper($trx->status) }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 font-black text-indigo-600 text-right whitespace-nowrap">
                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-14 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const eventGrowthData = @json($eventGrowth);
    const revenueTrendData = @json($revenueTrend);

    new Chart(document.getElementById('eventGrowthChart'), {
        type: 'bar',
        data: {
            labels: eventGrowthData.map(i => i.label),
            datasets: [{ label: 'Event Dibuat', data: eventGrowthData.map(i => i.count), backgroundColor: '#6366f1', borderRadius: 8 }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    new Chart(document.getElementById('revenueTrendChart'), {
        type: 'line',
        data: {
            labels: revenueTrendData.map(i => i.label),
            datasets: [{ label: 'Pendapatan', data: revenueTrendData.map(i => i.total), borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.08)', tension: 0.4, fill: true, pointBackgroundColor: '#22c55e', pointRadius: 5 }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } }
        }
    });
</script>
@endsection