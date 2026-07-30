@extends('layouts.admin')
@section('title', 'Profil Organisasi')
@section('page_title', 'Profil Organisasi')
@section('page_subtitle', 'Kelola informasi & identitas organisasimu')

@section('content')
@php $org = auth()->user()->organization; @endphp

<div class="max-w-3xl">

    {{-- Info Status Approval --}}
    @if($org->status === 'approved')
    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-6 flex items-center gap-3">
        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p class="font-bold text-green-800 text-sm">Organisasi Anda Sudah Aktif</p>
            <p class="text-green-600 text-xs">Anda dapat membuat dan mengelola event.</p>
        </div>
    </div>
    @elseif($org->status === 'pending')
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6 flex items-center gap-3">
        <div class="w-8 h-8 bg-amber-400 rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="font-bold text-amber-800 text-sm">Menunggu Persetujuan Superadmin</p>
            <p class="text-amber-600 text-xs">Akun Anda sedang dalam proses review. Mohon tunggu.</p>
        </div>
    </div>
    @endif

    {{-- Form Edit Profil --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b">
            <h2 class="font-black text-lg">Informasi Organisasi</h2>
            <p class="text-slate-400 text-sm mt-0.5">Perubahan akan terlihat di profil publik organisasimu.</p>
        </div>

        <form action="{{ route('admin.org.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Logo --}}
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-indigo-100 flex items-center justify-center overflow-hidden border-2 border-indigo-200 flex-shrink-0">
                    @if($org->logo_path)
                        <img src="{{ Storage::url($org->logo_path) }}" id="logo-preview" class="w-full h-full object-cover">
                    @else
                        <img id="logo-preview" class="w-full h-full object-cover hidden">
                        <span id="logo-placeholder" class="text-indigo-700 font-black text-xl">{{ strtoupper(substr($org->name, 0, 2)) }}</span>
                    @endif
                </div>
                <div>
                    <label for="logo" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Upload Logo
                    </label>
                    <input type="file" id="logo" name="logo" class="hidden" accept="image/*" onchange="previewLogo(event)">
                    <p class="text-slate-400 text-xs mt-2">JPG, PNG, atau GIF. Maksimal 2MB.</p>
                    @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Nama Organisasi --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Organisasi <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $org->name) }}"
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium text-slate-800 transition"
                    placeholder="Contoh: HMSSI Amikom Yogyakarta" required>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-slate-800 resize-none transition"
                    placeholder="Ceritakan tentang organisasimu...">{{ old('description', $org->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Info Read-Only --}}
            <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email Admin</p>
                    <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Didaftarkan</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $org->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Slug</p>
                    <p class="text-sm font-mono text-slate-600">{{ $org->slug }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Event</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $org->events()->count() }} Event</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-2xl font-semibold text-sm hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition shadow-sm hover:shadow-indigo-200/50 hover:shadow-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewLogo(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('logo-preview');
        const placeholder = document.getElementById('logo-placeholder');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
