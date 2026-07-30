@extends('layouts.main')

@section('title', 'Katalog Event - AmikomEventHub')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100 mb-8 text-center max-w-2xl mx-auto">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Katalog Event</h1>
        <p class="text-slate-500 mb-8 text-sm">Temukan berbagai event menarik, workshop, dan seminar di AmikomEventHub.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8 text-left">
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-indigo-300 hover:shadow-md transition duration-300 cursor-pointer">
                <div class="bg-indigo-100 h-24 rounded-xl mb-4 flex items-center justify-center text-3xl">💻</div>
                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 rounded-md text-xs font-bold uppercase">Workshop</span>
                <h3 class="text-base font-bold text-slate-800 mt-2">Workshop Laravel Advanced</h3>
                <p class="text-xs text-slate-400 mt-1">20 Mei 2026</p>
            </div>
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-indigo-300 hover:shadow-md transition duration-300 cursor-pointer">
                <div class="bg-emerald-100 h-24 rounded-xl mb-4 flex items-center justify-center text-3xl">🎨</div>
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-md text-xs font-bold uppercase">Seminar</span>
                <h3 class="text-base font-bold text-slate-800 mt-2">Seminar UI/UX & Design System</h3>
                <p class="text-xs text-slate-400 mt-1">25 Mei 2026</p>
            </div>
        </div>
    </div>
</div>
@endsection