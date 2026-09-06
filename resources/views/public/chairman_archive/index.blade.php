@extends('layouts.public')

@section('title', 'Arsip Karya Tulisan & Profil Ketua PWI Banyuasin - Wardoyo, S.I.Kom.')
@section('meta_description', 'Dokumentasi arsip digital karya jurnalistik, pemikiran, esai teori komunikasi politik, dan rekam jejak Ketua PWI Kabupaten Banyuasin Wardoyo, S.I.Kom.')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-200" x-data="{ activeTab: 'artikel' }">

    <!-- Executive Hero Banner (Deep Navy + Gold Accent) -->
    <div class="gradient-mesh text-white py-14 sm:py-20 relative overflow-hidden border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                <div class="max-w-3xl space-y-4">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-md">
                            <i class="fa-solid fa-box-archive text-xs"></i>
                            <span>Arsip Khusus Jurnalisme</span>
                        </span>
                        <a href="https://wardianst.wordpress.com/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold text-amber-300 bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all">
                            <i class="fa-brands fa-wordpress"></i>
                            <span>Sumber Asli: wardianst.wordpress.com</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                        Arsip Karya Tulisan & Profil <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-300 to-yellow-200">
                            Ketua PWI Kabupaten Banyuasin
                        </span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-300 font-medium leading-relaxed max-w-2xl">
                        Dokumentasi digital menyeluruh sebanyak <strong>{{ number_format($totalArticles) }} artikel dan catatan</strong> karya <strong>Wardoyo, S.I.Kom.</strong> sejak tahun 2007 hingga kini, mencakup teori komunikasi politik, kemerdekaan pers, investigasi, tata kelola daerah, hingga profil kepemimpinan.
                    </p>
                </div>

                <!-- Profile Highlight Mini Card in Hero -->
                <div class="w-full lg:w-96 bg-[#142042]/90 border border-blue-800/80 rounded-3xl p-5 sm:p-6 backdrop-blur-md shadow-2xl space-y-4 shrink-0">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 p-0.5 shadow-lg flex items-center justify-center shrink-0">
                            <div class="w-full h-full rounded-[14px] bg-[#0B132B] flex items-center justify-center text-amber-400 font-black text-xl">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-white leading-snug">{{ $profile['name'] }}</h3>
                            <p class="text-xs font-bold text-amber-400">{{ $profile['title'] }}</p>
                            <p class="text-[11px] text-slate-300 mt-0.5">{{ $profile['sk_resmi'] }}</p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-white/10 grid grid-cols-2 gap-2 text-center text-xs">
                        <div class="bg-white/5 rounded-xl p-2.5 border border-white/5">
                            <span class="block text-lg font-black text-white">{{ $totalArticles }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold uppercase">Total Karya</span>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2.5 border border-white/5">
                            <span class="block text-lg font-black text-emerald-400">UKW Utama</span>
                            <span class="text-[10px] text-slate-400 font-semibold uppercase">Dewan Pers</span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button @click="activeTab = 'profil'; $nextTick(() => document.getElementById('tab-content').scrollIntoView({ behavior: 'smooth' }))" class="w-full py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all text-center flex items-center justify-center gap-1.5 shadow-md">
                            <i class="fa-solid fa-address-card"></i>
                            <span>Buka Biodata Lengkap</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation (Tabs: Katalog Tulisan vs Profil & Biodata) -->
            <div class="flex items-center gap-2 sm:gap-4 mt-10 pt-6 border-t border-white/10" id="tab-nav">
                <button @click="activeTab = 'artikel'" :class="activeTab === 'artikel' ? 'bg-amber-400 text-slate-950 font-black shadow-lg' : 'bg-white/10 text-white hover:bg-white/20 font-bold'" class="px-5 py-3 rounded-2xl text-xs sm:text-sm transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>Katalog Tulisan & Karya ({{ $totalArticles }})</span>
                </button>
                <button @click="activeTab = 'profil'" :class="activeTab === 'profil' ? 'bg-amber-400 text-slate-950 font-black shadow-lg' : 'bg-white/10 text-white hover:bg-white/20 font-bold'" class="px-5 py-3 rounded-2xl text-xs sm:text-sm transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-user-check"></i>
                    <span>Biografi & Rekam Jejak Ketua</span>
                </button>
            </div>

        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14" id="tab-content">

        <!-- ================= TAB 1: KATALOG TULISAN ================= -->
        <div x-show="activeTab === 'artikel'" x-cloak class="space-y-8">
            
            <!-- Filter, Search & Year Bar -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 sm:p-6 shadow-sm space-y-5">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    
                    <!-- Search Input -->
                    <form action="{{ route('chairman.archive.index') }}" method="GET" class="w-full md:w-96">
                        @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                        @if(request('tahun'))
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        @endif
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau topik karya..." class="w-full pl-11 pr-24 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all shadow-inner">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                            @if(request('q'))
                                <a href="{{ route('chairman.archive.index', request()->except('q')) }}" class="absolute right-14 top-3 text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                            <button type="submit" class="absolute right-2 top-2 px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-sm transition-all">
                                Cari
                            </button>
                        </div>
                    </form>

                    <!-- Filter Year Dropdown -->
                    <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Tahun:</span>
                        <div class="flex items-center gap-2">
                            <select onchange="location = this.value;" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500">
                                <option value="{{ route('chairman.archive.index', request()->except('tahun')) }}">Semua Tahun</option>
                                @foreach($years as $y)
                                    <option value="{{ route('chairman.archive.index', array_merge(request()->query(), ['tahun' => $y->year])) }}" {{ request('tahun') == $y->year ? 'selected' : '' }}>
                                        Tahun {{ $y->year }} ({{ $y->total }})
                                    </option>
                                @endforeach
                            </select>

                            @if(request()->hasAny(['q', 'kategori', 'tahun']))
                                <a href="{{ route('chairman.archive.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-900/60 hover:bg-rose-100 transition-all flex items-center gap-1.5" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    <span class="hidden sm:inline">Reset</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Category Pills -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center gap-2">
                    <a href="{{ route('chairman.archive.index', request()->except('kategori')) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('kategori') ? 'bg-slate-900 dark:bg-amber-400 text-white dark:text-slate-950 shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                        Semua Kategori ({{ $totalArticles }})
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('chairman.archive.index', array_merge(request()->query(), ['kategori' => $cat->category])) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('kategori') == $cat->category ? 'bg-slate-900 dark:bg-amber-400 text-white dark:text-slate-950 shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                            {{ $cat->category }} <span class="opacity-70 text-[10px]">({{ $cat->total }})</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Active Filter Banner (If filtered) -->
            @if(request()->hasAny(['q', 'kategori', 'tahun']))
                <div class="flex items-center justify-between px-4 py-3 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-xs font-semibold text-amber-900 dark:text-amber-200">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-filter text-amber-600"></i>
                        <span>Menampilkan hasil filter: 
                            @if(request('q')) Pencarian "<strong>{{ request('q') }}</strong>" @endif
                            @if(request('kategori')) Kategori <strong>{{ request('kategori') }}</strong> @endif
                            @if(request('tahun')) Tahun <strong>{{ request('tahun') }}</strong> @endif
                            ({{ $articles->total() }} artikel ditemukan)
                        </span>
                    </div>
                    <a href="{{ route('chairman.archive.index') }}" class="text-amber-700 dark:text-amber-300 hover:underline font-bold">Hapus Filter</a>
                </div>
            @endif

            <!-- Articles Grid -->
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                    @foreach($articles as $post)
                        <article class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1">
                            <div>
                                <!-- Top Metadata Pill -->
                                <div class="flex items-center justify-between gap-2 mb-3.5">
                                    <span class="px-3 py-1 rounded-lg text-[11px] font-black tracking-wide uppercase bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800/80">
                                        {{ $post->category }}
                                    </span>
                                    <span class="text-[11px] font-semibold text-slate-400 flex items-center gap-1">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>{{ $post->reading_time }} mnt baca</span>
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors leading-snug line-clamp-2">
                                    <a href="{{ route('chairman.archive.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-medium mt-3 line-clamp-3 leading-relaxed">
                                    {{ $post->excerpt }}
                                </p>
                            </div>

                            <div class="pt-5 mt-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-semibold flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-slate-400"></i>
                                    {{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : '-' }}
                                </span>

                                <a href="{{ route('chairman.archive.show', $post->slug) }}" class="inline-flex items-center gap-1.5 font-extrabold text-blue-600 dark:text-amber-400 group-hover:translate-x-1 transition-transform">
                                    <span>Baca Lengkap</span>
                                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-12 text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tidak ada artikel yang cocok</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto">
                        Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.
                    </p>
                    <a href="{{ route('chairman.archive.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all shadow-md">
                        Reset Pencarian
                    </a>
                </div>
            @endif

        </div>

        <!-- ================= TAB 2: BIOGRAFI & REKAM JEJAK ================= -->
        <div x-show="activeTab === 'profil'" x-cloak class="space-y-8">
            
            <!-- Biodata Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-10 shadow-sm space-y-8">
                
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-8 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/80 dark:text-amber-300 border border-amber-300 dark:border-amber-800 mb-2">
                            <i class="fa-solid fa-award text-amber-500"></i>
                            <span>Profil Resmi Pimpinan Organisasi</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">{{ $profile['name'] }}</h2>
                        <p class="text-sm font-bold text-blue-600 dark:text-amber-400 mt-1">{{ $profile['title'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $profile['sk_resmi'] }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="https://wardianst.wordpress.com/" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                            <i class="fa-brands fa-wordpress"></i>
                            <span>Kunjungi Blog Asli</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                        <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 transition-all flex items-center gap-2 shadow-md">
                            <i class="fa-brands fa-facebook"></i>
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>

                <!-- Informasi Pribadi & Domisili -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-5 space-y-3 border border-slate-200/80 dark:border-slate-700/60">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-2">
                            <i class="fa-solid fa-id-card text-amber-500"></i>
                            <span>Data Pribadi & Keluarga</span>
                        </h3>
                        <dl class="text-xs space-y-2.5 text-slate-700 dark:text-slate-300">
                            <div>
                                <dt class="font-bold text-slate-500 dark:text-slate-400">Tempat, Tanggal Lahir:</dt>
                                <dd class="font-semibold text-slate-900 dark:text-white mt-0.5">{{ $profile['ttl'] }}</dd>
                            </div>
                            <div>
                                <dt class="font-bold text-slate-500 dark:text-slate-400">Agama:</dt>
                                <dd class="font-semibold text-slate-900 dark:text-white mt-0.5">{{ $profile['agama'] }}</dd>
                            </div>
                            <div>
                                <dt class="font-bold text-slate-500 dark:text-slate-400">Status Pernikahan:</dt>
                                <dd class="font-semibold text-slate-900 dark:text-white mt-0.5">{{ $profile['keluarga']['istri'] }} (Menikah: {{ $profile['keluarga']['tanggal_nikah'] }})</dd>
                            </div>
                            <div>
                                <dt class="font-bold text-slate-500 dark:text-slate-400">Putra-Putri:</dt>
                                <dd class="mt-1 space-y-1">
                                    @foreach($profile['keluarga']['anak'] as $anak)
                                        <div class="flex items-center gap-1.5 font-medium text-slate-800 dark:text-slate-200">
                                            <i class="fa-solid fa-circle-check text-[10px] text-emerald-500"></i>
                                            <span>{{ $anak }}</span>
                                        </div>
                                    @endforeach
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-5 space-y-3 border border-slate-200/80 dark:border-slate-700/60">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-amber-500"></i>
                            <span>Domisili & Kontak Resmi</span>
                        </h3>
                        <dl class="text-xs space-y-2.5 text-slate-700 dark:text-slate-300">
                            <div>
                                <dt class="font-bold text-slate-500 dark:text-slate-400">Alamat Tempat Tinggal:</dt>
                                <dd class="font-semibold text-slate-900 dark:text-white mt-0.5 leading-relaxed">{{ $profile['alamat'] }}</dd>
                            </div>
                            <div>
                                <dt class="font-bold text-slate-500 dark:text-slate-400">Kontak WhatsApp / Seluler:</dt>
                                <dd class="font-semibold text-slate-900 dark:text-white mt-0.5">{{ $profile['kontak']['telepon'] }}</dd>
                            </div>
                            <div>
                                <dt class="font-bold text-slate-500 dark:text-slate-400">Surel Resmi:</dt>
                                <dd class="font-semibold text-slate-900 dark:text-white mt-0.5">{{ $profile['kontak']['email'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Riwayat Pendidikan Formal -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <i class="fa-solid fa-graduation-cap text-blue-600 dark:text-amber-400"></i>
                        <span>Riwayat Pendidikan Formal</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($profile['pendidikan'] as $edu)
                            <div class="p-4 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60 shadow-xs">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">
                                    {{ $edu['tingkat'] }}
                                </span>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white mt-2">{{ $edu['instansi'] }}</h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">{{ $edu['prodi'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sertifikasi & Pelatihan Jurnalistik -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <i class="fa-solid fa-certificate text-emerald-500"></i>
                        <span>Sertifikasi Standar Pers & Pelatihan Jurnalistik</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($profile['sertifikasi'] as $cert)
                            <div class="p-4 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60 shadow-xs space-y-1.5">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs font-extrabold text-slate-900 dark:text-white">{{ $cert['bidang'] }}</h4>
                                    @if(isset($cert['tahun']))
                                        <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/60">
                                            {{ $cert['tahun'] }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-[11px] font-semibold text-blue-700 dark:text-blue-300">{{ $cert['penerbit'] }}</p>
                                @if(isset($cert['nomor']))
                                    <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400">No: {{ $cert['nomor'] }}</p>
                                @endif
                                @if(isset($cert['penguji']))
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 italic">Penguji: {{ $cert['penguji'] }}</p>
                                @endif
                                @if(isset($cert['keterangan']))
                                    <p class="text-[10px] text-slate-600 dark:text-slate-300">{{ $cert['keterangan'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kiprah & Riwayat Organisasi -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <i class="fa-solid fa-users-gear text-amber-500"></i>
                        <span>Kiprah Kepemimpinan & Pengalaman Organisasi</span>
                    </h3>
                    <div class="space-y-3">
                        @foreach($profile['organisasi'] as $org)
                            <div class="flex items-start justify-between gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60 shadow-xs">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">{{ $org['posisi'] }}</h4>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">{{ $org['ket'] }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 shrink-0">
                                    {{ $org['masa'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
