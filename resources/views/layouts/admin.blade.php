<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard MIS') - PWI Banyuasin</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
                            card: '#1E293B',
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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Light Mode Defaults for Admin Theme */
        html:not(.dark) body {
            background-color: #f8fafc;
            color: #1e293b;
        }
        html:not(.dark) .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        html:not(.dark) .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        /* Responsive Dual-Theme Mappings for Admin Components */
        html:not(.dark) .bg-slate-900 {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #1e293b;
        }
        html:not(.dark) .bg-slate-950 {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #0f172a;
        }
        html:not(.dark) .bg-slate-950\/70,
        html:not(.dark) .bg-slate-950\/80 {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #64748b !important;
        }
        html:not(.dark) .border-slate-800,
        html:not(.dark) .border-slate-800\/80,
        html:not(.dark) .border-slate-800\/60 {
            border-color: #e2e8f0 !important;
        }
        html:not(.dark) .border-slate-700,
        html:not(.dark) .border-slate-700\/60 {
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) .text-slate-400,
        html:not(.dark) .text-slate-300 {
            color: #64748b !important;
        }
        html:not(.dark) .text-slate-500 {
            color: #94a3b8 !important;
        }
        html:not(.dark) h1.text-white,
        html:not(.dark) h2.text-white,
        html:not(.dark) h3.text-white,
        html:not(.dark) h4.text-white,
        html:not(.dark) h5.text-white,
        html:not(.dark) td.font-bold.text-white {
            color: #0f172a !important;
        }
        html:not(.dark) table thead th {
            color: #64748b !important;
        }
        html:not(.dark) table tbody tr {
            border-bottom-color: #f1f5f9 !important;
        }
        html:not(.dark) table tbody tr:hover {
            background-color: #f8fafc !important;
        }
        html:not(.dark) input,
        html:not(.dark) select,
        html:not(.dark) textarea {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }
        html:not(.dark) input::placeholder,
        html:not(.dark) textarea::placeholder {
            color: #94a3b8 !important;
        }
        html:not(.dark) input:focus,
        html:not(.dark) select:focus,
        html:not(.dark) textarea:focus {
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2) !important;
        }

        /* Preserve colored button and badge text colors in Light Mode */
        html:not(.dark) .bg-blue-600,
        html:not(.dark) .bg-blue-500,
        html:not(.dark) .bg-emerald-600,
        html:not(.dark) .bg-emerald-500,
        html:not(.dark) .bg-rose-600,
        html:not(.dark) .bg-rose-500,
        html:not(.dark) .bg-purple-600 {
            color: #ffffff !important;
        }
        html:not(.dark) .bg-blue-600 *,
        html:not(.dark) .bg-blue-500 *,
        html:not(.dark) .bg-emerald-600 *,
        html:not(.dark) .bg-emerald-500 *,
        html:not(.dark) .bg-rose-600 *,
        html:not(.dark) .bg-rose-500 *,
        html:not(.dark) .bg-purple-600 * {
            color: #ffffff !important;
        }
        html:not(.dark) .bg-amber-400,
        html:not(.dark) .bg-amber-300 {
            color: #0f172a !important;
        }
        html:not(.dark) .bg-amber-400 *,
        html:not(.dark) .bg-amber-300 * {
            color: #0f172a !important;
        }

        /* Dark Mode Scrollbar */
        .dark .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #0B132B;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100/80 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased flex transition-colors duration-200" 
      x-data="{ 
          sidebarOpen: false,
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

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" 
           class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-[#0B132B] border-r border-slate-200 dark:border-slate-800/80 transition-all duration-300 ease-in-out flex flex-col justify-between custom-scrollbar overflow-y-auto shadow-sm dark:shadow-none">
        
        <!-- Top Section -->
        <div>
            <!-- Header Brand -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-slate-200 dark:border-slate-800/80 bg-slate-50/80 dark:bg-slate-950/40">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-white/10 p-1.5 ring-1 ring-slate-200 dark:ring-white/20 flex items-center justify-center shadow-sm">
                        <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo PWI" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-amber-600 dark:text-amber-400 tracking-wider uppercase">Sistem Informasi MIS</div>
                        <div class="text-sm font-extrabold text-slate-900 dark:text-white leading-tight">PWI BANYUASIN</div>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-700 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- User Info Badge -->
            <div class="p-4 mx-4 my-4 rounded-2xl bg-slate-50 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="min-w-0 flex-grow">
                    <div class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ auth()->user()->name ?? 'Admin PWI' }}</div>
                    <div class="text-[10px] text-emerald-600 dark:text-emerald-400 flex items-center gap-1 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Administrator Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="px-3 space-y-1.5 text-xs font-semibold">
                
                <div class="px-3 pt-2 pb-1 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    Menu Utama
                </div>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white font-bold shadow-sm dark:bg-slate-800 dark:text-amber-400 dark:border-l-4 dark:border-amber-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie text-sm w-4 {{ request()->routeIs('admin.dashboard') ? 'text-amber-400' : 'text-amber-500' }}"></i>
                    <span>Dashboard MIS</span>
                </a>

                <!-- 1. Modul Anggota & Media (Group) -->
                <div x-data="{ open: {{ request()->is('admin/anggota*') || request()->is('admin/media*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-users text-sm w-4 text-blue-500"></i>
                            <span>Anggota & Media</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.members.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.members.index') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Wartawan Aktif
                        </a>
                        <a href="{{ route('admin.members.inactive') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.members.inactive') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Wartawan Belum/Non-Aktif
                        </a>
                        <a href="{{ route('admin.media.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.media.index') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Data Media Pers Mitra
                        </a>
                    </div>
                </div>

                <!-- 2. Struktur Organisasi -->
                <a href="{{ route('admin.organization.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.organization.index') ? 'bg-slate-900 text-white font-bold shadow-sm dark:bg-slate-800 dark:text-amber-400 dark:border-l-4 dark:border-amber-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white' }}">
                    <i class="fa-solid fa-sitemap text-sm w-4 text-cyan-500"></i>
                    <span>Struktur Organisasi</span>
                </a>

                <div class="px-3 pt-4 pb-1 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    Administrasi & Rapat
                </div>

                <!-- 3. Modul Notulen Rapat & Absensi -->
                <a href="{{ route('admin.meetings.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->is('admin/notulen-rapat*') ? 'bg-slate-900 text-white font-bold shadow-sm dark:bg-slate-800 dark:text-amber-400 dark:border-l-4 dark:border-amber-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-clipboard-check text-sm w-4 text-emerald-500"></i>
                        <span>Notulen & Absensi</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ request()->is('admin/notulen-rapat*') ? 'bg-amber-400 text-slate-950' : 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-300' }}">BARU</span>
                </a>

                <!-- 4. Modul Persuratan (Group) -->
                <div x-data="{ open: {{ request()->is('admin/surat*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope-open-text text-sm w-4 text-amber-500"></i>
                            <span>Persuratan Resmi</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.letters.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.letters.index') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Surat Keluar (Generator)
                        </a>
                        <a href="{{ route('admin.incoming-letters.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.incoming-letters.index') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Surat Masuk (Arsip)
                        </a>
                    </div>
                </div>

                <!-- 5. Buku Tamu / Inbox -->
                <a href="{{ route('admin.inbox.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.inbox.index') ? 'bg-slate-900 text-white font-bold shadow-sm dark:bg-slate-800 dark:text-amber-400 dark:border-l-4 dark:border-amber-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-inbox text-sm w-4 text-purple-500"></i>
                        <span>Buku Tamu Publik</span>
                    </div>
                    @php $newInboxCount = \App\Models\Inbox::where('status', 'baru')->count(); @endphp
                    @if($newInboxCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500 text-white animate-pulse">
                            {{ $newInboxCount }}
                        </span>
                    @endif
                </a>

                <div class="px-3 pt-4 pb-1 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    Publikasi & Pengaturan
                </div>

                <!-- 6. CMS Berita (Group) -->
                <div x-data="{ open: {{ request()->is('admin/berita*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-newspaper text-sm w-4 text-rose-500"></i>
                            <span>CMS Berita</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.posts.publish') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.posts.publish') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Berita Publish
                        </a>
                        <a href="{{ route('admin.posts.draft') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.posts.draft') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Draf Berita
                        </a>
                        <a href="{{ route('admin.posts.create') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.posts.create') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • + Tulis Berita
                        </a>
                    </div>
                </div>

                <!-- 7. Galeri PWI -->
                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.galleries.index') ? 'bg-slate-900 text-white font-bold shadow-sm dark:bg-slate-800 dark:text-amber-400 dark:border-l-4 dark:border-amber-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white' }}">
                    <i class="fa-solid fa-images text-sm w-4 text-sky-500"></i>
                    <span>Galeri Dokumentasi</span>
                </a>

                <!-- 8. Pengaturan (Group) -->
                <div x-data="{ open: {{ request()->is('admin/pengaturan*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-gear text-sm w-4 text-slate-500"></i>
                            <span>Pengaturan Portal</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.settings.office') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.office') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Data Kantor PWI
                        </a>
                        <a href="{{ route('admin.settings.password') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.password') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 font-bold border-l-2 border-slate-900 dark:border-amber-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            • Ganti Kata Sandi
                        </a>
                    </div>
                </div>

            </nav>
        </div>

        <!-- Bottom Logout & Public Link -->
        <div class="p-4 border-t border-slate-200 dark:border-slate-800/80 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 border border-slate-200 dark:border-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-amber-500 dark:text-amber-400"></i>
                <span>Lihat Website Publik</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-500/10 hover:bg-rose-500 hover:text-white border border-rose-500/20 transition-all cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar / Logout</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area -->
    <div class="lg:pl-72 flex flex-col flex-grow min-w-0 min-h-screen bg-slate-100/80 dark:bg-slate-950 transition-colors duration-200">
        
        <!-- Top Navbar -->
        <header class="sticky top-0 z-40 h-20 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800/80 px-4 sm:px-8 flex items-center justify-between transition-colors duration-200 shadow-sm dark:shadow-none">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white">@yield('page_title', 'Sistem Informasi PWI')</h1>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 hidden sm:block">Persatuan Wartawan Indonesia Kabupaten Banyuasin</p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                
                <!-- Dark / Light Mode Toggle Button in Header -->
                <button @click="toggleTheme()" 
                        type="button" 
                        class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-amber-400 transition-all shadow-sm flex items-center justify-center cursor-pointer"
                        :title="isDark ? 'Ganti ke Mode Terang (Light Mode)' : 'Ganti ke Mode Gelap (Dark Mode)'"
                        aria-label="Toggle Theme">
                    <i class="fa-solid fa-sun text-base text-amber-400" x-show="isDark" x-cloak></i>
                    <i class="fa-solid fa-moon text-base text-slate-700" x-show="!isDark"></i>
                </button>

                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold text-amber-700 dark:text-amber-400 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-300 dark:border-amber-400/30 transition-colors">
                    <i class="fa-solid fa-globe"></i>
                    <span>Portal Publik</span>
                </a>

                <div class="flex items-center gap-2 pl-3 sm:pl-4 border-l border-slate-200 dark:border-slate-800">
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center font-bold text-xs text-amber-600 dark:text-amber-400">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 hidden md:block">Admin PWI</span>
                </div>
            </div>
        </header>

        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mx-4 sm:mx-8 mt-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-xs font-semibold flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 dark:text-emerald-400 hover:text-slate-900 dark:hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-4 sm:mx-8 mt-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-semibold shadow-lg">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span class="font-bold">Terjadi Kesalahan:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-slate-700 dark:text-slate-300">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Body Content -->
        <main class="p-4 sm:p-8 flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="h-14 px-8 border-t border-slate-200 dark:border-slate-800/80 flex items-center justify-between text-xs text-slate-500 bg-white dark:bg-slate-950 transition-colors duration-200">
            <span>&copy; {{ date('Y') }} <strong>PWI Kabupaten Banyuasin</strong>.</span>
            <span>Versi MIS 2.0 (Integrated)</span>
        </footer>

    </div>

</body>
</html>

