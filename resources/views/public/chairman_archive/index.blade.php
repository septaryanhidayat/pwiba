@extends('layouts.public')

@section('title', 'Portofolio Eksekutif & Arsip Karya Wardoyo, S.I.Kom. - Ketua PWI Banyuasin')
@section('meta_description', 'Portofolio resmi dan rekam jejak kepemimpinan Wardoyo, S.I.Kom. - Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin Periode 2025–2028, Wartawan Utama Dewan Pers, dan praktisi komunikasi politik.')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-200" x-data="{ 
    activeTab: 'semua',
    copied: false,
    shareUrl() {
        navigator.clipboard.writeText(window.location.href);
        this.copied = true;
        setTimeout(() => this.copied = false, 2500);
    }
}">

    <!-- ========================================================================= -->
    <!-- 1. HERO SECTION: COMPANY PROFILE / PERSONAL BRANDING UTAMA                -->
    <!-- ========================================================================= -->
    <section class="relative bg-gradient-to-b from-[#070D1E] via-[#0B132B] to-[#142042] text-white pt-12 pb-20 sm:pb-28 overflow-hidden border-b border-white/10">
        
        <!-- Ambient Decorative Glows -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                <!-- Left Column: Biography & Headline (7 Cols) -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    
                    <!-- Verified Figure Pill -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-400/10 border border-amber-400/30 text-amber-400 text-xs font-black uppercase tracking-wider backdrop-blur-md shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <i class="fa-solid fa-shield-halved text-amber-400"></i>
                        <span>Profil Eksekutif & Personal Branding Resmi</span>
                    </div>

                    <!-- Name & Title -->
                    <div class="space-y-2">
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                            Wardoyo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-300 to-yellow-200">S.I.Kom.</span>
                        </h1>
                        <p class="text-base sm:text-xl font-extrabold text-blue-300 leading-snug">
                            Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin
                        </p>
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 pt-1 text-xs text-slate-300 font-semibold">
                            <span class="px-3 py-1 rounded-lg bg-white/10 border border-white/15">Periode 2025–2028</span>
                            <span class="px-3 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <i class="fa-solid fa-check-double me-1"></i> Wartawan Utama Dewan Pers
                            </span>
                            <span class="px-3 py-1 rounded-lg bg-white/10 border border-white/15">Magister Komunikasi Politik</span>
                        </div>
                    </div>

                    <!-- Personal Motto / Vision -->
                    <blockquote class="p-4 rounded-2xl bg-white/5 border-l-4 border-amber-400 text-slate-300 text-xs sm:text-sm leading-relaxed italic backdrop-blur-xs max-w-2xl mx-auto lg:mx-0">
                        "Menegakkan kemerdekaan pers yang beretika, membangun sinergi kemitraan strategis yang bermartabat, dan memperjuangkan kapasitas serta kesejahteraan wartawan di Kabupaten Banyuasin."
                    </blockquote>

                    <!-- Key Metrics Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-2xl font-black text-amber-400">{{ $totalArticles }}+</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Karya Tulis</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-2xl font-black text-white">18+ Th</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Kiprah Jurnalistik</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-2xl font-black text-emerald-400">Utama</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Lisensi UKW</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-2xl font-black text-blue-300">S2</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Ilmu Komunikasi</span>
                        </div>
                    </div>

                    <!-- Call To Actions (WhatsApp, Portfolio, Copy Link) -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 pt-3">
                        <!-- Direct WhatsApp -->
                        <a href="https://wa.me/6285377991976?text={{ urlencode('Halo Pak Wardoyo, S.I.Kom. (Ketua PWI Banyuasin), saya ingin bersilaturahmi dan berdiskusi terkait kemitraan / informasi.') }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3 rounded-xl text-xs sm:text-sm font-black text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/25 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-base text-emerald-950"></i>
                            <span>Hubungi WhatsApp Resmi</span>
                        </a>

                        <!-- Scroll to Writings -->
                        <a href="#karya-arsip" class="px-5 py-3 rounded-xl text-xs sm:text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all flex items-center gap-2">
                            <i class="fa-solid fa-book-bookmark text-amber-400"></i>
                            <span>Koleksi 320 Karya Tulis</span>
                        </a>

                        <!-- Share / Copy Link -->
                        <button @click="shareUrl()" type="button" class="px-4 py-3 rounded-xl text-xs font-bold text-slate-200 bg-white/5 hover:bg-white/10 border border-white/15 transition-all flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid" :class="copied ? 'fa-check text-emerald-400' : 'fa-share-nodes'"></i>
                            <span x-text="copied ? 'Tautan Tersalin!' : 'Bagikan Profil'"></span>
                        </button>
                    </div>

                </div>

                <!-- Right Column: Official Portrait Picture & Identity Badge (5 Cols) -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-full max-w-md">
                        
                        <!-- Glow Backdrop Frame -->
                        <div class="absolute -inset-2 rounded-3xl bg-gradient-to-tr from-amber-500 via-blue-600 to-amber-300 opacity-30 blur-xl"></div>

                        <!-- Card Container -->
                        <div class="relative rounded-3xl bg-gradient-to-b from-[#1C2541] to-[#0B132B] border-2 border-amber-400/40 p-4 sm:p-5 shadow-2xl space-y-4">
                            
                            <!-- Official Photo Frame with Aspect Ratio -->
                            <div class="relative w-full aspect-[4/5] rounded-2xl overflow-hidden bg-slate-900 border border-white/10 shadow-inner group">
                                <img src="{{ $profile['foto_url'] }}" 
                                     alt="Wardoyo, S.I.Kom. - Ketua PWI Kabupaten Banyuasin" 
                                     class="w-full h-full object-cover object-top transform group-hover:scale-105 transition-transform duration-700"
                                     fetchpriority="high">
                                
                                <!-- Official Gold Ribbon Corner -->
                                <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-lg flex items-center gap-1.5 border border-white/30">
                                    <i class="fa-solid fa-award"></i>
                                    <span>Ketua Terpilih 2025–2028</span>
                                </div>

                                <!-- Subtle Gradient Overlay at Bottom of Photo -->
                                <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-[#0B132B] via-[#0B132B]/60 to-transparent flex items-end p-4">
                                    <div class="text-white">
                                        <p class="text-xs font-bold text-amber-400 uppercase tracking-wider">SK PWI Pusat</p>
                                        <p class="text-xs font-mono font-bold text-slate-200">{{ $profile['sk_resmi'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Identity Summary Card -->
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-400 font-semibold">Dewan Pers RI:</span>
                                    <span class="font-extrabold text-emerald-400 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-[11px]"></i>
                                        <span>Wartawan Utama</span>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-400 font-semibold">No. Registrasi UKW:</span>
                                    <span class="font-mono text-slate-300 font-bold text-[11px]">1231-PWI/WU/DP/XII/2018/17/02/76</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-400 font-semibold">Alumni SJI:</span>
                                    <span class="font-bold text-amber-300">Sekolah Jurnalisme Indonesia (2011)</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- ========================================================================= -->
    <!-- 2. EXECUTIVE SUMMARY & TENTANG SAYA (COMPANY PROFILE STYLE)              -->
    <!-- ========================================================================= -->
    <section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left: Narrative Story (7 cols) -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                        <i class="fa-solid fa-user-pen"></i>
                        <span>Tentang Kepemimpinan & Pengabdian</span>
                    </div>

                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
                        Komitmen Teruji Mengawal Integritas Pers & Pembangunan Banyuasin
                    </h2>

                    <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed space-y-3.5">
                        <p>
                            <strong>Wardoyo, S.I.Kom.</strong> adalah tokoh pers dan praktisi komunikasi yang telah mendedikasikan lebih dari 18 tahun kariernya di dunia jurnalistik Sumatera Selatan. Memulai langkah dari wartawan lapangan, peliput investigasi, hingga memimpin media siber nasional sebagai Pemimpin Redaksi, beliau memiliki pemahaman mendalam tentang ekosistem pers dan dinamika publik.
                        </p>
                        <p>
                            Menyelesaikan studi Sarjana (S1) Ilmu Jurnalistik dan Magister (S2) Ilmu Komunikasi Politik di STISIPOL Candradimuka Palembang, Wardoyo memadukan kecakapan teknis jurnalistik dengan landasan teoritis yang kokoh. Beliau mengantongi predikat <strong>Wartawan Tingkat Utama Dewan Pers</strong> yang diuji langsung oleh tokoh pers nasional mantan Kepala Biro LKBN ANTARA New York, Bapak Aat Surya Safaat.
                        </p>
                        <p>
                            Terpilih sebagai <strong>Ketua PWI Kabupaten Banyuasin Periode 2025–2028</strong> berdasarkan SK PWI Pusat Nomor 033/PP-PWI/XI/2025, Wardoyo membawa visi transformasi organisasi pers yang berdaya saing, independen, menjunjung tinggi Kode Etik Jurnalistik (KEJ), serta menjadi mitra kritis dan solutif bagi kemajuan daerah.
                        </p>
                    </div>

                    <!-- Fast Contact Pills -->
                    <div class="pt-2 flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-600 dark:text-slate-300">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-amber-500"></i>
                            <span>{{ $profile['kontak']['email'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-blue-500"></i>
                            <span>{{ $profile['kontak']['telepon'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-rose-500"></i>
                            <span>Talang Kelapa, Kabupaten Banyuasin</span>
                        </div>
                    </div>
                </div>

                <!-- Right: 4 Strategic Value Pillars (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold shrink-0 shadow-md">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Integritas & Etika Pers</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Menegakkan kepatuhan terhadap UU Pers No. 40/1999 dan Kode Etik Jurnalistik demi menjaga kepercayaan publik.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-bold shrink-0 shadow-md">
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Kemitraan Strategis Daerah</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Membangun kolaborasi profesional dan konstruktif bersama Forkopimda, Pemkab Banyuasin, dan para pemangku kepentingan.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold shrink-0 shadow-md">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Standarisasi Kompetensi Wartawan</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Mendorong sertifikasi UKW berkelanjutan untuk seluruh wartawan anggota PWI Banyuasin agar profesional dan kredibel.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold shrink-0 shadow-md">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Transformasi Digital Media</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Mengakselerasi pemanfaatan teknologi informasi dan inovasi digital dalam pengelolaan organisasi serta publikasi warta.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 3. BENTO GRID: REKAM JEJAK ORGANISASI & KEPEMIMPINAN                     -->
    <!-- ========================================================================= -->
    <section class="py-16 bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 text-xs font-extrabold uppercase tracking-wider">
                    <i class="fa-solid fa-sitemap"></i>
                    <span>Kepemimpinan Multisektor</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white">
                    Rekam Jejak Organisasi & Pengabdian Masyarakat
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Pengalaman luas dalam mengemban amanah kepemimpinan di ranah organisasi profesi pers, pemantau pemilu, asosiasi jasa konstruksi, perdagangan pasar, serta olahraga dan seni beladiri.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Pilar 1: Pers & Media -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-5 group hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl font-bold mb-4 shadow-inner">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Pers & Media Massa</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Penggerak kemerdekaan pers dan ekosistem berita.</p>
                        
                        <ul class="mt-4 space-y-2.5 text-xs text-slate-700 dark:text-slate-300">
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-amber-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Ketua PWI Banyuasin</strong> (2025–2028)</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-amber-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Anggota DKP PWI Sumsel</strong> (2024–2029)</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-amber-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Pemimpin Redaksi</strong> Buana Indonesia (2015–Sekarang)</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-amber-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Komisaris</strong> PT Buana Indonesia Media</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-bold text-blue-600 dark:text-amber-400">
                        Wartawan Tingkat Utama
                    </div>
                </div>

                <!-- Pilar 2: Pengawasan Pemilu & Demokrasi -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-5 group hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold mb-4 shadow-inner">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Demokrasi & Pemilu</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Mengawal integritas pesta demokrasi konstitusional.</p>
                        
                        <ul class="mt-4 space-y-2.5 text-xs text-slate-700 dark:text-slate-300">
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Ketua MAPPILU PWI</strong> Banyuasin (2018–2023)</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span>Terakreditasi resmi <strong>BAWASLU RI</strong> No: 034/BAWASLU/II/2019</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span>Pemantau independen Pileg, Pilpres, dan Pilkada serentak</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                        Akreditasi Bawaslu RI
                    </div>
                </div>

                <!-- Pilar 3: Dunia Usaha & Konstruksi -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-5 group hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold mb-4 shadow-inner">
                            <i class="fa-solid fa-building-shield"></i>
                        </div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Dunia Usaha & Jasa</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Mendorong iklim usaha dan pertumbuhan ekonomi.</p>
                        
                        <ul class="mt-4 space-y-2.5 text-xs text-slate-700 dark:text-slate-300">
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-blue-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Ketua ASPEKINDO</strong> Banyuasin (2024–2029)</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-blue-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span>Asosiasi Pengusaha Konstruksi Indonesia</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-blue-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Wakil Ketua APPSI</strong> Banyuasin (2026–2031) - Asosiasi Pedagang Pasar</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-bold text-blue-600 dark:text-blue-400">
                        Pemberdayaan Ekonomi
                    </div>
                </div>

                <!-- Pilar 4: Olahraga & Seni Budaya -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-5 group hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl font-bold mb-4 shadow-inner">
                            <i class="fa-solid fa-person-running"></i>
                        </div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Olahraga & Budaya</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Melestarikan budaya beladiri dan olahraga prestasi.</p>
                        
                        <ul class="mt-4 space-y-2.5 text-xs text-slate-700 dark:text-slate-300">
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-purple-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Ketua HIMSSI</strong> Banyuasin (2022–2026)</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-purple-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span>Himpunan Seni Silat Indonesia</span>
                            </li>
                            <li class="flex items-start gap-2 font-medium">
                                <i class="fa-solid fa-circle-check text-purple-500 text-[11px] mt-0.5 shrink-0"></i>
                                <span><strong>Sekretaris FHI</strong> Banyuasin (Federasi Hockey Indonesia - Cabang KONI)</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-bold text-purple-600 dark:text-purple-400">
                        Pembinaan Generasi Muda
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 4. PENDIDIKAN & SERTIFIKASI KHUSUS                                       -->
    <!-- ========================================================================= -->
    <section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Riwayat Pendidikan (6 cols) -->
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Kualifikasi Akademik</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white">
                        Pendidikan Formal & Keilmuan
                    </h3>

                    <div class="space-y-3.5">
                        @foreach($profile['pendidikan'] as $edu)
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/70 border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between gap-4">
                                <div>
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">
                                        {{ $edu['tingkat'] }}
                                    </span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white mt-1">{{ $edu['instansi'] }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $edu['prodi'] }}</p>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sertifikasi & Pelatihan Khusus (6 cols) -->
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                        <i class="fa-solid fa-certificate"></i>
                        <span>Standarisasi Profesi</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white">
                        Sertifikasi & Pelatihan Jurnalistik
                    </h3>

                    <div class="space-y-3.5">
                        @foreach($profile['sertifikasi'] as $cert)
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/70 border border-slate-200/80 dark:border-slate-700/60 shadow-xs space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 dark:text-white">{{ $cert['bidang'] }}</h4>
                                    @if(isset($cert['tahun']))
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 dark:bg-amber-950/80 dark:text-amber-300">
                                            {{ $cert['tahun'] }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs font-semibold text-blue-700 dark:text-amber-400">{{ $cert['penerbit'] }}</p>
                                @if(isset($cert['nomor']))
                                    <p class="text-[11px] font-mono text-slate-500 dark:text-slate-400">No: {{ $cert['nomor'] }}</p>
                                @endif
                                @if(isset($cert['penguji']))
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">Penguji: {{ $cert['penguji'] }}</p>
                                @endif
                                @if(isset($cert['keterangan']))
                                    <p class="text-xs text-slate-600 dark:text-slate-300">{{ $cert['keterangan'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 5. KATALOG 320 ARSIP KARYA TULIS (THE MASTER ARCHIVE)                     -->
    <!-- ========================================================================= -->
    <section class="py-16 bg-slate-50 dark:bg-slate-950" id="karya-arsip">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-slate-200 dark:border-slate-800">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/10 text-amber-700 dark:text-amber-400 text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-feather-pointed"></i>
                        <span>Arsip Digital Komprehensif</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white">
                        Katalog Tulisan & Koleksi 320 Karya Pemikiran
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Dokumentasi karya tulisan, esai teori komunikasi politik, analisis berita, dan liputan jurnalistik dari blog pribadi [wardianst.wordpress.com](https://wardianst.wordpress.com/) yang telah disanitasi ke dalam format modern.
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <a href="https://wardianst.wordpress.com/" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-slate-100 transition-all flex items-center gap-2 shadow-xs">
                        <i class="fa-brands fa-wordpress text-base"></i>
                        <span>Blog Sumber Asli</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Search, Category & Year Bar -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 sm:p-6 shadow-sm space-y-5">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    
                    <!-- Search Input -->
                    <form action="{{ route('chairman.archive.index') }}#karya-arsip" method="GET" class="w-full md:w-96">
                        @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                        @if(request('tahun'))
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        @endif
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari topik atau judul artikel..." class="w-full pl-11 pr-24 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all shadow-inner">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                            @if(request('q'))
                                <a href="{{ route('chairman.archive.index', request()->except('q')) }}#karya-arsip" class="absolute right-14 top-3 text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                            <button type="submit" class="absolute right-2 top-2 px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-sm transition-all cursor-pointer">
                                Cari
                            </button>
                        </div>
                    </form>

                    <!-- Filter Year Dropdown -->
                    <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Filter Tahun:</span>
                        <div class="flex items-center gap-2">
                            <select onchange="location = this.value;" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500 cursor-pointer">
                                <option value="{{ route('chairman.archive.index', request()->except('tahun')) }}#karya-arsip">Semua Tahun</option>
                                @foreach($years as $y)
                                    <option value="{{ route('chairman.archive.index', array_merge(request()->query(), ['tahun' => $y->year])) }}#karya-arsip" {{ request('tahun') == $y->year ? 'selected' : '' }}>
                                        Tahun {{ $y->year }} ({{ $y->total }})
                                    </option>
                                @endforeach
                            </select>

                            @if(request()->hasAny(['q', 'kategori', 'tahun']))
                                <a href="{{ route('chairman.archive.index') }}#karya-arsip" class="px-3 py-2 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-900/60 hover:bg-rose-100 transition-all flex items-center gap-1.5" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    <span class="hidden sm:inline">Reset</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Category Pills -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center gap-2">
                    <a href="{{ route('chairman.archive.index', request()->except('kategori')) }}#karya-arsip" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('kategori') ? 'bg-slate-900 dark:bg-amber-400 text-white dark:text-slate-950 shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                        Semua Kategori ({{ $totalArticles }})
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('chairman.archive.index', array_merge(request()->query(), ['kategori' => $cat->category])) }}#karya-arsip" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('kategori') == $cat->category ? 'bg-slate-900 dark:bg-amber-400 text-white dark:text-slate-950 shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                            {{ $cat->category }} <span class="opacity-70 text-[10px]">({{ $cat->total }})</span>
                        </a>
                    @endforeach
                </div>
            </div>

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
                    <a href="{{ route('chairman.archive.index') }}#karya-arsip" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all shadow-md">
                        Reset Pencarian
                    </a>
                </div>
            @endif

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 6. EXECUTIVE CONTACT & PERSONAL NETWORKING CARD                           -->
    <!-- ========================================================================= -->
    <section class="py-16 bg-gradient-to-br from-[#070D1E] via-[#0B132B] to-[#142042] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-blue-900/40 via-slate-900/60 to-amber-950/30 border border-white/10 rounded-3xl p-8 sm:p-12 shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <div class="lg:col-span-8 space-y-4 text-center lg:text-left">
                        <span class="px-3.5 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-md inline-block">
                            Silaturahmi & Kemitraan Strategis
                        </span>
                        <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                            Terhubung Langsung dengan Wardoyo, S.I.Kom.
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Terbuka untuk ruang diskusi, kemitraan strategis kelembagaan, audiensi pers, narasumber komunikasi politik, maupun silaturahmi pembangunan daerah Kabupaten Banyuasin.
                        </p>

                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2 text-xs">
                            <a href="https://wa.me/6285377991976" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold flex items-center gap-2 shadow-lg transition-all">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>0853-7799-1976</span>
                            </a>
                            <a href="mailto:{{ $profile['kontak']['email'] }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold border border-white/20 flex items-center gap-2 transition-all">
                                <i class="fa-solid fa-envelope text-amber-400"></i>
                                <span>{{ $profile['kontak']['email'] }}</span>
                            </a>
                            <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold flex items-center gap-2 transition-all">
                                <i class="fa-brands fa-facebook-f"></i>
                                <span>Facebook Resmi</span>
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-4 flex flex-col items-center justify-center gap-3 p-6 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                        <div class="w-16 h-16 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-2xl font-black shadow-lg">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <h4 class="text-sm font-black text-white">Kartu Portofolio Digital</h4>
                        <p class="text-[11px] text-slate-300">Bagikan halaman portofolio personal branding ini kepada kolega atau pemangku kepentingan.</p>
                        
                        <button @click="shareUrl()" type="button" class="w-full py-2.5 rounded-xl text-xs font-black text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer">
                            <i class="fa-solid" :class="copied ? 'fa-check text-emerald-950' : 'fa-copy'"></i>
                            <span x-text="copied ? 'Tautan Berhasil Disalin!' : 'Salin Tautan Portofolio'"></span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </section>

</div>
@endsection
