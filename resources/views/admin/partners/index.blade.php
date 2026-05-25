@extends('layouts.admin')
@section('title', 'Kelola Partner - Admin')

@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Kelola data partner dan kolaborator di sini.')
@section('content')
<div class="mb-6 flex justify-between items-center gap-4">
    <!-- Search Form on Left -->
    <form method="GET" action="{{ route('admin.partners.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari partner..."
            class="px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition min-w-[300px]">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 active:scale-95 transition">
            Cari
        </button>
        @if(request('search'))
        <a href="{{ route('admin.partners.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-300 active:scale-95 transition">
            Reset
        </a>
        @endif
    </form>

    <!-- Tambah Partner Button on Right -->
    <a href="{{ route('admin.partners.create') }}" class="inline-block px-6 py-3
        bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100
        hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Partner Baru
    </a>
</div>

<!-- Partners Table -->
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Partner</th>
                    <th class="px-8 py-4">Kontak</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $partners->firstItem() + $index }}</td>
                    <td class="px-8 py-6">
                        @if($partner->logo_path)
                        <img src="{{ asset('storage/' . $partner->logo_path) }}" class="w-20 h-20 rounded-xl object-contain border border-slate-200 p-1" alt="{{ $partner->name }}">
                        @else
                        <div class="w-20 h-20 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">{{ $partner->name }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-bold bg-indigo-100 text-indigo-700">{{ $partner->type ?? 'Umum' }}</span>
                        @if($partner->website)
                        <a href="{{ $partner->website }}" target="_blank" class="block text-xs text-indigo-500 hover:underline">
                            {{ parse_url($partner->website, PHP_URL_HOST) }}
                        </a>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        @if($partner->contact_email)
                        <p class="text-sm text-slate-600">{{ $partner->contact_email }}</p>
                        @endif
                        @if($partner->contact_phone)
                        <p class="text-sm text-slate-600">{{ $partner->contact_phone }}</p>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $partner->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $partner->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-500">Belum ada partner yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-slate-50/50 border-t items-center">
        {{ $partners->links() }}
    </div>
</div>
@endsection
