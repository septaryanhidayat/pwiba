@extends('layouts.public')

@section('title', 'Beranda Resmi PWI Kabupaten Banyuasin')

@section('content')
<div x-data="{ modalSambutan: false }">

<!-- 1. Hero Section -->
<section id="beranda" class="relative gradient-mesh text-white pt-24 pb-20 lg:pt-32 lg:pb-32 overflow-hidden">
    <!-- Ambient Glow Background Circles (Smooth Animated Floating Mesh) -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-blue-600/20 rounded-full blur-3xl pointer-events-none animate-orb-glow"></div>
    <div class="absolute top-1/3 right-10 w-[350px] h-[350px] bg-amber-500/15 rounded-full blur-2xl pointer-events-none animate-orb-glow-delayed"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <!-- Badge Indicator -->
                <div class="hero-badge-anim inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-semibold text-amber-400 backdrop-blur-md shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Portal Resmi Organisasi Pers Terverifikasi</span>
                </div>

                <!-- Main Headline -->
                <h1 class="hero-title-anim text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                    Sinergi Pers Bermartabat <br class="hidden sm:inline">
                    <span class="text-gradient-gold text-shimmer">Banyuasin Bangkit & Sejahtera</span>
                </h1>

                <!-- Subtitle -->
                <p class="hero-desc-anim text-base sm:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                    Wadah terdepan jurnalis profesional di Kabupaten Banyuasin, Sumatera Selatan. Menjaga kemerdekaan pers, meningkatkan kompetensi kewartawanan, dan mengawal pembangunan daerah dengan informasi akurat dan kredibel.
                </p>

                <!-- Dual CTA Buttons -->
                <div class="hero-cta-anim flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="#berita" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-bold text-slate-900 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/20 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-amber-500/30">
                        <i class="fa-solid fa-newspaper text-sm"></i>
                        <span>Baca Berita Terkini</span>
                    </a>
                    <a href="#bukutamu" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-white bg-white/10 hover:bg-white/15 border border-white/20 backdrop-blur-md transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-feather-pointed text-amber-400"></i>
                        <span>Isi Buku Tamu</span>
                    </a>
                </div>

                <!-- Quick Stats Pill List -->
                <div class="hero-stats-anim grid grid-cols-3 gap-4 pt-8 border-t border-white/10 max-w-lg mx-auto lg:mx-0">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">{{ $ukwStats['total_aktif'] ?? 48 }}</div>
                        <div class="text-xs text-slate-400">Wartawan Aktif</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-amber-400">{{ $mediaCount ?? 41 }}</div>
                        <div class="text-xs text-slate-400">Media Mitra</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">100%</div>
                        <div class="text-xs text-slate-400">Terverifikasi PWI</div>
                    </div>
                </div>

            </div>

            <!-- Right Hero Section: Foto Resmi Ketua PWI Banyuasin dengan Pose Eksekutif Profesional -->
            <div class="hero-card-anim lg:col-span-5 relative flex justify-center items-end">
                <div class="relative w-full max-w-md mx-auto group animate-float-slow">
                    <!-- Glow Backdrop -->
                    <div class="absolute -inset-2 bg-gradient-to-tr from-amber-500/20 via-blue-600/20 to-amber-400/20 rounded-3xl blur-2xl opacity-75 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Main Frame -->
                    <div class="relative rounded-3xl overflow-hidden border border-white/20 bg-gradient-to-b from-slate-900/80 via-slate-900/90 to-slate-950 shadow-2xl">
                        <!-- Top Official Tag -->
                        <div class="absolute top-4 left-4 z-20 flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-950/70 backdrop-blur-md border border-white/15 text-white shadow-lg">
                            <img src="{{ asset('assets/images/pwi-logo.webp') }}" alt="PWI Logo" width="16" height="16" class="w-4 h-4 object-contain" onerror="this.src='{{ asset('assets/images/pwi-logo.png') }}'">
                            <span class="text-[11px] font-bold tracking-wide">PWI BANYUASIN</span>
                        </div>

                        <div class="absolute top-4 right-4 z-20">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950 shadow-md">
                                Periode 2025–2028
                            </span>
                        </div>

                        <!-- Photo Portrait -->
                        <div class="relative pt-6 px-4 flex justify-center min-h-[380px] sm:min-h-[460px]">
                            <img src="{{ asset('assets/images/wardoyo-ketua.webp') }}" 
                                 alt="Wardoyo, S.I.Kom - Ketua PWI Banyuasin" 
                                 width="400"
                                 height="460"
                                 fetchpriority="high"
                                 loading="eager"
                                 decoding="sync"
                                 onerror="this.src='{{ asset('assets/images/wardoyo-ketua.png') }}'"
                                 class="w-full h-auto max-h-[460px] object-cover object-top drop-shadow-2xl rounded-2xl transform group-hover:scale-[1.02] transition-transform duration-500">
                        </div>

                        <!-- Executive Identity & Sambutan Singkat (Tanpa Status Wartawan) -->
                        <div class="p-5 sm:p-6 bg-gradient-to-t from-slate-950 via-slate-900/98 to-slate-900 border-t border-white/10 relative z-20">
                            <div>
                                <h3 class="text-xl font-black text-white tracking-tight">
                                    Wardoyo, S.I.Kom
                                </h3>
                                <div class="text-xs font-bold text-amber-400 uppercase tracking-wider mt-0.5">
                                    Ketua PWI Kabupaten Banyuasin
                                </div>
                            </div>

                            <!-- Sambutan Singkat Resmi Pelantikan -->
                            <div class="mt-3 pt-3 border-t border-white/10">
                                <p class="text-xs leading-relaxed text-slate-200 line-clamp-3 italic">
                                    "Pelantikan ini bukan sekadar seremonial, melainkan sebuah amanah dan tanggung jawab moral bagi kami para insan pers di Kabupaten Banyuasin untuk menjaga marwah profesi, memperkuat peran pers yang independen dan terus berkontribusi dalam pembangunan daerah."
                                </p>
                            </div>

                            <!-- Actions: Baca Sambutan Lengkap & Unduh Dokumen PDF -->
                            <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between gap-3">
                                <button @click="modalSambutan = true" 
                                        type="button" 
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-400 hover:text-amber-300 transition-colors cursor-pointer">
                                    <i class="fa-solid fa-book-open text-xs"></i>
                                    <span>Baca Sambutan Lengkap &rarr;</span>
                                </button>
                                <a href="{{ asset('assets/dokumen/sambutan-ketua.pdf') }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-[11px] font-bold text-white border border-white/15 transition-all shadow-sm">
                                    <i class="fa-solid fa-file-pdf text-rose-400"></i>
                                    <span>Unduh PDF</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 2. Profil Organisasi, Visi Misi & Sambutan Ketua (Side-by-Side) -->
