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
        <th class="px-8 py-4">Nama Partner</th>
        <th class="px-8 py-4">Aksi</th>
    </tr>
</thead>
<tbody class="divide-y border-t">
    @forelse($partners as $index => $partner)
    <tr class="hover:bg-slate-50/50 transition">
    <td class="px-8 py-6">{{ $partners->firstItem() + $index }}</td>
    <td class="px-8 py-6">
        @if($partner->logo_url)
            <img src="{{ asset('storage/' . $partner->logo_url) }}" class="w-20 h-20 rounded-xl object-contain border p-1">
        @else
            <div class="w-20 h-20 bg-slate-100 rounded-xl flex items-center justify-center">No Logo</div>
        @endif
    </td>
    <td class="px-8 py-6 font-black text-slate-800">{{ $partner->name }}</td>
    <td class="px-8 py-6">
        <div class="flex gap-2">
            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">Edit</a>
            
            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                @csrf @method('DELETE')
                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">Hapus</button>
            </form>
        </div>
    </td>
</tr>
    @empty
    <tr><td colspan="4" class="text-center py-10">Data kosong.</td></tr>
    @endforelse
</tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-slate-50/50 border-t items-center">
        {{ $partners->links() }}
    </div>
</div>
@endsection
