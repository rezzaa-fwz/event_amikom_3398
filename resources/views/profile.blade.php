<!DOCTYPE html>
<html lang="id">
<head>
    <title>Halaman Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-slate-200 text-center max-w-md w-full transition duration-300 hover:shadow-xl">
        <img src="https://ui-avatars.com/api/?name=Praktikan&background=4f46e5&color=fff&size=128" alt="Foto Profil" class="w-24 h-24 mx-auto rounded-full mb-4 border-4 border-indigo-100">
        
        <h1 class="text-2xl font-bold text-slate-800 mb-1">Nama Praktikan</h1>
        <p class="text-indigo-600 font-medium text-sm mb-4">Mahasiswa / Web Developer</p>
        <p class="text-slate-500 mb-8 text-sm leading-relaxed">Halo! Ini adalah halaman profil saya. Saya sedang mempelajari routing Laravel dan integrasi Tailwind CSS untuk AmikomEventHub.</p>

        <div class="flex flex-wrap justify-center gap-2 border-t border-slate-100 pt-5">
            <a href="/" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Home</a>
            <a href="/profil" class="text-xs bg-indigo-600 text-white py-2 px-3 rounded-lg shadow-md transition duration-300">Profil</a>
            <a href="/katalog" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Katalog</a>
            <a href="/bantuan" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Bantuan</a>
            <a href="/kontak" class="text-xs bg-slate-100 text-slate-600 py-2 px-3 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md transition duration-300">Kontak</a>
        </div>
    </div>
</body>
</html>