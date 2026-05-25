<!DOCTYPE html>
<html lang="id">
<head>
    <title>Halaman Katalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-slate-200 text-center max-w-lg w-full transition duration-300 hover:shadow-xl">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Katalog Event</h1>
        <p class="text-slate-500 mb-6 text-sm">Temukan event menarik di AmikomEventHub.</p>

        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 hover:border-indigo-300 hover:shadow-md transition duration-300 cursor-pointer">
                <div class="bg-indigo-100 h-16 rounded-lg mb-3 flex items-center justify-center text-2xl"></div>
                <h3 class="text-sm font-bold text-slate-700">Workshop Laravel</h3>
                <p class="text-xs text-slate-400 mt-1">20 Mei 2026</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 hover:border-indigo-300 hover:shadow-md transition duration-300 cursor-pointer">
                <div class="bg-emerald-100 h-16 rounded-lg mb-3 flex items-center justify-center text-2xl"></div>
                <h3 class="text-sm font-bold text-slate-700">Seminar UI/UX</h3>
                <p class="text-xs text-slate-400 mt-1">25 Mei 2026</p>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-2 border-t border-slate-100 pt-5">
            <a href="/" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Home</a>
            <a href="/profil" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Profil</a>
            <a href="/katalog" class="text-xs bg-indigo-600 text-white py-2 px-3 rounded-lg shadow-md transition duration-300">Katalog</a>
            <a href="/bantuan" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Bantuan</a>
            <a href="/kontak" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Kontak</a>
        </div>
    </div>
</body>
</html>