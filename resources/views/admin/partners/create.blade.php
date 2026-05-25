@extends('layouts.admin')
@section('title', 'Tambah Partner - Admin')

@section('page_title', 'Tambah Partner Baru')
@section('page_subtitle', ' Tambahkan data partner dan kolaborator baru.')
@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 max-w-3xl">
    <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-sm font-bold text-slate-600 mb-2">Nama Partner *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Partner Type -->
        <div>
            <label class="block text-sm font-bold text-slate-600 mb-2">Jenis Partner *</label>
            <select name="type" required
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition @error('type') border-red-500 @enderror">
                <option value="">Pilih Jenis Partner</option>
                @foreach(['Media Partner', 'Sponsorship', 'Community Partner', 'Technology Partner', 'Venue Partner'] as $type)
                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Logo -->
        <div>
            <label class="block text-sm font-bold text-slate-600 mb-2">Logo Partner</label>
            <input type="file" name="logo" accept="image/*"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition @error('logo') border-red-500 @enderror">
            <p class="text-xs text-slate-400 mt-1">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</p>
            @error('logo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-bold text-slate-600 mb-2">Deskripsi</label>
            <textarea name="description" rows="4"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Website -->
        <div>
            <label class="block text-sm font-bold text-slate-600 mb-2">Website</label>
            <input type="url" name="website" value="{{ old('website') }}"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition @error('website') border-red-500 @enderror"
                placeholder="https://example.com">
            @error('website')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contact Email & Phone -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2">Email Kontak</label>
                <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition @error('contact_email') border-red-500 @enderror">
                @error('contact_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2">Nomor Telepon</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition @error('contact_phone') border-red-500 @enderror">
                @error('contact_phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Active Status -->
        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            <label for="is_active" class="text-sm font-bold text-slate-700">Aktif</label>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 active:scale-95 transition">
                Simpan
            </button>
            <a href="{{ route('admin.partners.index') }}" class="px-8 py-3 bg-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-300 active:scale-95 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
