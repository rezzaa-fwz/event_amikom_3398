@extends('layouts.admin')
@section('title', 'Akun Menunggu Persetujuan')
@section('page_title', 'Menunggu Persetujuan')
@section('page_subtitle', 'Akun organisasi Anda sedang dalam proses review.')

@section('content')
<div class="max-w-2xl mx-auto text-center py-16">

    {{-- Ilustrasi --}}
    <div class="w-28 h-28 mx-auto bg-amber-100 rounded-full flex items-center justify-center mb-8 shadow-inner">
        <svg class="w-14 h-14 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-3xl font-black text-slate-900 mb-3">Pendaftaran Sedang Diproses</h1>
    <p class="text-slate-500 font-medium text-lg mb-2">Halo, <strong class="text-slate-700">{{ auth()->user()->name }}</strong>!</p>
    <p class="text-slate-400 leading-relaxed mb-8">
        Organisasi <strong class="text-slate-700">{{ auth()->user()->organization->name ?? 'Anda' }}</strong> telah berhasil didaftarkan dan sedang menunggu persetujuan dari Superadmin platform. Proses ini biasanya membutuhkan waktu <strong>1–2 hari kerja</strong>.
    </p>

    <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6 text-left mb-8">
        <h3 class="font-black text-amber-800 mb-3">Apa yang Terjadi Selanjutnya?</h3>
        <ul class="space-y-2 text-sm text-amber-700">
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Superadmin akan me-review informasi organisasimu
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Setelah disetujui, kamu bisa langsung membuat & mengelola event
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Kamu akan mendapatkan akses ke dashboard analitik & laporan pendapatan
            </li>
        </ul>
    </div>

    <form action="{{ route('admin.logout') }}" method="POST" class="inline-block">
        @csrf
        <button type="submit" class="px-8 py-3 border-2 border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition">
            Keluar & Coba Login Kembali
        </button>
    </form>
</div>
@endsection
