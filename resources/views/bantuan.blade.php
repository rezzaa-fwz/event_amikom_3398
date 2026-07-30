@extends('layouts.main')

@section('title', 'Pusat Bantuan - AmikomEventHub')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl font-bold">?</div>
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Pusat Bantuan</h1>
            <p class="text-slate-500 text-sm">Frequently Asked Questions (FAQ)</p>
        </div>

        <div class="space-y-4 mb-8">
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <h4 class="text-base font-bold text-slate-800">Bagaimana cara mendaftar event?</h4>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">Anda bisa memilih event di halaman Jelajahi atau Katalog, lalu tekan tombol "Pesan Sekarang" atau "Daftar".</p>
            </div>
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <h4 class="text-base font-bold text-slate-800">Apakah event berbayar?</h4>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">Terdapat event gratis maupun berbayar. Detail harga tertera di halaman detail masing-masing event.</p>
            </div>
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <h4 class="text-base font-bold text-slate-800">Bagaimana metode pembayarannya?</h4>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">Kami terintegrasi dengan Payment Gateway Midtrans yang mendukung Transfer Bank, QRIS, E-Wallet, dan GoPay.</p>
            </div>
        </div>
    </div>
</div>
@endsection