<section id="profil" class="py-20 bg-white dark:bg-slate-900 transition-colors duration-200 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-400/10 px-3.5 py-1 rounded-full border border-amber-200 dark:border-amber-400/30">
                Profil & Landasan Organisasi
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mt-3">
                Membangun Ekosistem Jurnalisme Berintegritas
            </h2>
            <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base mt-3">
                PWI Kabupaten Banyuasin berlandaskan UU Pers No. 40 Tahun 1999 dan Kode Etik Jurnalistik dalam setiap langkah pengabdian pers.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- Left: Sambutan Ketua PWI Card -->
            <div class="lg:col-span-5 flex flex-col" data-aos="fade-up">
                <div class="bg-gradient-to-br from-slate-900 to-[#1C2541] rounded-3xl p-8 text-white shadow-xl relative overflow-hidden flex flex-col justify-between flex-grow hover-lift">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div>
                        <div class="flex flex-col sm:flex-row items-center gap-4 mb-6 text-center sm:text-left">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-2xl bg-amber-500/20 border-2 border-amber-400 p-0.5 overflow-hidden aspect-square">
                                    <img src="{{ asset('assets/images/wardoyo-ketua.webp') }}" alt="Ketua PWI Banyuasin" width="64" height="64" loading="lazy" decoding="async" onerror="this.src='{{ asset('assets/images/wardoyo-ketua.png') }}'" class="w-full h-full object-cover rounded-xl">
                                </div>
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-slate-900 flex items-center justify-center text-[9px]">
                                    <i class="fa-solid fa-check text-white"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white leading-tight">{{ $settings['ketua_nama'] ?? 'Wardoyo, S.I.Kom' }}</h4>
                                <p class="text-xs text-amber-400 font-semibold">Ketua PWI Kabupaten Banyuasin</p>
                                <span class="text-[10px] text-slate-400">Wartawan Utama • KTA: 06.00.17208.14B</span>
                            </div>
                        </div>

                        <div class="relative text-center sm:text-left">
                            <i class="fa-solid fa-quote-left text-amber-400/20 text-4xl absolute -top-3 -left-2 hidden sm:block"></i>
                            <p class="text-sm text-slate-300 italic leading-relaxed relative z-10 pl-0 sm:pl-6">
                                "Pelantikan ini bukan sekadar seremonial, melainkan sebuah amanah dan tanggung jawab moral bagi kami para insan pers di Kabupaten Banyuasin untuk menjaga marwah profesi, memperkuat peran pers yang independen dan terus berkontribusi dalam pembangunan daerah. Bersama pengurus PWI kami berkomitmen organisasi ini berjalan sesuai dengan fungsi dan perannya sebagai pilar keempat demokrasi, serta menjadi mitra strategis bagi seluruh elemen masyarakat."
                            </p>
                        </div>

                        <div class="mt-6 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                            <button @click="modalSambutan = true" type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all shadow-md cursor-pointer">
                                <i class="fa-solid fa-book-open"></i>
                                <span>Baca Sambutan Lengkap</span>
                            </button>
                            <a href="{{ asset('assets/dokumen/sambutan-ketua.pdf') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-white bg-white/10 hover:bg-white/20 border border-white/15 transition-all">
                                <i class="fa-solid fa-file-pdf text-rose-400"></i>
                                <span>Unduh PDF</span>
                            </a>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2 text-center sm:text-left">
                        <span>Pangkalan Balai, Banyuasin</span>
                        <span class="text-amber-400 font-semibold">Pers Tetap Bermartabat</span>
                    </div>
                </div>
            </div>

            <!-- Right: Visi & 4 Misi Cards -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-4">
                
                <!-- Visi Card -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:border-amber-400/50 transition-all text-center sm:text-left hover-lift" data-aos="fade-up">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3 mb-2">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-base flex-shrink-0">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h4 class="text-base font-bold text-slate-900 dark:text-white mt-1 sm:mt-0">Visi Organisasi</h4>
                    </div>
                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-medium">
                        {{ $settings['visi'] ?? 'Memperkuat peran PWI Banyuasin dalam peningkatan profesionalisme wartawan melalui pelatihan, Uji Kompetensi dan kolaborasi dengan berbagai pihak.' }}
                    </p>
                </div>

                <!-- 4 Misi Grid Cards (Asli pwiba.or.id) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-md transition-all text-center sm:text-left flex flex-col items-center sm:items-start hover-lift" data-aos="fade-up" data-aos-delay="40">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm font-bold mb-3">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h5 class="text-sm font-bold text-slate-900 dark:text-white mb-1">1. Solid & Berdaya Saing</h5>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Menjadikan PWI Banyuasin sebagai wadah yang lebih solid, profesional, dan berdaya saing tinggi.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-md transition-all text-center sm:text-left flex flex-col items-center sm:items-start hover-lift" data-aos="fade-up" data-aos-delay="80">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm font-bold mb-3">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <h5 class="text-sm font-bold text-slate-900 dark:text-white mb-1">2. Kontribusi Nyata Pers</h5>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Berkontribusi nyata bagi masyarakat serta kemajuan kemerdekaan pers nasional.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-md transition-all text-center sm:text-left flex flex-col items-center sm:items-start hover-lift" data-aos="fade-up" data-aos-delay="120">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-sm font-bold mb-3">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h5 class="text-sm font-bold text-slate-900 dark:text-white mb-1">3. Kesejahteraan & Solidaritas</h5>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Meningkatkan kesejahteraan dan solidaritas anggota dengan mendorong program dukungan bagi jurnalis.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-md transition-all text-center sm:text-left flex flex-col items-center sm:items-start hover-lift" data-aos="fade-up" data-aos-delay="160">
                        <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-sm font-bold mb-3">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <h5 class="text-sm font-bold text-slate-900 dark:text-white mb-1">4. Kemitraan Strategis</h5>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Menjalin kemitraan strategis dengan pemerintah, swasta, dan ormas untuk memperluas ruang gerak jurnalis.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

