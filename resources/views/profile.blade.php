@extends('layouts.main')

@section('title', 'Profil Saya - AmikomEventHub')

@section('content')
<div class="max-w-xl mx-auto px-6 py-12">
    <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100 text-center">
        <img src="https://ui-avatars.com/api/?name=Praktikan&background=4f46e5&color=fff&size=128" alt="Foto Profil" class="w-24 h-24 mx-auto rounded-full mb-4 border-4 border-indigo-100 shadow-md">
        
        <h1 class="text-2xl font-extrabold text-slate-900 mb-1">Nama Praktikan</h1>
        <p class="text-indigo-600 font-semibold text-sm mb-4">Mahasiswa / Web Developer</p>
        <p class="text-slate-500 mb-8 text-sm leading-relaxed">Halo! Ini adalah halaman profil saya di AmikomEventHub. Platform event terbaik untuk reservasi tiket & seminar.</p>

        <div class="pt-4 border-t border-slate-100 flex justify-center gap-4">
            <a href="{{ route('home') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-xl hover:bg-indigo-700 transition shadow-md shadow-indigo-200">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection