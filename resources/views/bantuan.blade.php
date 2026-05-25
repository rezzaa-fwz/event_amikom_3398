<!DOCTYPE html>
<html lang="id">
<head>
    <title>Halaman Bantuan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-slate-200 max-w-md w-full transition duration-300 hover:shadow-xl">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl font-bold">?</div>
            <h1 class="text-2xl font-bold text-slate-800 mb-1">Pusat Bantuan</h1>
            <p class="text-slate-500 text-sm">Frequently Asked Questions (FAQ)</p>
        </div>

        <div class="space-y-3 mb-8">
            <div class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700">Bagaimana cara mendaftar event?</h4>
                <p class="text-xs text-slate-500 mt-1">Anda bisa memilih event di halaman Katalog, lalu menekan tombol "Daftar".</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700">Apakah event berbayar?</h4>
                <p class="text-xs text-slate-500 mt-1">Terdapat event gratis maupun berbayar. Detail harga tertera di katalog.</p>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-2 border-t border-slate-100 pt-5">
            <a href="/" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Home</a>
            <a href="/profil" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Profil</a>
            <a href="/katalog" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Katalog</a>
            <a href="/bantuan" class="text-xs bg-indigo-600 text-white py-2 px-3 rounded-lg shadow-md transition duration-300">Bantuan</a>
            <a href="/kontak" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Kontak</a>
        </div>
    </div>
</body>
</html>