<!-- 3. Susunan Pengurus Inti Section -->
<section id="kepengurusan" class="py-24 bg-slate-50 dark:bg-slate-950 border-y border-slate-200/80 dark:border-slate-800 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/70 px-4 py-1.5 rounded-full border border-blue-200 dark:border-blue-800 shadow-sm">
                <i class="fa-solid fa-users text-[11px]"></i> PENGURUS INTI PWI
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-3 tracking-tight">
                Pimpinan Eksekutif <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-300">PWI Banyuasin</span>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2">
                Pimpinan eksekutif Persatuan Wartawan Indonesia Kabupaten Banyuasin Periode 2025–2028
            </p>
        </div>

        <!-- 4 Symmetrical Executive Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($structures->take(4) as $s)
                <div class="group bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 flex flex-col justify-between"
                     data-aos="fade-up" 
                     data-aos-delay="{{ $loop->iteration * 40 }}">
                    
                    <!-- Symmetrical Photo Frame -->
                    <div class="relative w-full aspect-[3/4] bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <img src="{{ $s->foto_url }}" alt="{{ $s->nama }}" width="300" height="400" loading="lazy" decoding="async" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105">
                        
                        <!-- Subtle Bottom Gradient -->
                        <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-60 group-hover:opacity-30 transition-opacity"></div>
                    </div>

                    <!-- Executive Info & Social Media Links -->
                    <div class="p-6 text-center flex flex-col justify-between flex-grow">
                        <div>
                            <!-- Jabatan Pill -->
                            <div class="inline-block px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-blue-50 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800/80 mb-2">
                                {{ $s->jabatan }}
                            </div>
                            
                            <!-- Nama Lengkap & Gelar -->
                            <h3 class="text-base font-extrabold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-snug">
                                {{ $s->nama }}
                            </h3>
                        </div>

                        <!-- Social Media Icon Links (X, FB, IG, YouTube) -->
                        <div class="pt-5 mt-4 border-t border-slate-100 dark:border-slate-800">
                            <div class="flex items-center justify-center gap-2">
                                <!-- X / Twitter -->
                                <a href="{{ $s->x_twitter ?: 'https://x.com/pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black flex items-center justify-center text-xs transition-all duration-200 shadow-sm hover:scale-110" title="X (Twitter)">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                                <!-- Facebook -->
                                <a href="{{ $s->facebook ?: 'https://facebook.com/pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-[#1877F2] hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-sm hover:scale-110" title="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <!-- Instagram -->
                                <a href="{{ $s->instagram ?: 'https://instagram.com/pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-rose-500 hover:to-purple-600 hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-sm hover:scale-110" title="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                                <!-- YouTube -->
                                <a href="{{ $s->youtube ?: 'https://youtube.com/@pwibanyuasin' }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-[#FF0000] hover:text-white flex items-center justify-center text-xs transition-all duration-200 shadow-sm hover:scale-110" title="YouTube">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-slate-400 font-medium">
                    Data pengurus inti belum tersedia.
                </div>
            @endforelse
        </div>

        <!-- Tombol Anggota Lengkap -->
        <div class="mt-14 text-center" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('organization.public') }}" class="inline-flex items-center gap-3.5 px-8 py-4 rounded-2xl bg-[#0B132B] dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white font-bold text-sm shadow-xl shadow-slate-900/10 dark:shadow-blue-600/20 transition-all duration-300 group hover:-translate-y-0.5">
                <i class="fa-solid fa-id-card-clip text-blue-400 dark:text-blue-200 group-hover:scale-110 transition-transform"></i>
                <span>Lihat Seluruh Anggota & Wartawan PWI Banyuasin</span>
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1.5 transition-transform"></i>
            </a>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3 font-medium">
                Daftar lengkap 32 jajaran pengurus divisi dan 48 wartawan resmi terverifikasi
            </p>
        </div>

    </div>
</section>

<!-- 4. Berita & Publikasi Terkini Section -->
<section id="berita" class="py-20 bg-white dark:bg-slate-900 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4 text-center sm:text-left items-center sm:items-end" data-aos="fade-up">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-400/10 px-3.5 py-1 rounded-full border border-amber-200 dark:border-amber-400/30">
                    Publikasi & Rilis Pers
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                    Berita & Kabar Terkini PWI Banyuasin
                </h2>
                <p class="text-slate-600 dark:text-slate-300 text-sm mt-1">Liputan resmi kegiatan jurnalistik, kemitraan, dan advokasi pers</p>
            </div>
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 group">
                <span>Lihat Semua Berita</span>
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $p)
                <article class="bg-white dark:bg-slate-800/90 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group hover:-translate-y-1.5"
                         data-aos="fade-up"
                         data-aos-delay="{{ $loop->iteration * 40 }}">
                    
                    <!-- Post Thumbnail -->
                    <a href="{{ route('news.show', $p->slug) }}" class="relative block overflow-hidden aspect-[16/10] bg-slate-100 dark:bg-slate-800">
                        <img src="{{ $p->gambar_url }}" alt="{{ $p->judul }}" width="400" height="250" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-900/80 text-amber-300 backdrop-blur-md shadow-sm border border-white/10">
                                {{ $p->kategori }}
                            </span>
                        </div>
                    </a>

                    <!-- Post Body -->
                    <div class="p-6 flex flex-col flex-grow justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                                <span><i class="fa-regular fa-calendar me-1"></i> {{ $p->published_at ? $p->published_at->translatedFormat('d M Y') : '-' }}</span>
                                <span>•</span>
                                <span><i class="fa-regular fa-eye me-1"></i> {{ $p->views_count }} views</span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ route('news.show', $p->slug) }}">
                                    {{ $p->judul }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 line-clamp-3 leading-relaxed">
                                {{ $p->ringkasan ?? Str::limit(strip_tags($p->konten), 120) }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                            <span class="text-slate-700 dark:text-slate-300 font-semibold flex items-center gap-1.5">
                                <i class="fa-solid fa-pen-nib text-amber-500"></i> {{ $p->penulis }}
                            </span>
                            <a href="{{ route('news.show', $p->slug) }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">
                                Baca <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </a>
                        </div>
                    </div>

                </article>
            @empty
                <div class="col-span-3 text-center py-10 text-slate-400">
                    Belum ada artikel berita yang dipublikasikan.
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- 5. Galeri Dokumentasi Interaktif (Lightbox Modal) -->
<section id="galeri" class="py-20 bg-slate-900 text-white relative overflow-hidden" x-data="{ selectedPhoto: null, selectedTitle: '', selectedDate: '', selectedDesc: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4 text-center sm:text-left items-center sm:items-end" data-aos="fade-up">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-white/10 px-3.5 py-1 rounded-full border border-white/15">
                    Dokumentasi Visual
                </span>
                <h2 class="text-3xl font-extrabold text-white mt-2">
                    Galeri Kegiatan PWI Banyuasin
                </h2>
                <p class="text-slate-400 text-sm mt-1">Potret dinamika, kebersamaan, dan pengabdian insan pers Banyuasin</p>
            </div>
            <a href="{{ route('gallery.public') }}" class="inline-flex items-center gap-2 text-sm font-bold text-amber-400 hover:text-amber-300 group">
                <span>Lihat Seluruh Galeri ({{ $galleryCount ?? 17 }})</span>
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($galleries->take(6) as $g)
                <div @click="selectedPhoto = '{{ $g->foto_url }}'; selectedTitle = '{{ addslashes($g->judul) }}'; selectedDate = '{{ $g->tanggal_kegiatan ? $g->tanggal_kegiatan->translatedFormat('d F Y') : '-' }}'; selectedDesc = '{{ addslashes($g->deskripsi) }}'" 
                     class="group relative rounded-2xl overflow-hidden aspect-[4/3] bg-slate-800 cursor-pointer shadow-lg hover-lift"
                     data-aos="fade-up"
                     data-aos-delay="{{ $loop->iteration * 40 }}">
                    <img src="{{ $g->foto_url }}" alt="{{ $g->judul }}" width="400" height="300" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                    
                    <div class="absolute bottom-0 inset-x-0 p-5">
                        <span class="text-[10px] font-semibold text-amber-400 uppercase tracking-wider block mb-1">
                            {{ $g->tanggal_kegiatan ? $g->tanggal_kegiatan->translatedFormat('d M Y') : 'Dokumentasi' }}
                        </span>
                        <h4 class="text-sm font-bold text-white line-clamp-2 leading-snug">
                            {{ $g->judul }}
                        </h4>
                    </div>

                    <div class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fa-solid fa-expand text-xs"></i>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-slate-500">
                    Belum ada dokumentasi foto galeri.
                </div>
            @endforelse
        </div>

        <!-- Lightbox Modal -->
        <div x-show="selectedPhoto" x-cloak @click.away="selectedPhoto = null" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md">
            <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                <button @click="selectedPhoto = null" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/60 text-white hover:bg-black flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <img :src="selectedPhoto" :alt="selectedTitle" class="w-full max-h-[65vh] object-contain bg-black">
                <div class="p-6 bg-slate-900 text-white">
                    <div class="text-xs text-amber-400 font-semibold" x-text="selectedDate"></div>
                    <h3 class="text-lg font-bold text-white mt-1" x-text="selectedTitle"></h3>
                    <p class="text-xs text-slate-300 mt-2" x-text="selectedDesc"></p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- 6. Formulir Buku Tamu / Hubungi PWI Publik (PRD v2.0 Form) -->
<section id="bukutamu" class="py-20 bg-slate-50 dark:bg-slate-950 transition-colors duration-200 relative">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden" data-aos="fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                
                <!-- Left Sidebar: Contact Info -->
                <div class="lg:col-span-5 bg-gradient-to-br from-[#0B132B] to-[#1C2541] p-8 sm:p-10 text-white flex flex-col justify-between text-center lg:text-left items-center lg:items-start" data-aos="fade-up">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Buku Tamu & Kemitraan</span>
                        <h3 class="text-2xl font-extrabold text-white mt-2 leading-tight">
                            Hubungi Pengurus PWI Banyuasin
                        </h3>
                        <p class="text-xs text-slate-300 mt-3 leading-relaxed">
                            Bagi instansi pemerintah, swasta, akademisi, maupun masyarakat yang ingin menjalin audiensi, silaturahmi, atau menyampaikan informasi publik.
                        </p>

                        <div class="space-y-4 mt-8 text-xs text-slate-300 flex flex-col items-center lg:items-start">
                            <div class="flex flex-col sm:flex-row items-center lg:items-start gap-3 text-center sm:text-left">
                                <div class="w-7 h-7 rounded-lg bg-white/10 text-amber-400 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <span class="max-w-xs lg:max-w-none">Jl. Merdeka No. 3 RT 02 RW 02, Kel. Mulya Agung, Kec. Banyuasin III</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-white/10 text-amber-400 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <span>0853-7799-1976 (Sekretariat)</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-white/10 text-amber-400 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <span>sekretariat@pwibanyuasin.or.id</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/10 text-[11px] text-slate-400 text-center lg:text-left">
                        Pesan Anda akan otomatis terarsip dalam Sistem Informasi Manajemen Administrasi PWI.
                    </div>
                </div>

                <!-- Right Form Area -->
                <div class="lg:col-span-7 p-8 sm:p-10" data-aos="fade-up">
                    
                    @if(session('success_inbox'))
                        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                            <div>{{ session('success_inbox') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('inbox.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                                <input type="text" name="nama" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none" placeholder="Nama Anda...">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Instansi / Lembaga</label>
                                <input type="text" name="instansi" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none" placeholder="Dinas / Organisasi / Pribadi">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nomor Kontak / WA *</label>
                                <input type="text" name="telepon" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none" placeholder="08xxxxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Email (Opsional)</label>
                                <input type="email" name="email" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none" placeholder="nama@email.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Tujuan & Keperluan *</label>
                            <input type="text" name="keperluan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none" placeholder="Contoh: Permohonan Audiensi Kemitraan Publikasi">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Isi Pesan / Maksud *</label>
                            <textarea name="pesan" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none" placeholder="Tuliskan isi permohonan atau pesan lengkap Anda di sini..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim ke Buku Tamu PWI</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- Modal Sambutan Lengkap Ketua PWI Banyuasin (Sesuai Naskah Asli PDF) -->
<div x-show="modalSambutan" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-md overflow-y-auto"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">
    
    <div class="relative w-full max-w-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl overflow-hidden my-8"
         @click.away="modalSambutan = false">
        
        <!-- Modal Header -->
        <div class="p-6 bg-gradient-to-r from-[#0B132B] to-[#1C2541] text-white flex items-center justify-between border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/pwi-logo.png') }}" alt="Logo PWI" width="36" height="36" loading="lazy" decoding="async" class="w-9 h-9 object-contain">
                <div>
                    <h3 class="text-base font-bold text-white">Naskah Sambutan Resmi Pelantikan</h3>
                    <p class="text-xs text-amber-400 font-medium">Ketua PWI Kabupaten Banyuasin Masa Bakti 2025–2028</p>
                </div>
            </div>
            <button @click="modalSambutan = false" class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Modal Body (Official Speech Text) -->
        <div class="p-6 sm:p-8 space-y-6 max-h-[70vh] overflow-y-auto text-slate-700 dark:text-slate-200 text-sm leading-relaxed">
            
            <div class="text-center pb-4 border-b border-slate-200 dark:border-slate-800">
                <div class="font-extrabold text-[#0B132B] dark:text-white text-base">PERSATUAN WARTAWAN INDONESIA (PWI)</div>
                <div class="font-bold text-amber-600 dark:text-amber-400 text-sm">KABUPATEN BANYUASIN</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Gedung Auditorium Pemkab Banyuasin • Rabu, 26 November 2025
                </div>
            </div>

            <div class="space-y-4 font-sans">
                <p class="font-bold text-slate-900 dark:text-white">
                    Bismillahirahmanirrahim<br>
                    Assalamu’alaikum Wr. Wb.<br>
                    Selamat pagi dan salam sejahtera untuk kita semua.
                </p>
                
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-xs space-y-1.5">
                    <div class="font-bold text-slate-900 dark:text-white mb-1.5 uppercase tracking-wider">Yang saya hormati :</div>
                    <ul class="list-disc list-inside space-y-1 text-slate-700 dark:text-slate-300">
                        <li>Ketua PWI Provinsi Sumatera Selatan beserta jajaran pengurus</li>
                        <li>Bupati Banyuasin beserta Wakil Bupati Banyuasin</li>
                        <li>Sekda Banyuasin</li>
                        <li>Ketua DPRD Kabupaten Banyuasin</li>
                        <li>Unsur Forum Koordinasi Pimpinan Daerah (Forkopimda) Kabupaten Banyuasin</li>
                        <li>Ketua KPU Banyuasin</li>
                        <li>Kepala Cabang Bank Mandiri Pangkalan Balai</li>
                        <li>Para tokoh masyarakat, rekan-rekan insan pers serta hadirin sekalian yang berbahagia.</li>
                    </ul>
                </div>

                <p>
                    Mengawali sambutan ini perkenankanlah saya mengajak Bapak / Ibu untuk senantiasa memanjatkan Puji syukur ke hadirat Allah Subhanahu wa Ta’ala, Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, kita dapat berkumpul di Gedung Auditorium Pemkab Banyuasin dalam keadaan sehat dalam rangka menghadiri acara pelantikan Pengurus Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin Masa bakti 2025-2028. Rabu 26 November 2025.
                </p>

                <p class="font-bold text-slate-900 dark:text-white">Hadirin yang saya hormati,</p>

                <p>
                    Pelantikan ini bukan sekadar seremonial, melainkan sebuah amanah dan tanggung jawab moral bagi kami para insan pers di Kabupaten Banyuasin untuk menjaga marwah profesi, memperkuat peran pers yang independen dan terus berkontribusi dalam pembangunan daerah.
                </p>

                <p>
                    Saya pribadi merasa terhormat, sekaligus tertantang atas kepercayaan yang diberikan kepada saya untuk memimpin PWI Kabupaten Banyuasin. Amanah ini bukan untuk dibanggakan, tetapi untuk dijalankan dengan penuh tanggung jawab, integritas dan dedikasi.
                </p>

                <p>
                    Bersama pengurus PWI kami berkomitmen organisasi ini berjalan sesuai dengan fungsi dan perannya sebagai pilar keempat demokrasi, serta menjadi mitra strategis bagi pemerintah daerah, DPRD, Forkopimda dan seluruh elemen masyarakat.
                </p>

                <p class="font-bold text-slate-900 dark:text-white">Hadirin yang saya hormati,</p>

                <p>
                    Kabupaten Banyuasin dikenal sebagai daerah yang kaya sumber daya alam dan potensi pertanian. Melalui peran PWI, kami ingin mendorong dan bersinergi dengan Pemerintah Kabupaten Banyuasin dalam mewujudkan visi besar <strong>Menjadikan Kabupaten Banyuasin sebagai lumbung pangan nasional dan daerah penghasil padi peringkat pertama di Indonesia</strong>.
                </p>

                <p>
                    Kami menyadari, cita-cita besar ini tidak bisa dicapai sendiri. Diperlukan kerjasama yang solid antara pemerintah, masyarakat dan insan pers.
                </p>

                <p>
                    Kami PWI Banyuasin siap menjadi jembatan komunikasi, penyambung informasi yang akurat, edukatif dan konstruktif untuk membangun kesadaran bersama akan pentingnya ketahanan pangan dan kesejahteraan masyarakat.
                </p>

                <p>
                    Kami juga bertekad untuk terus meningkatkan kapasitas wartawan di Banyuasin, agar senantiasa profesional, beretika, dan mampu menyajikan informasi yang mencerahkan publik.
                </p>

                <p>
                    Akhirnya, izinkan saya menyampaikan terima kasih yang sebesar-besarnya kepada Ketua PWI Provinsi Sumatera Selatan dan jajaran, kepada Bupati dan Wakil Bupati Banyuasin, Ketua DPRD Banyuasin, Forkopimda, serta seluruh pihak yang telah membantu atas terselenggaranya pelantikan ini.
                </p>

                <p>
                    Semoga ke depan, sinergi antara PWI, pemerintah, dan seluruh stakeholder dapat terus terjalin erat demi kemajuan Banyuasin dan Sumatera Selatan.
                </p>

                <p class="font-bold text-[#0B132B] dark:text-amber-400 text-base">
                    Mari kita bekerja bersama berkolaborasi dan berkarya untuk Banyuasin bangkit, adil sejahtera dan berkelanjutan.
                </p>

                <p>
                    Sekian dan Terima kasih.<br>
                    Wassalamu’alaikum Wr. Wb.
                </p>

                <div class="pt-6 text-right">
                    <div class="font-bold text-xs uppercase text-slate-500 dark:text-slate-400">KETUA PWI BANYUASIN</div>
                    <div class="text-lg font-black text-[#0B132B] dark:text-white mt-1">WARDOYO, S.I.Kom</div>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="p-6 bg-slate-50 dark:bg-slate-950/80 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ asset('assets/dokumen/sambutan-ketua.pdf') }}" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-md transition-all">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Unduh Dokumen Asli (PDF)</span>
            </a>
            <button @click="modalSambutan = false" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 transition-all cursor-pointer">
                Tutup
            </button>
        </div>

    </div>

</div>

</div>
@endsection
