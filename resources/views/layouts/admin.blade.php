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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0F172A;
            color: #F8FAFC;
        }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0B132B;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased flex" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" 
           class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0B132B] border-r border-slate-800/80 transition-transform duration-300 ease-in-out flex flex-col justify-between custom-scrollbar overflow-y-auto">
        
        <!-- Top Section -->
        <div>
            <!-- Header Brand -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 p-1.5 ring-1 ring-white/20 flex items-center justify-center">
                        <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo PWI" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-amber-400 tracking-wider uppercase">Sistem Informasi MIS</div>
                        <div class="text-sm font-extrabold text-white leading-tight">PWI BANYUASIN</div>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- User Info Badge -->
            <div class="p-4 mx-4 my-4 rounded-2xl bg-slate-900/80 border border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="min-w-0 flex-grow">
                    <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Admin PWI' }}</div>
                    <div class="text-[10px] text-emerald-400 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Administrator Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="px-3 space-y-1.5 text-xs font-semibold">
                
                <div class="px-3 pt-2 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                    Menu Utama
                </div>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie text-sm w-4"></i>
                    <span>Dashboard MIS</span>
                </a>

                <!-- 1. Modul Anggota & Media (Group) -->
                <div x-data="{ open: {{ request()->is('admin/anggota*') || request()->is('admin/media*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-users text-sm w-4 text-blue-400"></i>
                            <span>Anggota & Media</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.members.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.members.index') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Wartawan Aktif
                        </a>
                        <a href="{{ route('admin.members.inactive') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.members.inactive') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Wartawan Belum/Non-Aktif
                        </a>
                        <a href="{{ route('admin.media.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.media.index') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Data Media Pers Mitra
                        </a>
                    </div>
                </div>

                <!-- 2. Struktur Organisasi -->
                <a href="{{ route('admin.organization.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.organization.index') ? 'bg-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-sitemap text-sm w-4 text-cyan-400"></i>
                    <span>Struktur Organisasi</span>
                </a>

                <div class="px-3 pt-4 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                    Administrasi & Rapat
                </div>

                <!-- 3. Modul Notulen Rapat & Absensi (FITUR BARU) -->
                <a href="{{ route('admin.meetings.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->is('admin/notulen-rapat*') ? 'bg-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-clipboard-check text-sm w-4 text-emerald-400"></i>
                        <span>Notulen & Absensi</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ request()->is('admin/notulen-rapat*') ? 'bg-slate-950 text-amber-400' : 'bg-emerald-500/20 text-emerald-300' }}">BARU</span>
                </a>

                <!-- 4. Modul Persuratan (Group) -->
                <div x-data="{ open: {{ request()->is('admin/surat*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope-open-text text-sm w-4 text-amber-400"></i>
                            <span>Persuratan Resmi</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.letters.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.letters.index') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Surat Keluar (Generator)
                        </a>
                        <a href="{{ route('admin.incoming-letters.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.incoming-letters.index') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Surat Masuk (Arsip)
                        </a>
                    </div>
                </div>

                <!-- 5. Buku Tamu / Inbox -->
                <a href="{{ route('admin.inbox.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.inbox.index') ? 'bg-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-inbox text-sm w-4 text-purple-400"></i>
                        <span>Buku Tamu Publik</span>
                    </div>
                    @php $newInboxCount = \App\Models\Inbox::where('status', 'baru')->count(); @endphp
                    @if($newInboxCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500 text-white animate-pulse">
                            {{ $newInboxCount }}
                        </span>
                    @endif
                </a>

                <div class="px-3 pt-4 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                    Publikasi & Pengaturan
                </div>

                <!-- 6. CMS Berita (Group) -->
                <div x-data="{ open: {{ request()->is('admin/berita*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-newspaper text-sm w-4 text-rose-400"></i>
                            <span>CMS Berita</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.posts.publish') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.posts.publish') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Berita Publish
                        </a>
                        <a href="{{ route('admin.posts.draft') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.posts.draft') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Draf Berita
                        </a>
                        <a href="{{ route('admin.posts.create') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.posts.create') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • + Tulis Berita
                        </a>
                    </div>
                </div>

                <!-- 7. Galeri PWI -->
                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.galleries.index') ? 'bg-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-images text-sm w-4 text-sky-400"></i>
                    <span>Galeri Dokumentasi</span>
                </a>

                <!-- 8. Pengaturan (Group) -->
                <div x-data="{ open: {{ request()->is('admin/pengaturan*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-gear text-sm w-4 text-slate-400"></i>
                            <span>Pengaturan Portal</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="pl-8 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.settings.office') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.office') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Data Kantor PWI
                        </a>
                        <a href="{{ route('admin.settings.password') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.password') ? 'text-amber-400 bg-white/5 font-bold' : 'text-slate-400 hover:text-white' }}">
                            • Ganti Kata Sandi
                        </a>
                    </div>
                </div>

            </nav>
        </div>

        <!-- Bottom Logout & Public Link -->
        <div class="p-4 border-t border-slate-800/80 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-xs font-semibold text-slate-300 bg-white/5 hover:bg-white/10 hover:text-white border border-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-amber-400"></i>
                <span>Lihat Website Publik</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-xs font-bold text-rose-400 bg-rose-500/10 hover:bg-rose-500 hover:text-white border border-rose-500/20 transition-all">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar / Logout</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area -->
    <div class="lg:pl-72 flex flex-col flex-grow min-w-0 min-h-screen bg-slate-950">
        
        <!-- Top Navbar -->
        <header class="sticky top-0 z-40 h-20 bg-slate-900/90 backdrop-blur-md border-b border-slate-800/80 px-4 sm:px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/5">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 class="text-base sm:text-lg font-extrabold text-white">@yield('page_title', 'Sistem Informasi PWI')</h1>
                    <p class="text-[11px] text-slate-400 hidden sm:block">Persatuan Wartawan Indonesia Kabupaten Banyuasin</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold text-amber-400 bg-amber-400/10 hover:bg-amber-400/20 border border-amber-400/30 transition-colors">
                    <i class="fa-solid fa-globe"></i>
                    <span>Portal Publik</span>
                </a>

                <div class="flex items-center gap-2 pl-4 border-l border-slate-800">
                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-xs text-amber-400">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-300 hidden md:block">Admin PWI</span>
                </div>
            </div>
        </header>

        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mx-4 sm:mx-8 mt-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-base text-emerald-400"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-4 sm:mx-8 mt-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-semibold shadow-lg">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span class="font-bold">Terjadi Kesalahan:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-slate-300">
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
        <footer class="h-14 px-8 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-500 bg-slate-950">
            <span>&copy; {{ date('Y') }} <strong>PWI Kabupaten Banyuasin</strong>.</span>
            <span>Versi MIS 2.0 (Integrated)</span>
        </footer>

    </div>

</body>
</html>
