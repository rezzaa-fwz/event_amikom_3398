@extends('layouts.main')

@section('title', 'Daftarkan Organisasi — AmikomEventHub')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-indigo-50 to-slate-50 py-16">
    <div class="max-w-xl mx-auto px-6">

        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="w-16 h-16 mx-auto bg-indigo-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-indigo-200">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/>
                </svg>
            </div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">Daftarkan Kepanitiaan / HIMA</h1>
            <p class="text-slate-500 font-medium">Buat akun penyelenggara dan kelola event kamu sendiri di platform AmikomEventHub.</p>
        </div>

        {{-- Success Banner --}}
        @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 font-semibold text-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-bold">Pendaftaran Berhasil! 🎉</p>
                <p class="text-green-600 mt-1">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Error Banner --}}
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6 text-sm">
            <p class="font-bold mb-2">Terjadi Kesalahan:</p>
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $error }}
                </p>
            @endforeach
        </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">

            {{-- Step 1: Info Organisasi --}}
            <div class="px-8 pt-8 pb-5">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-indigo-100 text-indigo-700 rounded-lg flex items-center justify-center font-black text-sm">1</div>
                    <h2 class="font-black text-slate-800">Informasi Organisasi</h2>
                </div>

                <form action="{{ route('organizations.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kepanitiaan / HIMA <span class="text-red-500">*</span></label>
                        <input type="text" name="organization_name" value="{{ old('organization_name') }}" required
                            placeholder="Contoh: HMSSI Amikom Yogyakarta"
                            class="w-full px-4 py-3.5 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-medium text-slate-800 transition placeholder-slate-300">
                        <p class="text-xs text-slate-400 mt-1.5">Nama resmi organisasi yang akan tampil di platform.</p>
                    </div>
            </div>

            {{-- Divider --}}
            <div class="h-px bg-slate-100 mx-8"></div>

            {{-- Step 2: Admin --}}
            <div class="px-8 pt-5 pb-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-indigo-100 text-indigo-700 rounded-lg flex items-center justify-center font-black text-sm">2</div>
                    <h2 class="font-black text-slate-800">Akun Admin Penanggung Jawab</h2>
                </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="admin_name" value="{{ old('admin_name') }}" required
                                placeholder="Nama lengkap Anda"
                                class="w-full px-4 py-3.5 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-medium text-slate-800 transition placeholder-slate-300">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="admin_email" value="{{ old('admin_email') }}" required
                                placeholder="admin@organisasi.com"
                                class="w-full px-4 py-3.5 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-medium text-slate-800 transition placeholder-slate-300">
                            <p class="text-xs text-slate-400 mt-1.5">Email ini akan digunakan untuk login ke dashboard admin.</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi <span class="text-red-500">*</span></label>
                                <input type="password" name="admin_password" required minlength="8"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full px-4 py-3.5 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-medium text-slate-800 transition placeholder-slate-300">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Sandi <span class="text-red-500">*</span></label>
                                <input type="password" name="admin_password_confirmation" required minlength="8"
                                    placeholder="Ulangi kata sandi"
                                    class="w-full px-4 py-3.5 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none font-medium text-slate-800 transition placeholder-slate-300">
                            </div>
                        </div>
                    </div>

                    {{-- Info box --}}
                    <div class="mt-6 p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div class="text-sm text-indigo-700">
                                <p class="font-bold">Setelah mendaftar:</p>
                                <ul class="mt-1 space-y-0.5 text-indigo-600">
                                    <li>• Akun akan masuk antrian review Superadmin</li>
                                    <li>• Proses approval biasanya 1–2 hari kerja</li>
                                    <li>• Setelah disetujui, Anda langsung bisa login & kelola event</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-6 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-base hover:bg-indigo-700 transition shadow-lg shadow-indigo-200/50 hover:shadow-indigo-300/50 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Daftarkan Organisasi
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom Link --}}
        <div class="text-center mt-8">
            <p class="text-slate-400 text-sm">Sudah punya akun organisasi? <a href="{{ route('admin.login') }}" class="text-indigo-600 font-bold hover:underline">Login di sini →</a></p>
        </div>
    </div>
</div>
@endsection