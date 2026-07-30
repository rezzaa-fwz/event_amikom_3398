@extends('layouts.admin')
@section('title', 'Kelola Organisasi')
@section('page_title', 'Kelola Organisasi')
@section('page_subtitle', 'Approve atau tangguhkan kepanitiaan/HIMA yang mendaftar di platform.')

@section('content')

{{-- Filter Status --}}
<div class="flex gap-2 mb-6">
    @foreach(['all' => 'Semua', 'pending' => '⏳ Pending', 'approved' => '✓ Approved', 'suspended' => '⛔ Suspended'] as $val => $label)
    <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
        class="px-4 py-2 rounded-xl text-sm font-bold transition border
            {{ (request('status', 'all') === $val)
                ? 'bg-indigo-600 text-white border-indigo-600'
                : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-300' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-6 py-4">Organisasi</th>
                    <th class="px-6 py-4">Pemilik Akun</th>
                    <th class="px-6 py-4 text-center">Event</th>
                    <th class="px-6 py-4 text-center">Tiket Terjual</th>
                    <th class="px-6 py-4 text-right">Revenue</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($organizations as $org)
                <tr class="hover:bg-slate-50 transition group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if($org->logo_path)
                                    <img src="{{ Storage::url($org->logo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-indigo-700 font-black text-xs">{{ strtoupper(substr($org->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('admin.organizations.show', $org) }}" class="font-bold text-slate-800 hover:text-indigo-600 transition">
                                    {{ $org->name }}
                                </a>
                                <p class="text-xs text-slate-400 font-mono">{{ $org->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-slate-700">{{ $org->owner->name ?? '—' }}</p>
                        <p class="text-xs text-slate-400">{{ $org->owner->email ?? '' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-bold text-slate-800">{{ $org->events_count }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-bold text-slate-800">{{ number_format($org->tickets_sold, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="font-black text-indigo-600 whitespace-nowrap">
                            Rp {{ number_format($org->total_revenue, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if ($org->status === 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-black">✓ Approved</span>
                        @elseif ($org->status === 'pending')
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-black animate-pulse">⏳ Pending</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-black">⛔ Suspended</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.organizations.show', $org) }}"
                                class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-200 transition whitespace-nowrap">
                                Detail
                            </a>
                            @if ($org->status !== 'approved')
                            <form action="{{ route('admin.organizations.approve', $org) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition whitespace-nowrap">
                                    Approve
                                </button>
                            </form>
                            @endif
                            @if ($org->status !== 'suspended')
                            <form action="{{ route('admin.organizations.suspend', $org) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1.5 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition whitespace-nowrap">
                                    Suspend
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <svg class="w-14 h-14 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/></svg>
                        <p class="text-slate-400 font-medium">Belum ada organisasi yang mendaftar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $organizations->links() }}
</div>
@endsection