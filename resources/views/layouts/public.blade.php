<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PWI Kabupaten Banyuasin') - Persatuan Wartawan Indonesia</title>
    
    <!-- Favicon Resmi PWI Banyuasin -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/pwi-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/pwi-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'PWI Kabupaten Banyuasin') - Persatuan Wartawan Indonesia">
    <meta property="og:description" content="@yield('meta_description', 'Portal Resmi Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin. Informasi berita terkini, direktori insan pers terverifikasi, galeri kegiatan, dan layanan keabsahan surat digital.')">
    <meta property="og:image" content="{{ asset('assets/images/pwi-logo.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('assets/images/pwi-logo.png') }}">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="670">
    <meta property="og:image:type" content="image/png">
    <meta property="og:site_name" content="PWI Banyuasin">

    <!-- Twitter / X Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'PWI Kabupaten Banyuasin') - Persatuan Wartawan Indonesia">
    <meta name="twitter:description" content="@yield('meta_description', 'Portal Resmi Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin. Informasi berita terkini, direktori insan pers terverifikasi, dan layanan pers.')">
    <meta name="twitter:image" content="{{ asset('assets/images/pwi-logo.png') }}">

    <!-- Preload LCP Hero Image -->
    <link rel="preload" as="image" href="{{ asset('assets/images/wardoyo-ketua.webp') }}" type="image/webp" fetchpriority="high">

    <!-- Google Fonts: Plus Jakarta Sans (Non-render-blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"></noscript>
    
    <!-- FontAwesome 6 (Non-render-blocking) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    
    <!-- AOS Animation CSS (Non-render-blocking) -->
    <link rel="preload" href="https://unpkg.com/aos@2.3.1/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>
    
    <!-- Anti-FOUC Theme Initializer (Default: Light Mode) -->
    <script>
        if (localStorage.getItem('pwi_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS (Play CDN with custom config) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
        [x-cloak] { display: none !important; }
        @font-face {
            font-display: swap;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-rendering: optimizeLegibility;
        }
        img {
            content-visibility: auto;
        }
        .glass-nav {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .dark .glass-card {
            background: rgba(28, 37, 65, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-card-dark {
            background: rgba(28, 37, 65, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-gradient {
            background: linear-gradient(135deg, #0F172A 0%, #334155 50%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dark .text-gradient {
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
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float-slow {
            animation: floatSlow 6s ease-in-out infinite;
        }
        @keyframes subtlePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.02); }
        }
        .animate-subtle-pulse {
            animation: subtlePulse 3s ease-in-out infinite;
        }
        .hover-lift {
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        html, body {
            overflow-x: hidden !important;
            max-width: 100vw;
            width: 100%;
        }

        /* Fast, Crisp Fade-Up Keyframe (Vertical only, 0 horizontal shift, GPU accelerated) */
        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes orbGlow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.08); opacity: 0.8; }
        }
        @keyframes shimmerSlow {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .hero-badge-anim {
            animation: heroFadeUp 0.35s ease-out both;
        }
        .hero-title-anim {
            animation: heroFadeUp 0.35s ease-out 0.05s both;
        }
        .hero-desc-anim {
            animation: heroFadeUp 0.35s ease-out 0.1s both;
        }
        .hero-cta-anim {
            animation: heroFadeUp 0.35s ease-out 0.15s both;
        }
        .hero-stats-anim {
            animation: heroFadeUp 0.35s ease-out 0.2s both;
        }
        .hero-card-anim {
            animation: heroFadeUp 0.4s ease-out 0.1s both;
        }
        .animate-orb-glow {
            animation: orbGlow 8s ease-in-out infinite;
        }
        .animate-orb-glow-delayed {
            animation: orbGlow 10s ease-in-out 3s infinite;
        }
        .text-shimmer {
            background: linear-gradient(90deg, #F59E0B 0%, #FDE68A 50%, #D97706 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmerSlow 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased bg-slate-50 dark:bg-[#0B132B] text-slate-800 dark:text-slate-100 transition-colors duration-200 selection:bg-amber-500 selection:text-white" 
      x-data="{ 
          mobileMenuOpen: false, 
          isDark: document.documentElement.classList.contains('dark'),
          toggleTheme() {
              this.isDark = !this.isDark;
              if (this.isDark) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('pwi_theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('pwi_theme', 'light');
              }
          }
      }">

    <!-- Sticky Modern Glassmorphism Navbar -->
    <header class="sticky top-0 z-50 bg-white/90 dark:bg-[#0B132B]/90 glass-nav border-b border-slate-200/80 dark:border-white/10 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo & Identity -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="relative flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 dark:bg-white/10 p-1.5 ring-1 ring-slate-200 dark:ring-white/20 group-hover:ring-amber-500/50 transition-all duration-300 shadow-md">
                        <img src="{{ asset('assets/images/pwi-logo.webp') }}" alt="Logo PWI" width="48" height="48" class="w-full h-full object-contain" onerror="this.src='{{ asset('assets/images/pwi-logo.png') }}'">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold tracking-widest text-amber-600 dark:text-amber-400 uppercase">Portal Resmi</span>
                        <span class="text-lg font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">PWI BANYUASIN</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 hidden sm:block">Sumatera Selatan</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}#beranda" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:text-white dark:hover:bg-white/10 rounded-lg transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#profil" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:text-white dark:hover:bg-white/10 rounded-lg transition-colors">
                        Profil & Visi
                    </a>
                    <a href="{{ route('organization.public') }}" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:text-white dark:hover:bg-white/10 rounded-lg transition-colors">
                        Kepengurusan
                    </a>
                    <a href="{{ route('leaders.public') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('leaders.public') ? 'text-blue-600 dark:text-amber-400 font-bold bg-blue-50 dark:bg-white/10' : 'text-slate-700 hover:text-blue-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:text-white dark:hover:bg-white/10' }} rounded-lg transition-colors">
                        Sejarah
                    </a>
                    <a href="{{ route('news.index') }}" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:text-white dark:hover:bg-white/10 rounded-lg transition-colors">
                        Berita
                    </a>
                    <a href="{{ route('gallery.public') }}" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:text-white dark:hover:bg-white/10 rounded-lg transition-colors">
                        Galeri
                    </a>
                    @if((\App\Models\Setting::where('key', 'show_public_members')->value('value') ?? '0') === '1')
                    <a href="{{ route('members.public') }}" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-100 dark:text-slate-200 dark:hover:text-white dark:hover:bg-white/10 rounded-lg transition-colors">
                        Anggota
                    </a>
                    @endif
                    <a href="{{ route('home') }}#bukutamu" class="px-3 py-2 text-sm font-semibold text-amber-600 dark:text-amber-300 hover:bg-amber-500/10 rounded-lg transition-colors">
                        Buku Tamu
                    </a>
                </nav>

                <!-- Action Button, Theme Toggle & Login -->
                <div class="hidden md:flex items-center gap-2.5">
                    
                    <!-- Dark / Light Mode Toggle Button -->
                    <button @click="toggleTheme()" 
                            type="button" 
                            class="p-2.5 rounded-xl border border-slate-200 dark:border-white/15 bg-slate-100/80 hover:bg-slate-200 dark:bg-white/10 dark:hover:bg-white/20 text-slate-700 dark:text-amber-400 transition-all shadow-sm flex items-center justify-center cursor-pointer"
                            :title="isDark ? 'Ganti ke Mode Terang (Light Mode)' : 'Ganti ke Mode Gelap (Dark Mode)'"
                            aria-label="Toggle Theme">
                        <i class="fa-solid fa-sun text-base text-amber-400" x-show="isDark" x-cloak></i>
                        <i class="fa-solid fa-moon text-base text-slate-700" x-show="!isDark"></i>
                    </button>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/30 transition-all duration-200">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Dashboard MIS</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-300 dark:text-slate-200 dark:hover:text-white dark:bg-white/10 dark:hover:bg-white/15 dark:border-white/20 transition-all duration-200">
                            <i class="fa-solid fa-lock text-xs text-amber-500 dark:text-amber-400"></i>
                            <span>Login Admin</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button & Mobile Theme Toggle -->
                <div class="flex items-center gap-2 lg:hidden">
                    <button @click="toggleTheme()" 
                            type="button" 
                            class="p-2 rounded-xl border border-slate-200 dark:border-white/15 bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-amber-400 transition-colors"
                            aria-label="Toggle Theme Mobile">
                        <i class="fa-solid fa-sun text-sm text-amber-400" x-show="isDark" x-cloak></i>
                        <i class="fa-solid fa-moon text-sm text-slate-700" x-show="!isDark"></i>
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2.5 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors" aria-label="Toggle menu">
                        <i class="fa-solid text-xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden bg-white/95 dark:bg-slate-900/95 border-b border-slate-200 dark:border-white/10 px-4 pt-2 pb-6 space-y-2 shadow-xl">
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#beranda" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white">Beranda</a>
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#profil" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white">Profil & Visi</a>
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#kepengurusan" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white">Kepengurusan</a>
            <a @click="mobileMenuOpen = false" href="{{ route('leaders.public') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white">Sejarah</a>
            <a @click="mobileMenuOpen = false" href="{{ route('news.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white">Berita Terkini</a>
            <a @click="mobileMenuOpen = false" href="{{ route('gallery.public') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white">Galeri Kegiatan</a>
            @if((\App\Models\Setting::where('key', 'show_public_members')->value('value') ?? '0') === '1')
            <a @click="mobileMenuOpen = false" href="{{ route('members.public') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white">Direktori Anggota</a>
            @endif
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#bukutamu" class="block px-3 py-2 rounded-lg text-base font-semibold text-amber-600 dark:text-amber-300 hover:bg-amber-500/10">Buku Tamu Publik</a>
            
            <div class="pt-4 border-t border-slate-200 dark:border-white/10 space-y-2">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 shadow-md">
                        <i class="fa-solid fa-gauge-high me-1"></i> Dashboard MIS
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 bg-slate-100 dark:bg-white/10 border border-slate-300 dark:border-white/20">
                        <i class="fa-solid fa-lock text-xs text-amber-500 dark:text-amber-400 me-1"></i> Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Body Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Ultra-Modern Dark Footer (Mobile-Centered & Desktop-Aligned) -->
    <footer class="bg-[#0B132B] text-slate-300 border-t border-slate-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/10 via-transparent to-amber-900/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Col 1: Identity & Description (2 cols) -->
                <div class="lg:col-span-2 space-y-4 flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/10 p-2 ring-1 ring-white/20 flex items-center justify-center shadow-md">
                            <img src="{{ asset('assets/images/pwi-logo.webp') }}" alt="Logo PWI" width="48" height="48" class="w-full h-full object-contain" onerror="this.src='{{ asset('assets/images/pwi-logo.png') }}'">
                        </div>
                        <div class="text-center sm:text-left">
                            <h4 class="text-lg font-bold text-white leading-tight">PWI Kabupaten Banyuasin</h4>
                            <p class="text-xs text-amber-400 font-medium">Persatuan Wartawan Indonesia</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-md md:max-w-none pr-0 md:pr-4">
                        Wadah organisasi profesi jurnalis resmi dan terverifikasi di Kabupaten Banyuasin, Sumatera Selatan. Menjunjung tinggi kemerdekaan pers, integritas Kode Etik Jurnalistik, dan kemitraan strategis pembangunan daerah.
                    </p>
                    <div class="flex items-center justify-center md:justify-start gap-3 pt-2">
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
                <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Navigasi Cepat</h5>
                    <ul class="space-y-2 text-sm text-slate-400 flex flex-col items-center md:items-start">
                        <li><a href="{{ route('home') }}#beranda" class="hover:text-amber-400 transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('home') }}#profil" class="hover:text-amber-400 transition-colors">Visi & Misi</a></li>
                        <li><a href="{{ route('organization.public') }}" class="hover:text-amber-400 transition-colors">Susunan Pengurus</a></li>
                        <li><a href="{{ route('leaders.public') }}" class="hover:text-amber-400 transition-colors">Sejarah PWI (Ketua)</a></li>
                        @if((\App\Models\Setting::where('key', 'show_public_members')->value('value') ?? '0') === '1')
                        <li><a href="{{ route('members.public') }}" class="hover:text-amber-400 transition-colors">Direktori Wartawan</a></li>
                        @endif
                        <li><a href="{{ route('gallery.public') }}" class="hover:text-amber-400 transition-colors">Galeri Dokumentasi</a></li>
                    </ul>
                </div>

                <!-- Col 3: News & Category -->
                <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Kanal Publikasi</h5>
                    <ul class="space-y-2 text-sm text-slate-400 flex flex-col items-center md:items-start">
                        <li><a href="{{ route('news.index') }}?kategori=Kegiatan" class="hover:text-amber-400 transition-colors">Kegiatan Jurnalistik</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Kemitraan" class="hover:text-amber-400 transition-colors">Kemitraan & Forkopimda</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Organisasi" class="hover:text-amber-400 transition-colors">Internal Organisasi</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Olahraga" class="hover:text-amber-400 transition-colors">SIWO & Turnamen</a></li>
                        <li><a href="{{ route('news.index') }}?kategori=Hukum" class="hover:text-amber-400 transition-colors">Hukum & Advokasi</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Office Info -->
                <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Sekretariat PWI</h5>
                    <div class="space-y-3 text-xs text-slate-400 flex flex-col items-center md:items-start">
                        <div class="flex flex-col sm:flex-row items-center md:items-start gap-2 text-center md:text-left">
                            <i class="fa-solid fa-location-dot text-amber-400 mt-0.5"></i>
                            <span class="max-w-xs md:max-w-none">Jl. Merdeka No. 3 RT 02 RW 02 Kel. Mulya Agung, Kec. Banyuasin III, Kab. Banyuasin - Sumsel (30914)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-amber-400"></i>
                            <span>0853-7799-1976</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-amber-400"></i>
                            <span>sekretariat@pwibanyuasin.or.id</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="mt-12 pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4 text-center sm:text-left">
                <p>&copy; {{ date('Y') }} <strong>Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin</strong>. All rights reserved.</p>
                <p class="text-slate-500">Sistem Informasi Manajemen & Portal Jurnalistik v2.0</p>
            </div>
        </div>
    </footer>

    <!-- Floating Widgets: Scroll to Top & WhatsApp Pengurus Inti -->
    <div x-data="{ 
            waModalOpen: false, 
            showScrollTop: false,
            init() {
                window.addEventListener('scroll', () => {
                    this.showScrollTop = window.pageYOffset > 300;
                });
            },
            scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
         }"
         x-init="init()"
         class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 pointer-events-none">
        
        <!-- WhatsApp Pengurus Popover Modal -->
        <div x-show="waModalOpen" 
             x-cloak 
             @click.away="waModalOpen = false"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="pointer-events-auto bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl p-5 sm:p-6 max-w-sm sm:max-w-xl md:max-w-2xl w-full mb-2">
            
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-brands fa-whatsapp"></i>
                    </span>
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-900 dark:text-white leading-tight">Kontak Pengurus PWI</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Pilih kontak WhatsApp pengurus harian di bawah ini</p>
                    </div>
                </div>
                <button @click="waModalOpen = false" class="w-7 h-7 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-900 dark:hover:text-white flex items-center justify-center text-xs transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Grid 4 Pengurus -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                
                <!-- 1. Wardoyo, S.I.Kom -->
                <div class="flex flex-col items-center justify-between p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden border-2 border-blue-600 dark:border-amber-400 shadow-md mb-2 bg-slate-200 aspect-square">
                        <img src="{{ asset('assets/images/pengurus/pengurus_inti_1_wardoyo.webp') }}" alt="Wardoyo, S.I.Kom" width="80" height="80" loading="lazy" decoding="async" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="space-y-0.5 mb-3">
                        <h5 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white leading-tight">Wardoyo, S.I.Kom</h5>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">KETUA PWI BANYUASIN</p>
                    </div>
                    <a href="https://api.whatsapp.com/send/?phone=6285377991976&text=Halo+Wardoyo%2C+S.I.Kom+&type=phone_number&app_absent=0" 
                       target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#1E8E5A] hover:bg-[#25D366] text-white flex items-center justify-center text-lg shadow-md hover:scale-110 transition-transform"
                       title="WhatsApp Wardoyo, S.I.Kom">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>

                <!-- 2. H. Gusra Yetri, SH -->
                <div class="flex flex-col items-center justify-between p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden border-2 border-blue-600 dark:border-amber-400 shadow-md mb-2 bg-slate-200 aspect-square">
                        <img src="{{ asset('assets/images/pengurus/pengurus_inti_2_gusra.webp') }}" alt="H. Gusra Yetri, SH" width="80" height="80" loading="lazy" decoding="async" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="space-y-0.5 mb-3">
                        <h5 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white leading-tight">H. Gusra Yetri, SH</h5>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">WAKIL KETUA PWI</p>
                    </div>
                    <a href="https://api.whatsapp.com/send/?phone=6281210999194&text=Halo+H.+Gusra+Yetri%2CSH+&type=phone_number&app_absent=0" 
                       target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#1E8E5A] hover:bg-[#25D366] text-white flex items-center justify-center text-lg shadow-md hover:scale-110 transition-transform"
                       title="WhatsApp H. Gusra Yetri, SH">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>

                <!-- 3. Deni Arianto -->
                <div class="flex flex-col items-center justify-between p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden border-2 border-blue-600 dark:border-amber-400 shadow-md mb-2 bg-slate-200 aspect-square">
                        <img src="{{ asset('assets/images/pengurus/pengurus_inti_3_deni.webp') }}" alt="Deni Arianto" width="80" height="80" loading="lazy" decoding="async" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="space-y-0.5 mb-3">
                        <h5 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white leading-tight">Deni Arianto</h5>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">SEKRETARIS PWI</p>
                    </div>
                    <a href="https://api.whatsapp.com/send/?phone=628127883727&text=Halo+Deni+Arianto+&type=phone_number&app_absent=0" 
                       target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#1E8E5A] hover:bg-[#25D366] text-white flex items-center justify-center text-lg shadow-md hover:scale-110 transition-transform"
                       title="WhatsApp Deni Arianto">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>

                <!-- 4. Ridho Andi Sucipto, M.Pd -->
                <div class="flex flex-col items-center justify-between p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden border-2 border-blue-600 dark:border-amber-400 shadow-md mb-2 bg-slate-200 aspect-square">
                        <img src="{{ asset('assets/images/pengurus/pengurus_inti_4_ridho.webp') }}" alt="Ridho Andi Sucipto, M.Pd" width="80" height="80" loading="lazy" decoding="async" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="space-y-0.5 mb-3">
                        <h5 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white leading-tight">Ridho Andi Sucipto, M.Pd</h5>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">BENDAHARA PWI</p>
                    </div>
                    <a href="https://api.whatsapp.com/send/?phone=6285268778890&text=Halo+Ridho+Andi+Sucipto.M.Pd+&type=phone_number&app_absent=0" 
                       target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#1E8E5A] hover:bg-[#25D366] text-white flex items-center justify-center text-lg shadow-md hover:scale-110 transition-transform"
                       title="WhatsApp Ridho Andi Sucipto, M.Pd">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>

            </div>
        </div>

        <!-- Floating Buttons Row (Scroll to Top & WhatsApp Trigger) -->
        <div class="flex items-center gap-3 pointer-events-auto">
            <!-- Scroll to Top Button -->
            <button x-show="showScrollTop" 
                    x-cloak 
                    @click="scrollToTop()" 
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-75"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 scale-75"
                    type="button" 
                    class="w-12 h-12 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white shadow-xl flex items-center justify-center text-base hover:scale-110 active:scale-95 transition-all cursor-pointer group"
                    aria-label="Gulir ke Atas"
                    title="Gulir ke Atas">
                <i class="fa-solid fa-arrow-up group-hover:-translate-y-0.5 transition-transform"></i>
            </button>

            <!-- WhatsApp Floating Trigger Button -->
            <button @click="waModalOpen = !waModalOpen" 
                    type="button" 
                    class="relative w-14 h-14 rounded-2xl bg-[#075E54] hover:bg-[#128C7E] text-white shadow-2xl flex items-center justify-center text-2xl hover:scale-105 active:scale-95 transition-all cursor-pointer"
                    aria-label="Hubungi WhatsApp Pengurus"
                    title="Hubungi Pengurus via WhatsApp">
                <i class="fa-brands fa-whatsapp" x-show="!waModalOpen"></i>
                <i class="fa-solid fa-xmark text-lg" x-show="waModalOpen" x-cloak></i>
                <!-- Online Pulse Dot -->
                <span class="absolute top-1 right-1 flex h-3.5 w-3.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 border-2 border-white"></span>
                </span>
            </button>
        </div>

    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success_inbox'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Pesan Terkirim!',
                text: {!! json_encode(session('success_inbox')) !!},
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl dark:bg-slate-900 dark:text-white',
                    title: 'text-xl font-bold dark:text-white',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold text-sm shadow-md'
                }
            });
        });
    </script>
    @endif
    @if(session('error_inbox'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: {!! json_encode(session('error_inbox')) !!},
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl dark:bg-slate-900 dark:text-white',
                    title: 'text-xl font-bold dark:text-white',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold text-sm shadow-md'
                }
            });
        });
    </script>
    @endif
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: {!! json_encode(session('success')) !!},
                timer: 3500,
                timerProgressBar: true,
                confirmButtonColor: '#2563eb'
            });
        });
    </script>
    @endif

    <!-- AOS JS (Animate On Scroll) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 350,
                    easing: 'ease-out',
                    once: true,
                    offset: 20,
                    delay: 0,
                });
            }
        });
    </script>
</body>
</html>

