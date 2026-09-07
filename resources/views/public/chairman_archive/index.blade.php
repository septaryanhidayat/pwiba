@extends('layouts.public')

@section('title', 'Portofolio Eksekutif & Arsip Karya Wardoyo, S.I.Kom. - Ketua PWI Banyuasin')
@section('meta_description', 'Portofolio resmi dan rekam jejak kepemimpinan Wardoyo, S.I.Kom. - Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin Periode 2025–2028, Wartawan Utama Dewan Pers, dan praktisi pers.')
@section('meta_image', asset('assets/images/wardoyo-share.jpg'))
@section('meta_image_width', '800')
@section('meta_image_height', '800')
@section('meta_image_type', 'image/jpeg')
@section('meta_type', 'profile')

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
    <!-- 1. HERO SECTION: COMPANY PROFILE / PORTOFOLIO RESMI UTAMA                 -->
    <!-- ========================================================================= -->
    <section class="relative min-h-[calc(100vh-68px)] flex flex-col justify-center bg-gradient-to-b from-[#070D1E] via-[#0B132B] to-[#142042] text-white py-12 sm:py-16 lg:py-20 overflow-hidden border-b border-white/10">
        
        <!-- Ambient Decorative Glows -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none animate-orb-glow"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none animate-orb-glow-delayed"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Left Column: Biography & Headline (7 Cols) -->
                <div class="lg:col-span-7 space-y-5 sm:space-y-6 text-center lg:text-left">
                    
                    <!-- Verified Figure Pill -->
                    <div class="hero-badge-anim inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-400/10 border border-amber-400/30 text-amber-400 text-xs sm:text-sm font-black uppercase tracking-wider backdrop-blur-md shadow-sm mx-auto lg:mx-0">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <i class="fa-solid fa-shield-halved text-amber-400"></i>
                        <span>{{ str_ireplace('Personal Branding', 'Portofolio', $profile['badge_top'] ?? 'Profil Eksekutif & Portofolio Resmi') }}</span>
                    </div>

                    <!-- Name & Title -->
                    <div class="hero-title-anim space-y-2">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                            @php
                                $nameParts = explode(',', $profile['name'], 2);
                                $mainName = $nameParts[0];
                                $degree = isset($nameParts[1]) ? ', ' . trim($nameParts[1]) : '';
                            @endphp
                            <span>{{ $mainName }}</span><span class="text-gradient-gold text-shimmer font-extrabold text-3xl sm:text-4xl lg:text-5xl">{{ $degree }}</span>
                        </h1>
                        <p class="text-sm sm:text-base text-slate-300 font-semibold flex items-center justify-center lg:justify-start gap-2">
                            <span class="text-amber-400">●</span>
                            <span>{{ $profile['title'] }}</span>
                        </p>
                        <p class="text-xs sm:text-sm text-slate-400 font-mono">
                            {{ $profile['sk_resmi'] }}
                        </p>
                    </div>

                    <!-- Motto / Visi Kepemimpinan -->
                    <div class="hero-desc-anim p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md relative">
                        <div class="text-amber-400 text-3xl font-serif absolute -top-3 left-4 select-none opacity-50">“</div>
                        <p class="text-sm sm:text-[15px] text-slate-200 italic leading-relaxed pt-1 font-medium">
                            {{ $profile['motto'] }}
                        </p>
                    </div>

                    <!-- Key Metrics Grid -->
                    <div class="hero-stats-anim grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-3.5 pt-1">
                        <div class="p-3 sm:p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs hover:border-amber-400/40 transition-colors">
                            <span class="block text-2xl sm:text-3xl font-black text-amber-400">{{ $profile['stat_karya'] ?? ($totalArticles . '+') }}</span>
                            <span class="text-[10px] sm:text-[11px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_karya_label'] ?? 'Karya Tulis' }}</span>
                        </div>
                        <div class="p-3 sm:p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs hover:border-white/30 transition-colors">
                            <span class="block text-2xl sm:text-3xl font-black text-white">{{ $profile['stat_kiprah'] ?? '18+ Th' }}</span>
                            <span class="text-[10px] sm:text-[11px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_kiprah_label'] ?? 'Kiprah Jurnalistik' }}</span>
                        </div>
                        <div class="p-3 sm:p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs hover:border-emerald-400/40 transition-colors">
                            <span class="block text-2xl sm:text-3xl font-black text-emerald-400">{{ $profile['stat_lisensi'] ?? 'Utama' }}</span>
                            <span class="text-[10px] sm:text-[11px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_lisensi_label'] ?? 'Lisensi UKW' }}</span>
                        </div>
                        <div class="p-3 sm:p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs hover:border-blue-400/40 transition-colors">
                            <span class="block text-2xl sm:text-3xl font-black text-blue-300">{{ $profile['stat_pendidikan'] ?? 'S.I.Kom.' }}</span>
                            <span class="text-[10px] sm:text-[11px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_pendidikan_label'] ?? 'Ilmu Komunikasi' }}</span>
                        </div>
                    </div>

                    <!-- Call To Actions (Email, Portfolio, Copy Link) -->
                    <div class="hero-cta-anim flex flex-wrap items-center justify-center lg:justify-start gap-3 pt-2 max-w-xl mx-auto lg:mx-0">
                        @if(!empty($profile['kontak']['email']))
                        <!-- Direct Email -->
                        <a href="mailto:{{ $profile['kontak']['email'] }}" class="px-5 py-3 rounded-xl text-xs sm:text-sm font-black text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-md shadow-amber-500/20 transition-all transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2 text-center whitespace-nowrap">
                            <i class="fa-solid fa-envelope text-xs sm:text-sm text-slate-950"></i>
                            <span>Kirim Pesan</span>
                        </a>
                        @endif

                        <!-- Scroll to Writings -->
                        <a href="#karya-arsip" class="px-5 py-3 rounded-xl text-xs sm:text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all inline-flex items-center justify-center gap-2 text-center whitespace-nowrap">
                            <i class="fa-solid fa-book-bookmark text-amber-400 text-xs sm:text-sm"></i>
                            <span>Karya Tulis</span>
                        </a>

                        <!-- Share / Copy Link -->
                        <button @click="shareUrl()" type="button" class="px-4 py-3 rounded-xl text-xs sm:text-sm font-bold text-slate-200 bg-white/5 hover:bg-white/10 border border-white/15 transition-all inline-flex items-center justify-center gap-2 cursor-pointer text-center whitespace-nowrap">
                            <i class="fa-solid text-xs sm:text-sm" :class="copied ? 'fa-check text-emerald-400' : 'fa-share-nodes'"></i>
                            <span x-text="copied ? 'Tersalin!' : 'Bagikan'"></span>
                        </button>
                    </div>

                </div>

                <!-- Right Column: Official Portrait Picture & Identity Badge (5 Cols) -->
                <div class="hero-card-anim lg:col-span-5 flex justify-center lg:justify-end items-center">
                    <div class="relative w-full max-w-[360px] sm:max-w-[400px] lg:max-w-[430px] group animate-float-slow">
                        
                        <!-- Glow Backdrop Frame -->
                        <div class="absolute -inset-2 rounded-3xl bg-gradient-to-tr from-amber-500 via-blue-600 to-amber-300 opacity-30 blur-2xl"></div>

                        <!-- Card Container -->
                        <div class="relative rounded-3xl bg-gradient-to-b from-[#1C2541] to-[#0B132B] border-2 border-amber-400/40 p-4 sm:p-4.5 shadow-2xl space-y-3">
                            
                            <!-- Official Photo Frame with Balanced Height -->
                            <div class="relative w-full h-64 sm:h-72 lg:h-[340px] rounded-2xl overflow-hidden bg-slate-900 border border-white/10 shadow-inner group">
                                <img src="{{ $profile['foto_url'] }}" 
                                     alt="{{ $profile['name'] }} - {{ $profile['title'] }}" 
                                     class="w-full h-full object-cover object-[center_16%] transform group-hover:scale-105 transition-transform duration-700"
                                     fetchpriority="high">
                                
                                <!-- Official Gold Ribbon Corner -->
                                <div class="absolute top-2.5 right-2.5 px-3 py-1 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-lg flex items-center gap-1.5 border border-white/30">
                                    <i class="fa-solid fa-award text-xs"></i>
                                    <span>Ketua 2025–2028</span>
                                </div>

                                <!-- Subtle Gradient Overlay at Bottom of Photo -->
                                <div class="absolute inset-x-0 bottom-0 h-14 bg-gradient-to-t from-[#0B132B] via-[#0B132B]/80 to-transparent flex items-end p-3">
                                    <div class="text-white leading-tight">
                                        <p class="text-[9px] sm:text-[10px] font-bold text-amber-400 uppercase tracking-wider">SK PWI Pusat</p>
                                        <p class="text-[10px] sm:text-xs font-mono font-bold text-slate-200">{{ $profile['sk_resmi'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Identity Summary Card -->
                            <div class="p-3 sm:p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center space-y-1.5 backdrop-blur-xs">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[8.5px] sm:text-[9.5px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30">
                                    <i class="fa-solid fa-award text-[9px]"></i>
                                    <span>{{ $profile['badge_bawah_foto'] ?? 'PWI KABUPATEN BANYUASIN' }}</span>
                                </div>
                                <h3 class="text-base sm:text-lg font-black text-white tracking-wide">
                                    {{ $profile['judul_bawah_foto'] ?? 'Ketua PWI Banyuasin' }}
                                </h3>
                                <p class="text-xs text-slate-300 font-medium">
                                    {{ $profile['subjudul_bawah_foto'] ?? 'Masa Bakti 2025 – 2028' }}
                                </p>
                                
                                <!-- Social & Email Icons -->
                                <div class="pt-1.5 flex items-center justify-center gap-2.5">
                                    @if(!empty($profile['kontak']['instagram']))
                                    <a href="{{ $profile['kontak']['instagram'] }}" target="_blank" rel="noopener noreferrer" 
                                       class="w-8 h-8 rounded-xl bg-gradient-to-tr from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-90 hover:scale-105 active:scale-95 text-white flex items-center justify-center text-xs shadow-sm transition-all shrink-0" 
                                       title="Instagram @wardianstp" aria-label="Instagram">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    @endif

                                    @if(!empty($profile['kontak']['facebook']))
                                    <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" 
                                       class="w-8 h-8 rounded-xl bg-[#1877F2] hover:bg-[#166fe5] hover:scale-105 active:scale-95 text-white flex items-center justify-center text-xs shadow-sm transition-all shrink-0" 
                                       title="Facebook Wardoyo" aria-label="Facebook">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    @endif

                                    @if(!empty($profile['kontak']['email']))
                                    <a href="mailto:{{ $profile['kontak']['email'] }}" 
                                       class="w-8 h-8 rounded-xl bg-amber-400 hover:bg-amber-300 hover:scale-105 active:scale-95 text-slate-950 flex items-center justify-center text-xs shadow-sm transition-all shrink-0" 
                                       title="Email {{ $profile['kontak']['email'] }}" aria-label="Email">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                    @endif
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
    <section class="py-16 sm:py-20 bg-gradient-to-b from-slate-100/90 via-blue-50/20 to-amber-50/15 dark:from-slate-900 dark:via-slate-900 dark:to-slate-950 border-b border-slate-200 dark:border-slate-800 transition-colors relative overflow-hidden">
        
        <!-- Ambient Decorative Spots -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 lg:gap-x-10 gap-y-6 lg:gap-y-6 items-stretch">
                
                <!-- Left Wrapper (Mobile: flex col, Desktop: lg:contents) -->
                <div class="flex flex-col space-y-5 lg:contents">
                    
                    <!-- Left Header (Col 1, Row 1 on desktop) -->
                    <div class="lg:col-start-1 lg:row-start-1 flex flex-col justify-between space-y-3.5 text-center lg:text-left" data-aos="fade-up">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 dark:bg-amber-400/15 border border-amber-400/30 text-amber-700 dark:text-amber-300 text-xs font-black uppercase tracking-wider shadow-xs mx-auto lg:mx-0">
                            <i class="fa-solid fa-user-pen text-amber-500"></i>
                            <span>{{ $profile['narasi_subjudul'] ?? 'Tentang Kepemimpinan & Pengabdian' }}</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-[28px] font-black text-slate-900 dark:text-white leading-snug">
                            {{ $profile['narasi_judul'] ?? 'Komitmen Teruji Mengawal Integritas Pers & Pembangunan Banyuasin' }}
                        </h2>
                    </div>

                    <!-- Left Content: Kotak Kalimat & 1-Line Social Pills (Col 1, Row 2 on desktop) -->
                    <div class="lg:col-start-1 lg:row-start-2 flex flex-col justify-between h-full space-y-4" data-aos="fade-up" data-aos-delay="40">
                        <!-- Unified Narrative Card (Kotak Kalimat) -->
                        <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/90 dark:border-slate-700/80 shadow-sm flex-1 flex flex-col justify-between space-y-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed text-left">
                            @if(!empty($profile['narasi_paragraf_1']))
                                <p class="font-medium text-slate-800 dark:text-slate-200">
                                    {!! nl2br(e($profile['narasi_paragraf_1'])) !!}
                                </p>
                            @endif
                            @if(!empty($profile['narasi_paragraf_2']))
                                <p class="border-t border-slate-100 dark:border-slate-700/60 pt-3.5">
                                    {!! nl2br(e($profile['narasi_paragraf_2'])) !!}
                                </p>
                            @endif
                            @if(!empty($profile['narasi_paragraf_3']))
                                <p class="border-t border-slate-100 dark:border-slate-700/60 pt-3.5">
                                    {!! nl2br(e($profile['narasi_paragraf_3'])) !!}
                                </p>
                            @endif
                        </div>

                        <!-- Fast Contact Bar (No scrollbar, full-width 4 cols, aligned at the bottom) -->
                        <div class="w-full pt-1">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs font-bold w-full">
                                @if(!empty($profile['kontak']['email']))
                                <a href="mailto:{{ $profile['kontak']['email'] }}" class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-2xl bg-amber-50 dark:bg-amber-950/40 text-amber-900 dark:text-amber-300 border border-amber-200/90 dark:border-amber-800/70 hover:bg-amber-100 dark:hover:bg-amber-900/60 transition-all shadow-xs group text-center" title="{{ $profile['kontak']['email'] }}">
                                    <i class="fa-solid fa-envelope text-amber-500 group-hover:scale-110 transition-transform text-xs shrink-0"></i>
                                    <span class="truncate">Email</span>
                                </a>
                                @endif

                                @if(!empty($profile['kontak']['instagram']))
                                <a href="{{ $profile['kontak']['instagram'] }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-2xl bg-pink-50 dark:bg-pink-950/40 text-pink-700 dark:text-pink-300 border border-pink-200/90 dark:border-pink-800/70 hover:bg-pink-100 dark:hover:bg-pink-900/60 transition-all shadow-xs group text-center">
                                    <i class="fa-brands fa-instagram text-pink-500 group-hover:scale-110 transition-transform text-xs shrink-0"></i>
                                    <span>Instagram</span>
                                </a>
                                @endif

                                @if(!empty($profile['kontak']['facebook']))
                                <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-2xl bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300 border border-blue-200/90 dark:border-blue-800/70 hover:bg-blue-100 dark:hover:bg-blue-900/60 transition-all shadow-xs group text-center">
                                    <i class="fa-brands fa-facebook-f text-blue-600 group-hover:scale-110 transition-transform text-xs shrink-0"></i>
                                    <span>Facebook</span>
                                </a>
                                @endif

                                @if(!empty($profile['lokasi_singkat']))
                                <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200/90 dark:border-emerald-800/70 shadow-xs text-center" title="{{ $profile['lokasi_singkat'] }}">
                                    <i class="fa-solid fa-location-dot text-emerald-600 text-xs shrink-0"></i>
                                    <span class="truncate">{{ $profile['lokasi_singkat'] }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Wrapper (Mobile: flex col, Desktop: lg:contents) -->
                <div class="flex flex-col space-y-4 lg:contents">
                    
                    <!-- Right Header (Col 2, Row 1 on desktop) -->
                    <div class="lg:col-start-2 lg:row-start-1 flex flex-col justify-between space-y-3.5 text-center lg:text-left mt-8 lg:mt-0" data-aos="fade-up" data-aos-delay="40">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 dark:bg-blue-400/15 border border-blue-400/30 text-blue-700 dark:text-blue-300 text-xs font-black uppercase tracking-wider shadow-xs mx-auto lg:mx-0">
                            <i class="fa-solid fa-compass text-blue-500"></i>
                            <span>4 Pilar Nilai Kepemimpinan</span>
                        </div>

                        <h3 class="text-xl sm:text-2xl lg:text-[28px] font-black text-slate-900 dark:text-white leading-snug">
                            Landasan Strategis PWI Banyuasin <br class="hidden lg:inline">& 4 Pilar Nilai Kepemimpinan
                        </h3>
                    </div>

                    <!-- Right Content: Kotak Integritas (Pilar 01) & 4 Pilar Cards (Col 2, Row 2 on desktop) -->
                    <div class="lg:col-start-2 lg:row-start-2 space-y-3.5 flex flex-col justify-between h-full" data-aos="fade-up" data-aos-delay="60">
                        @php
                            $pilarThemes = [
                                [
                                    'border' => 'border-blue-200/90 hover:border-blue-400 dark:border-blue-800/70',
                                    'bg' => 'bg-gradient-to-br from-blue-50/90 via-white to-blue-50/30 dark:from-blue-950/30 dark:via-slate-900 dark:to-slate-900',
                                    'icon' => 'bg-gradient-to-tr from-blue-600 to-indigo-600 text-white shadow-blue-500/25',
                                    'title' => 'group-hover:text-blue-600 dark:group-hover:text-blue-400',
                                    'tag' => 'bg-blue-100/80 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300',
                                    'num' => '01',
                                ],
                                [
                                    'border' => 'border-amber-200/90 hover:border-amber-400 dark:border-amber-800/70',
                                    'bg' => 'bg-gradient-to-br from-amber-50/90 via-white to-amber-50/30 dark:from-amber-950/30 dark:via-slate-900 dark:to-slate-900',
                                    'icon' => 'bg-gradient-to-tr from-amber-500 to-orange-500 text-white shadow-amber-500/25',
                                    'title' => 'group-hover:text-amber-600 dark:group-hover:text-amber-400',
                                    'tag' => 'bg-amber-100/80 text-amber-900 dark:bg-amber-900/60 dark:text-amber-300',
                                    'num' => '02',
                                ],
                                [
                                    'border' => 'border-emerald-200/90 hover:border-emerald-400 dark:border-emerald-800/70',
                                    'bg' => 'bg-gradient-to-br from-emerald-50/90 via-white to-emerald-50/30 dark:from-emerald-950/30 dark:via-slate-900 dark:to-slate-900',
                                    'icon' => 'bg-gradient-to-tr from-emerald-600 to-teal-600 text-white shadow-emerald-500/25',
                                    'title' => 'group-hover:text-emerald-600 dark:group-hover:text-emerald-400',
                                    'tag' => 'bg-emerald-100/80 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300',
                                    'num' => '03',
                                ],
                                [
                                    'border' => 'border-purple-200/90 hover:border-purple-400 dark:border-purple-800/70',
                                    'bg' => 'bg-gradient-to-br from-purple-50/90 via-white to-purple-50/30 dark:from-purple-950/30 dark:via-slate-900 dark:to-slate-900',
                                    'icon' => 'bg-gradient-to-tr from-purple-600 to-indigo-600 text-white shadow-purple-500/25',
                                    'title' => 'group-hover:text-purple-600 dark:group-hover:text-purple-400',
                                    'tag' => 'bg-purple-100/80 text-purple-800 dark:bg-purple-900/60 dark:text-purple-300',
                                    'num' => '04',
                                ],
                            ];
                        @endphp
                        @foreach($profile['pilar_nilai'] as $idx => $pilar)
                            @php $theme = $pilarThemes[$idx % count($pilarThemes)]; @endphp
                            <div class="p-4 sm:p-5 rounded-2xl {{ $theme['bg'] }} border {{ $theme['border'] }} shadow-xs flex items-start gap-4 transition-all duration-300 group hover:-translate-y-0.5 hover:shadow-md" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration) * 50 }}">
                                <div class="w-11 h-11 rounded-xl {{ $theme['icon'] }} flex items-center justify-center font-bold shrink-0 shadow-md group-hover:scale-105 transition-transform">
                                    <i class="{{ $pilar['icon'] ?? 'fa-solid fa-award' }} text-sm"></i>
                                </div>
                                <div class="space-y-1 text-left">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white {{ $theme['title'] }} transition-colors">
                                            {{ $pilar['title'] }}
                                        </h3>
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider {{ $theme['tag'] }}">
                                            Pilar {{ $theme['num'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {{ $pilar['desc'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 3. BENTO GRID: REKAM JEJAK ORGANISASI & KEPEMIMPINAN                     -->
    <!-- ========================================================================= -->
    <section class="py-16 sm:py-20 bg-gradient-to-b from-[#080E24] via-[#0D183A] to-[#0A122C] text-white border-b border-white/10 relative overflow-hidden">
        
        <!-- Ambient Decorative Glows -->
        <div class="absolute top-10 left-10 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 sm:space-y-12 relative z-10">
            
            <div class="text-center max-w-3xl mx-auto space-y-3" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/15 border border-blue-400/30 text-blue-300 text-xs font-black uppercase tracking-wider backdrop-blur-md shadow-sm">
                    <i class="fa-solid fa-sitemap text-amber-400"></i>
                    <span>Kepemimpinan Multisektor</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                    Rekam Jejak Organisasi & <span class="bg-gradient-to-r from-amber-300 via-yellow-200 to-amber-400 bg-clip-text text-transparent">Pengabdian Masyarakat</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl mx-auto">
                    Pengalaman luas dalam mengemban amanah kepemimpinan di ranah organisasi profesi pers, pemantau pemilu, asosiasi jasa konstruksi, perdagangan pasar, serta olahraga dan seni beladiri.
                </p>
            </div>

            @php
                $orgThemes = [
                    // 0: Sapphire Blue (PWI Utama)
                    [
                        'border' => 'border-blue-500/30 hover:border-blue-400',
                        'bg' => 'bg-gradient-to-br from-blue-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-blue-500/20 text-blue-300 border-blue-400/40',
                        'icon' => 'bg-blue-500/20 text-blue-300 border border-blue-400/30',
                        'tag' => 'text-blue-300',
                        'glow' => 'hover:shadow-blue-500/15',
                    ],
                    // 1: Cyan / Sky (PWI Periode Sebelumnya)
                    [
                        'border' => 'border-cyan-500/30 hover:border-cyan-400',
                        'bg' => 'bg-gradient-to-br from-cyan-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-cyan-500/20 text-cyan-300 border-cyan-400/40',
                        'icon' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-400/30',
                        'tag' => 'text-cyan-300',
                        'glow' => 'hover:shadow-cyan-500/15',
                    ],
                    // 2: Indigo (PWI Dewan Penasihat)
                    [
                        'border' => 'border-indigo-500/30 hover:border-indigo-400',
                        'bg' => 'bg-gradient-to-br from-indigo-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-indigo-500/20 text-indigo-300 border-indigo-400/40',
                        'icon' => 'bg-indigo-500/20 text-indigo-300 border border-indigo-400/30',
                        'tag' => 'text-indigo-300',
                        'glow' => 'hover:shadow-indigo-500/15',
                    ],
                    // 3: Emerald (Pemantau Pemilu)
                    [
                        'border' => 'border-emerald-500/30 hover:border-emerald-400',
                        'bg' => 'bg-gradient-to-br from-emerald-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-emerald-500/20 text-emerald-300 border-emerald-400/40',
                        'icon' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30',
                        'tag' => 'text-emerald-300',
                        'glow' => 'hover:shadow-emerald-500/15',
                    ],
                    // 4: Amber / Gold (Jasa Konstruksi Gapeksindo)
                    [
                        'border' => 'border-amber-500/30 hover:border-amber-400',
                        'bg' => 'bg-gradient-to-br from-amber-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-amber-500/20 text-amber-300 border-amber-400/40',
                        'icon' => 'bg-amber-500/20 text-amber-300 border border-amber-400/30',
                        'tag' => 'text-amber-300',
                        'glow' => 'hover:shadow-amber-500/15',
                    ],
                    // 5: Purple / Violet (Pedagang Pasar)
                    [
                        'border' => 'border-purple-500/30 hover:border-purple-400',
                        'bg' => 'bg-gradient-to-br from-purple-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-purple-500/20 text-purple-300 border-purple-400/40',
                        'icon' => 'bg-purple-500/20 text-purple-300 border border-purple-400/30',
                        'tag' => 'text-purple-300',
                        'glow' => 'hover:shadow-purple-500/15',
                    ],
                    // 6: Rose / Crimson (Keluarga Besar Tarung Derajat)
                    [
                        'border' => 'border-rose-500/30 hover:border-rose-400',
                        'bg' => 'bg-gradient-to-br from-rose-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-rose-500/20 text-rose-300 border-rose-400/40',
                        'icon' => 'bg-rose-500/20 text-rose-300 border border-rose-400/30',
                        'tag' => 'text-rose-300',
                        'glow' => 'hover:shadow-rose-500/15',
                    ],
                    // 7: Teal (Kemitraan Daerah)
                    [
                        'border' => 'border-teal-500/30 hover:border-teal-400',
                        'bg' => 'bg-gradient-to-br from-teal-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-teal-500/20 text-teal-300 border-teal-400/40',
                        'icon' => 'bg-teal-500/20 text-teal-300 border border-teal-400/30',
                        'tag' => 'text-teal-300',
                        'glow' => 'hover:shadow-teal-500/15',
                    ],
                    // 8: Yellow / Gold (Forum Komunikasi)
                    [
                        'border' => 'border-yellow-500/30 hover:border-yellow-400',
                        'bg' => 'bg-gradient-to-br from-yellow-900/25 via-slate-900/70 to-[#0A122C]/90',
                        'badge' => 'bg-yellow-500/20 text-yellow-300 border-yellow-400/40',
                        'icon' => 'bg-yellow-500/20 text-yellow-300 border border-yellow-400/30',
                        'tag' => 'text-yellow-300',
                        'glow' => 'hover:shadow-yellow-500/15',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($profile['organisasi'] as $idx => $org)
                    @php $cardTheme = $orgThemes[$idx % count($orgThemes)]; @endphp
                    <div class="{{ $cardTheme['bg'] }} rounded-3xl p-6 border {{ $cardTheme['border'] }} shadow-xl {{ $cardTheme['glow'] }} backdrop-blur-md transition-all duration-300 flex flex-col justify-between space-y-4 group hover:-translate-y-1.5" data-aos="fade-up" data-aos-delay="{{ min(($loop->iteration - 1) * 50, 250) }}">
                        <div class="space-y-3.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $cardTheme['badge'] }}">
                                    {{ $org['masa'] }}
                                </span>
                                <div class="w-8 h-8 rounded-xl {{ $cardTheme['icon'] }} flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <h3 class="text-sm sm:text-base font-black text-white group-hover:text-amber-300 transition-colors leading-snug">
                                {{ $org['posisi'] }}
                            </h3>
                            @if(!empty($org['ket']))
                                <p class="text-xs text-slate-300 leading-relaxed font-normal">
                                    {{ $org['ket'] }}
                                </p>
                            @endif
                        </div>
                        <div class="pt-3.5 border-t border-white/10 text-[11px] font-bold {{ $cardTheme['tag'] }} flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>Rekam Jejak Terverifikasi</span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 4. PENDIDIKAN & SERTIFIKASI KHUSUS                                       -->
    <!-- ========================================================================= -->
    <section class="py-16 sm:py-20 pb-20 sm:pb-24 bg-gradient-to-b from-slate-100/80 via-blue-50/20 to-slate-100/90 dark:from-slate-900 dark:via-slate-900 dark:to-slate-950 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10 items-stretch">
                
                <!-- Riwayat Pendidikan (Sapphire Blue Dossier - 50% Width) -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-blue-200/90 dark:border-blue-900/60 shadow-lg overflow-hidden flex flex-col" data-aos="fade-up">
                    
                    <!-- Decorative Top Ribbon -->
                    <div class="h-2.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500 w-full shrink-0"></div>

                    <div class="p-6 sm:p-7 space-y-5 flex-1 flex flex-col justify-between">
                        <div class="space-y-2 text-center sm:text-left">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300 text-xs font-black uppercase tracking-wider mx-auto sm:mx-0">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>Kualifikasi Akademik</span>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                                Pendidikan Formal & Keilmuan
                            </h3>
                        </div>

                        <div class="space-y-3.5 flex-1">
                            @foreach($profile['pendidikan'] as $edu)
                                @php $isCompleted = $edu['is_completed'] ?? true; @endphp
                                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/90 dark:bg-slate-800/70 border border-slate-200/90 dark:border-slate-700/80 hover:border-blue-400 transition-all duration-300 flex items-center justify-between gap-4 relative overflow-hidden shadow-xs">
                                    <!-- Left Colored Accent Strip -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $isCompleted ? 'bg-blue-600' : 'bg-amber-500' }}"></div>

                                    <div class="pl-2.5 space-y-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $isCompleted ? 'bg-blue-600 text-white shadow-xs' : 'bg-amber-400 text-slate-950 shadow-xs' }}">
                                                {{ $edu['tingkat'] }}
                                            </span>
                                            @if(! $isCompleted)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 dark:bg-amber-900/60 text-amber-900 dark:text-amber-300 border border-amber-300 dark:border-amber-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                    <span>{{ $edu['status'] ?? 'Sedang Ditempuh' }}</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700">
                                                    <i class="fa-solid fa-check text-[9px]"></i>
                                                    <span>{{ $edu['status'] ?? 'Lulus' }}</span>
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 dark:text-white mt-1">{{ $edu['instansi'] }}</h4>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 font-medium">{{ $edu['prodi'] }}</p>
                                    </div>
                                    
                                    @if(! $isCompleted)
                                        <div class="w-9 h-9 rounded-full bg-amber-400/20 text-amber-600 dark:text-amber-400 border border-amber-300 dark:border-amber-700 flex items-center justify-center text-xs shrink-0 shadow-xs" title="Studi Berjalan (Sedang Ditempuh)">
                                            <i class="fa-solid fa-hourglass-half"></i>
                                        </div>
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs shrink-0 shadow-sm" title="Lulus">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sertifikasi & Pelatihan Khusus (Royal Gold Dossier - 50% Width) -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-amber-200/90 dark:border-amber-900/60 shadow-lg overflow-hidden flex flex-col" data-aos="fade-up" data-aos-delay="40">
                    
                    <!-- Decorative Top Ribbon -->
                    <div class="h-2.5 bg-gradient-to-r from-amber-500 via-yellow-400 to-orange-500 w-full shrink-0"></div>

                    <div class="p-6 sm:p-7 space-y-5 flex-1 flex flex-col justify-between">
                        <div class="space-y-2 text-center sm:text-left">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-900 dark:text-amber-300 text-xs font-black uppercase tracking-wider mx-auto sm:mx-0">
                                <i class="fa-solid fa-certificate"></i>
                                <span>Standarisasi Profesi</span>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                                Sertifikasi & Pelatihan Jurnalistik
                            </h3>
                        </div>

                        <div class="space-y-3.5 flex-1">
                            @foreach($profile['sertifikasi'] as $cert)
                                @php $isUtama = str_contains(strtolower($cert['bidang']), 'utama'); @endphp
                                <div class="p-4 sm:p-5 rounded-2xl border transition-all duration-300 space-y-1.5 relative overflow-hidden shadow-xs {{ $isUtama ? 'border-2 border-amber-400 bg-gradient-to-br from-amber-50/90 via-yellow-50/40 to-white dark:from-amber-950/30 dark:via-slate-800/90 dark:to-slate-800/90' : 'border border-slate-200/90 dark:border-slate-700/80 bg-slate-50/90 dark:bg-slate-800/70 hover:border-amber-400' }}">
                                    <!-- Left Colored Accent Strip -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $isUtama ? 'bg-amber-500' : 'bg-amber-400/60' }}"></div>

                                    <div class="pl-2.5 space-y-1.5">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex items-center gap-2">
                                                @if($isUtama)
                                                    <span class="w-6 h-6 rounded-lg bg-amber-400 text-slate-950 flex items-center justify-center text-xs shadow-xs shrink-0">
                                                        <i class="fa-solid fa-medal"></i>
                                                    </span>
                                                @endif
                                                <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 dark:text-white leading-snug">{{ $cert['bidang'] }}</h4>
                                            </div>
                                            @if(!empty($cert['tahun']))
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 dark:bg-amber-900/60 text-amber-900 dark:text-amber-300 border border-amber-300/80 dark:border-amber-700/80 shrink-0">
                                                    {{ $cert['tahun'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs font-bold text-blue-700 dark:text-amber-400">{{ $cert['penerbit'] }}</p>
                                        @if(!empty($cert['nomor']) && trim($cert['nomor']) !== '-')
                                            <p class="text-[11px] font-mono text-slate-600 dark:text-slate-300 font-medium">No: {{ $cert['nomor'] }}</p>
                                        @endif
                                        @if(!empty($cert['penguji']) && trim($cert['penguji']) !== '-')
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">Penguji: {{ $cert['penguji'] }}</p>
                                        @endif
                                        @if(!empty($cert['keterangan']) && trim($cert['keterangan']) !== '-')
                                            <p class="text-xs text-slate-700 dark:text-slate-300 font-medium">{{ $cert['keterangan'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 5. KATALOG 320 ARSIP KARYA TULIS (THE MASTER ARCHIVE)                     -->
    <!-- ========================================================================= -->
    <section class="py-16 sm:py-20 bg-gradient-to-b from-slate-50 via-slate-100/70 to-slate-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950" id="karya-arsip">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- Section Header -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-6 border-b border-slate-200 dark:border-slate-800 text-center lg:text-left" data-aos="fade-up">
                <div class="space-y-2 max-w-4xl mx-auto lg:mx-0">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/15 border border-amber-400/30 text-amber-800 dark:text-amber-300 text-xs font-black uppercase tracking-wider mx-auto lg:mx-0">
                        <i class="fa-solid fa-feather-pointed text-amber-500"></i>
                        <span>Arsip Digital Komprehensif</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-[32px] xl:text-[36px] font-black text-slate-900 dark:text-white whitespace-normal lg:whitespace-nowrap tracking-tight leading-snug text-center lg:text-left">
                        Katalog Tulisan & Koleksi <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-amber-300 dark:to-yellow-400 bg-clip-text text-transparent">320 Karya Pemikiran</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto lg:mx-0 text-center lg:text-left">
                        Dokumentasi karya tulisan, esai teori komunikasi politik, analisis berita, dan liputan jurnalistik resmi yang telah disanitasi dan diarsipkan ke dalam format modern.
                    </p>
                </div>

                <div class="flex items-center justify-center lg:justify-end gap-2 shrink-0 mx-auto lg:mx-0">
                    <button @click="shareUrl()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2 shadow-xs cursor-pointer">
                        <i class="fa-solid" :class="copied ? 'fa-check text-emerald-500' : 'fa-share-nodes text-amber-500'"></i>
                        <span x-text="copied ? 'Tautan Tersalin!' : 'Bagikan Katalog'"></span>
                    </button>
                </div>
            </div>

            <!-- Search, Category & Year Bar -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-7 shadow-md space-y-5 relative overflow-hidden" data-aos="fade-up" data-aos-delay="40">
                <!-- Top Accent Line -->
                <div class="h-1 bg-gradient-to-r from-blue-600 via-amber-400 to-purple-600 -mt-5 sm:-mt-7 -mx-5 sm:-mx-7 mb-5"></div>

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
                            <button type="submit" class="absolute right-2 top-2 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-xs shadow-sm transition-all cursor-pointer">
                                Cari
                            </button>
                        </div>
                    </form>

                    <!-- Filter Year Dropdown -->
                    <div class="flex items-center gap-3 w-full md:w-auto justify-center md:justify-end">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Filter Tahun:</span>
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

                <!-- Category Bento Hub (Structured, Modern, Symmetrical, Beautiful & Thematic) -->
                @php
                    $categoryIcons = [
                        'politik & pemilu' => ['icon' => 'fa-solid fa-landmark', 'color' => 'text-amber-500'],
                        'opini & catatan' => ['icon' => 'fa-solid fa-feather-pointed', 'color' => 'text-purple-500'],
                        'pers & jurnalistik' => ['icon' => 'fa-solid fa-newspaper', 'color' => 'text-emerald-500'],
                        'hukum & keadilan' => ['icon' => 'fa-solid fa-scale-balanced', 'color' => 'text-indigo-500'],
                        'daerah & kebijakan' => ['icon' => 'fa-solid fa-building-columns', 'color' => 'text-rose-500'],
                        'profil & biografi' => ['icon' => 'fa-solid fa-user-tie', 'color' => 'text-cyan-500'],
                        'teori komunikasi' => ['icon' => 'fa-solid fa-graduation-cap', 'color' => 'text-orange-500'],
                    ];
                    $isAllActive = !request('kategori');
                @endphp

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-2 sm:gap-2.5">
                        <!-- All Categories Card -->
                        <a href="{{ route('chairman.archive.index', request()->except('kategori')) }}#karya-arsip" 
                           class="group/cat flex items-center justify-between p-2.5 sm:p-3 rounded-2xl border transition-all duration-300 {{ $isAllActive ? 'bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700 text-white border-blue-600 shadow-md shadow-blue-600/25 ring-2 ring-blue-500/30 font-black' : 'bg-slate-50/90 dark:bg-slate-800/80 hover:bg-white dark:hover:bg-slate-800 border-slate-200/90 dark:border-slate-700/80 text-slate-700 dark:text-slate-200 hover:border-amber-400 hover:shadow-xs' }}">
                            <div class="flex items-center gap-2 sm:gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center text-xs shrink-0 {{ $isAllActive ? 'bg-white/20 text-white' : 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border border-blue-200/60 dark:border-blue-800/60' }}">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <span class="text-xs font-bold truncate">Semua Kategori</span>
                            </div>
                            <span class="ml-1.5 px-2 py-0.5 rounded-lg text-[10px] font-black shrink-0 {{ $isAllActive ? 'bg-white/20 text-white' : 'bg-slate-200/80 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                                {{ $totalArticles }}
                            </span>
                        </a>

                        <!-- Specific Category Cards -->
                        @foreach($categories as $cat)
                            @php
                                $catKey = strtolower(trim($cat->category));
                                $catMeta = $categoryIcons[$catKey] ?? ['icon' => 'fa-solid fa-tag', 'color' => 'text-slate-500'];
                                $isActive = (request('kategori') == $cat->category);
                            @endphp
                            <a href="{{ route('chairman.archive.index', array_merge(request()->query(), ['kategori' => $cat->category])) }}#karya-arsip" 
                               class="group/cat flex items-center justify-between p-2.5 sm:p-3 rounded-2xl border transition-all duration-300 {{ $isActive ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950 border-amber-400 font-black shadow-md shadow-amber-500/20 ring-2 ring-amber-400/40' : 'bg-slate-50/90 dark:bg-slate-800/80 hover:bg-white dark:hover:bg-slate-800 border-slate-200/90 dark:border-slate-700/80 text-slate-700 dark:text-slate-200 hover:border-amber-400 hover:shadow-xs' }}">
                                <div class="flex items-center gap-2 sm:gap-2.5 min-w-0">
                                    <div class="w-7 h-7 rounded-xl flex items-center justify-center text-xs shrink-0 {{ $isActive ? 'bg-black/15 text-slate-950' : 'bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/80 ' . $catMeta['color'] }}">
                                        <i class="{{ $catMeta['icon'] }}"></i>
                                    </div>
                                    <span class="text-xs font-bold truncate group-hover/cat:text-amber-600 dark:group-hover/cat:text-amber-400 transition-colors">{{ $cat->category }}</span>
                                </div>
                                <span class="ml-1.5 px-2 py-0.5 rounded-lg text-[10px] font-black shrink-0 {{ $isActive ? 'bg-black/15 text-slate-950' : 'bg-slate-200/80 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                                    {{ $cat->total }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- Articles Grid (Dynamic Vibrant Top Accents) -->
            @if($articles->count() > 0)
                @php
                    $articleAccents = [
                        [
                            'border' => 'border-t-4 border-t-blue-600 hover:border-blue-400',
                            'badge' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800/80',
                            'title' => 'group-hover:text-blue-600 dark:group-hover:text-blue-400',
                            'btn' => 'text-blue-600 dark:text-blue-400',
                            'shadow' => 'hover:shadow-blue-500/10',
                        ],
                        [
                            'border' => 'border-t-4 border-t-amber-500 hover:border-amber-400',
                            'badge' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/40 dark:text-amber-300 dark:border-amber-800/80',
                            'title' => 'group-hover:text-amber-600 dark:group-hover:text-amber-400',
                            'btn' => 'text-amber-600 dark:text-amber-400',
                            'shadow' => 'hover:shadow-amber-500/10',
                        ],
                        [
                            'border' => 'border-t-4 border-t-purple-600 hover:border-purple-400',
                            'badge' => 'bg-purple-50 text-purple-700 border-purple-200 dark:bg-purple-900/40 dark:text-purple-300 dark:border-purple-800/80',
                            'title' => 'group-hover:text-purple-600 dark:group-hover:text-purple-400',
                            'btn' => 'text-purple-600 dark:text-purple-400',
                            'shadow' => 'hover:shadow-purple-500/10',
                        ],
                        [
                            'border' => 'border-t-4 border-t-emerald-600 hover:border-emerald-400',
                            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300 dark:border-emerald-800/80',
                            'title' => 'group-hover:text-emerald-600 dark:group-hover:text-emerald-400',
                            'btn' => 'text-emerald-600 dark:text-emerald-400',
                            'shadow' => 'hover:shadow-emerald-500/10',
                        ],
                        [
                            'border' => 'border-t-4 border-t-rose-600 hover:border-rose-400',
                            'badge' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/40 dark:text-rose-300 dark:border-rose-800/80',
                            'title' => 'group-hover:text-rose-600 dark:group-hover:text-rose-400',
                            'btn' => 'text-rose-600 dark:text-rose-400',
                            'shadow' => 'hover:shadow-rose-500/10',
                        ],
                        [
                            'border' => 'border-t-4 border-t-teal-600 hover:border-teal-400',
                            'badge' => 'bg-teal-50 text-teal-700 border-teal-200 dark:bg-teal-900/40 dark:text-teal-300 dark:border-teal-800/80',
                            'title' => 'group-hover:text-teal-600 dark:group-hover:text-teal-400',
                            'btn' => 'text-teal-600 dark:text-teal-400',
                            'shadow' => 'hover:shadow-teal-500/10',
                        ],
                    ];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                    @foreach($articles as $idx => $post)
                        @php $accent = $articleAccents[$idx % count($articleAccents)]; @endphp
                        <article class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 {{ $accent['border'] }} p-6 shadow-sm hover:shadow-xl {{ $accent['shadow'] }} transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ min(($loop->iteration - 1) * 40, 160) }}">
                            <div>
                                <!-- Top Metadata Pill -->
                                <div class="flex items-center justify-between gap-2 mb-3.5">
                                    <span class="px-3 py-1 rounded-lg text-[11px] font-black tracking-wide uppercase border {{ $accent['badge'] }}">
                                        {{ $post->category }}
                                    </span>
                                    <span class="text-[11px] font-semibold text-slate-400 flex items-center gap-1">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>{{ $post->reading_time }} mnt baca</span>
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white {{ $accent['title'] }} transition-colors leading-snug line-clamp-2">
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

                                <a href="{{ route('chairman.archive.show', $post->slug) }}" class="inline-flex items-center gap-1.5 font-black {{ $accent['btn'] }} group-hover:translate-x-1 transition-transform">
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
    <section class="py-16 sm:py-20 bg-gradient-to-br from-[#060B18] via-[#0B132B] to-[#142042] text-white relative overflow-hidden border-t border-white/10">
        <!-- Ambient Decorative Glows -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="bg-gradient-to-r from-blue-900/40 via-slate-900/70 to-amber-950/40 border-2 border-white/15 rounded-3xl p-8 sm:p-12 shadow-2xl backdrop-blur-md" data-aos="fade-up">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <div class="lg:col-span-8 space-y-4 text-center lg:text-left">
                        <span class="px-3.5 py-1.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-md inline-block mx-auto lg:mx-0">
                            {{ $profile['footer_badge'] ?? 'Silaturahmi & Kemitraan Strategis' }}
                        </span>
                        <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                            {{ $profile['footer_title'] ?? 'Terhubung Langsung dengan Wardoyo, S.I.Kom.' }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            {{ $profile['footer_desc'] ?? 'Terbuka untuk ruang diskusi, kemitraan strategis kelembagaan, audiensi pers, narasumber media & jurnalisme, maupun silaturahmi pembangunan daerah Kabupaten Banyuasin.' }}
                        </p>

                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2.5 sm:gap-3 pt-2 text-xs">

                            @if(!empty($profile['kontak']['instagram']))
                            <a href="{{ $profile['kontak']['instagram'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-gradient-to-tr from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-90 hover:scale-105 active:scale-95 text-white font-black flex items-center justify-center gap-2 shadow-lg shadow-pink-500/20 transition-all w-full sm:w-auto">
                                <i class="fa-brands fa-instagram text-sm"></i>
                                <span>Instagram</span>
                            </a>
                            @endif
                            @if(!empty($profile['kontak']['facebook']))
                            <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-[#1877F2] hover:bg-[#166fe5] hover:scale-105 active:scale-95 text-white font-black flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20 transition-all w-full sm:w-auto">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                                <span>Facebook</span>
                            </a>
                            @endif
                            @if(!empty($profile['kontak']['email']))
                            <a href="mailto:{{ $profile['kontak']['email'] }}" class="px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 hover:scale-105 active:scale-95 text-slate-950 font-black flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20 transition-all w-full sm:w-auto">
                                <i class="fa-solid fa-envelope text-slate-950"></i>
                                <span>{{ $profile['kontak']['email'] }}</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="lg:col-span-4 flex flex-col items-center justify-center gap-3 p-6 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                        <div class="w-16 h-16 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-2xl font-black shadow-lg">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <h4 class="text-sm font-black text-white">Kartu Portofolio Digital</h4>
                        <p class="text-[11px] text-slate-300">Bagikan halaman portofolio resmi ini kepada kolega atau pemangku kepentingan.</p>
                        
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
