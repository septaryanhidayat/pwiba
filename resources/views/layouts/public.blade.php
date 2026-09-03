<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PWI Kabupaten Banyuasin') - Persatuan Wartawan Indonesia</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS (Play CDN with custom config) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pwi: {
                            navy: '#0B132B',
                            dark: '#1C2541',
                            blue: '#1E3A8A',
                            accent: '#F59E0B',
                            gold: '#D97706',
                            teal: '#0EA5E9',
                            emerald: '#10B981',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
        }
        .glass-nav {
            background: rgba(11, 19, 43, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .glass-card-dark {
            background: rgba(28, 37, 65, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-gradient {
            background: linear-gradient(135deg, #FFFFFF 0%, #E2E8F0 50%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-gradient-gold {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-mesh {
            background-color: #0B132B;
            background-image: 
                radial-gradient(at 0% 0%, hsla(222,47%,11%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(217,91%,25%,0.5) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(38,92%,50%,0.2) 0, transparent 50%),
                radial-gradient(at 50% 100%, hsla(222,47%,11%,1) 0, transparent 50%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-amber-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Sticky Modern Glassmorphism Navbar -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo & Identity -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="relative flex items-center justify-center w-12 h-12 rounded-xl bg-white/10 p-1.5 ring-1 ring-white/20 group-hover:ring-amber-400/50 transition-all duration-300 shadow-lg">
                        <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo PWI" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold tracking-widest text-amber-400 uppercase">Portal Resmi</span>
                        <span class="text-lg font-extrabold tracking-tight text-white leading-tight">PWI BANYUASIN</span>
                        <span class="text-[10px] text-slate-400 hidden sm:block">Sumatera Selatan</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}#beranda" class="px-3.5 py-2 text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#profil" class="px-3.5 py-2 text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                        Profil & Visi
                    </a>
                    <a href="{{ route('home') }}#kepengurusan" class="px-3.5 py-2 text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                        Kepengurusan
                    </a>
                    <a href="{{ route('news.index') }}" class="px-3.5 py-2 text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                        Berita
                    </a>
                    <a href="{{ route('gallery.public') }}" class="px-3.5 py-2 text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                        Galeri
                    </a>
                    <a href="{{ route('members.public') }}" class="px-3.5 py-2 text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                        Direktori Anggota
                    </a>
                    <a href="{{ route('home') }}#bukutamu" class="px-3.5 py-2 text-sm font-medium text-amber-300 hover:text-amber-200 hover:bg-amber-400/10 rounded-lg transition-colors">
                        Buku Tamu
                    </a>
                </nav>

                <!-- Action Button & Login -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition-all duration-200">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Dashboard MIS</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-200 hover:text-white bg-white/10 hover:bg-white/15 border border-white/20 transition-all duration-200">
                            <i class="fa-solid fa-lock text-xs text-amber-400"></i>
                            <span>Login Admin</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-colors" aria-label="Toggle menu">
                        <i class="fa-solid text-xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden bg-slate-900/95 border-b border-white/10 px-4 pt-2 pb-6 space-y-2">
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#beranda" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-white/10 hover:text-white">Beranda</a>
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#profil" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-white/10 hover:text-white">Profil & Visi</a>
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#kepengurusan" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-white/10 hover:text-white">Kepengurusan</a>
            <a @click="mobileMenuOpen = false" href="{{ route('news.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-white/10 hover:text-white">Berita Terkini</a>
            <a @click="mobileMenuOpen = false" href="{{ route('gallery.public') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-white/10 hover:text-white">Galeri Kegiatan</a>
            <a @click="mobileMenuOpen = false" href="{{ route('members.public') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-white/10 hover:text-white">Direktori Anggota</a>
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#bukutamu" class="block px-3 py-2 rounded-lg text-base font-medium text-amber-300 hover:bg-amber-400/10">Buku Tamu Publik</a>
            
            <div class="pt-4 border-t border-white/10">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600">
                        <i class="fa-solid fa-gauge-high me-1"></i> Dashboard MIS
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-200 bg-white/10 border border-white/20">
                        <i class="fa-solid fa-lock text-xs text-amber-400 me-1"></i> Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Body Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Ultra-Modern Dark Footer -->
    <footer class="bg-[#0B132B] text-slate-300 border-t border-slate-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/10 via-transparent to-amber-900/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Col 1: Identity & Description (2 cols) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/10 p-2 ring-1 ring-white/20 flex items-center justify-center">
                            <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo PWI" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white leading-tight">PWI Kabupaten Banyuasin</h4>
                            <p class="text-xs text-amber-400 font-medium">Persatuan Wartawan Indonesia</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pr-4">
                        Wadah organisasi profesi jurnalis resmi dan terverifikasi di Kabupaten Banyuasin, Sumatera Selatan. Menjunjung tinggi kemerdekaan pers, integritas Kode Etik Jurnalistik, dan kemitraan strategis pembangunan daerah.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-white/15 flex items-center justify-center text-slate-300 hover:text-white transition-colors" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-white/15 flex items-center justify-center text-slate-300 hover:text-white transition-colors" aria-label="Instagram">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-white/15 flex items-center justify-center text-slate-300 hover:text-white transition-colors" aria-label="YouTube">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                        <a href="https://wa.me/6285377991976" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-white/15 flex items-center justify-center text-slate-300 hover:text-white transition-colors" aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="space-y-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Navigasi Cepat</h5>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('home') }}#beranda" class="hover:text-amber-400 transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('home') }}#profil" class="hover:text-amber-400 transition-colors">Visi & Misi</a></li>
                        <li><a href="{{ route('organization.public') }}" class="hover:text-amber-400 transition-colors">Susunan Pengurus</a></li>
                        <li><a href="{{ route('members.public') }}" class="hover:text-amber-400 transition-colors">Direktori Wartawan</a></li>
                        <li><a href="{{ route('gallery.public') }}" class="hover:text-amber-400 transition-colors">Galeri Dokumentasi</a></li>
                    </ul>
                </div>

                <!-- Col 3: News & Category -->
                <div class="space-y-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Kanal Publikasi</h5>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('news.index') }}?kategori=Kegiatan" class="hover:text-amber-400 transition-colors">Kegiatan Jurnalistik</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Kemitraan" class="hover:text-amber-400 transition-colors">Kemitraan & Forkopimda</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Organisasi" class="hover:text-amber-400 transition-colors">Internal Organisasi</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Olahraga" class="hover:text-amber-400 transition-colors">SIWO & Turnamen</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Hukum" class="hover:text-amber-400 transition-colors">Hukum & Advokasi</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Office Info -->
                <div class="space-y-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Sekretariat PWI</h5>
                    <div class="space-y-2.5 text-xs text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-amber-400 mt-0.5"></i>
                            <span>Jl. Merdeka No. 3 RT 02 RW 02 Kel. Mulya Agung, Kec. Banyuasin III, Kab. Banyuasin - Sumsel (30914)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-amber-400"></i>
                            <span>0853-7799-1976</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-amber-400"></i>
                            <span>sekretariat@pwibanyuasin.or.id</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="mt-12 pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} <strong>Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin</strong>. All rights reserved.</p>
                <p class="text-slate-500">Sistem Informasi Manajemen & Portal Jurnalistik v2.0</p>
            </div>
        </div>
    </footer>

</body>
</html>
