@extends('layouts.admin')
@section('title', 'Akun Ditangguhkan')
@section('page_title', 'Akun Ditangguhkan')
@section('page_subtitle', 'Akses organisasi Anda sementara dinonaktifkan.')

@section('content')
<div class="max-w-2xl mx-auto text-center py-16">

    {{-- Ilustrasi --}}
    <div class="w-28 h-28 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-8 shadow-inner">
        <svg class="w-14 h-14 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
        </svg>
    </div>

    <h1 class="text-3xl font-black text-slate-900 mb-3">Akun Organisasi Ditangguhkan</h1>
    <p class="text-slate-500 font-medium text-lg mb-2">Halo, <strong class="text-slate-700">{{ auth()->user()->name }}</strong></p>
    <p class="text-slate-400 leading-relaxed mb-8">
        Organisasi <strong class="text-slate-700">{{ auth()->user()->organization->name ?? 'Anda' }}</strong> telah ditangguhkan oleh Superadmin platform. Selama masa penangguhan, Anda tidak dapat mengakses dashboard maupun mengelola event.
    </p>

    <div class="bg-red-50 border border-red-200 rounded-3xl p-6 text-left mb-8">
        <h3 class="font-black text-red-800 mb-3">Apa yang Dapat Dilakukan?</h3>
        <ul class="space-y-2 text-sm text-red-700">
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Hubungi Superadmin untuk mengetahui alasan penangguhan
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Setelah masalah diselesaikan, Superadmin dapat mengaktifkan kembali akun Anda
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Data event dan transaksi Anda tetap tersimpan dengan aman
            </li>
        </ul>
    </div>

    <a href="mailto:admin@amikomevents.com" class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-sm mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        Hubungi Admin
    </a>

    <div class="mt-4">
        <form action="{{ route('admin.logout') }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="px-8 py-3 border-2 border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition">
                Keluar
            </button>
        </form>
    </div>
</div>
@endsection
