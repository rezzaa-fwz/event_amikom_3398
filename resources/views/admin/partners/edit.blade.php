@extends('layouts.admin')
@section('content')
<div class="bg-white rounded-[2.5rem] p-8 max-w-3xl">
    <form method="POST" action="{{ route('admin.partners.update', $partner->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-bold text-slate-600 mb-2">Nama Partner *</label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" required class="w-full px-4 py-3 rounded-xl border">
        </div>
        
        @if($partner->logo_url)
        <div class="mb-4">
            <label class="block text-sm font-bold text-slate-600 mb-2">Logo Saat Ini</label>
            <img src="{{ asset('storage/' . $partner->logo_url) }}" class="w-24 h-24 rounded-xl object-contain border">
        </div>
        @endif

        <div>
            <label class="block text-sm font-bold text-slate-600 mb-2">Ganti Logo</label>
            <input type="file" name="logo" class="w-full px-4 py-3 rounded-xl border">
        </div>
        
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold">Perbarui</button>
            <a href="{{ route('admin.partners.index') }}" class="px-8 py-3 bg-slate-200 rounded-xl">Batal</a>
        </div>
    </form>
</div>
@endsection