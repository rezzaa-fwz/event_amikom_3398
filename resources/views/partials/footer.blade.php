<footer class="bg-[#1e1b4b] text-indigo-200 py-16 px-6 mt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
        <!-- Brand Info -->
        <div class="space-y-4 col-span-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-extrabold text-lg shadow-md">
                    AH
                </div>
                <span class="text-xl font-bold text-white tracking-tight">AmikomEventHub</span>
            </a>
            <p class="text-sm text-indigo-300 leading-relaxed max-w-xs">
                Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional.
            </p>
        </div>

        <!-- Kategori -->
        <div>
            <h4 class="text-white font-bold text-base mb-5">Kategori</h4>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ url('/katalog?category=seminar-it') }}" class="hover:text-white transition">Seminar IT</a></li>
                <li><a href="{{ url('/katalog?category=entertainement') }}" class="hover:text-white transition">Entertaiment</a></li>
                <li><a href="{{ url('/katalog?category=musik') }}" class="hover:text-white transition">musik</a></li>
                <li><a href="{{ url('/katalog?category=futsal') }}" class="hover:text-white transition">futsal</a></li>
            </ul>
        </div>

        <!-- Navigasi Akses -->
        <div>
            <h4 class="text-white font-bold text-base mb-5">Navigasi Akses</h4>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-white transition">Login Customer</a></li>
                <li><a href="{{ route('organizations.register') }}" class="hover:text-white transition">Login Partner / Panitia</a></li>
                <li><a href="{{ route('admin.login') }}" class="hover:text-white transition">Login Admin Panel</a></li>
            </ul>
        </div>

        <!-- Hubungi Kami -->
        <div>
            <h4 class="text-white font-bold text-base mb-5">Hubungi Kami</h4>
            <ul class="space-y-3 text-sm">
                <li class="hover:text-white transition">support@eventtiket.com</li>
                <li class="hover:text-white transition">+62 812 3456 7890</li>
            </ul>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pt-10 mt-12 border-t border-indigo-900/60 text-center text-xs text-indigo-400">
        &copy; 2024 AmikomEventHub. Built with Laravel &amp; Tailwind CSS.
    </div>
</footer>
