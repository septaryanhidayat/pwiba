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
    <section class="relative bg-gradient-to-b from-[#070D1E] via-[#0B132B] to-[#142042] text-white py-14 sm:py-16 lg:py-20 overflow-hidden border-b border-white/10">
        
        <!-- Ambient Decorative Glows -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Column: Biography & Headline (7 Cols) -->
                <div class="lg:col-span-7 space-y-4 sm:space-y-5 text-center lg:text-left">
                    
                    <!-- Verified Figure Pill -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/10 border border-amber-400/30 text-amber-400 text-xs font-black uppercase tracking-wider backdrop-blur-md shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <i class="fa-solid fa-shield-halved text-amber-400"></i>
                        <span>{{ str_ireplace('Personal Branding', 'Portofolio', $profile['badge_top'] ?? 'Profil Eksekutif & Portofolio Resmi') }}</span>
                    </div>

                    <!-- Name & Title -->
                    <div class="space-y-1 sm:space-y-1.5">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-tight">
                            @php
                                $nameParts = explode(',', $profile['name'], 2);
                                $mainName = $nameParts[0];
                                $degree = isset($nameParts[1]) ? ', ' . trim($nameParts[1]) : '';
                            @endphp
                            <span>{{ $mainName }}</span><span class="text-amber-400 font-extrabold text-2xl sm:text-3xl lg:text-4xl">{{ $degree }}</span>
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-300 font-semibold flex items-center justify-center lg:justify-start gap-2">
                            <span class="text-amber-400">●</span>
                            <span>{{ $profile['title'] }}</span>
                        </p>
                        <p class="text-[11px] text-slate-400 font-mono">
                            {{ $profile['sk_resmi'] }}
                        </p>
                    </div>

                    <!-- Motto / Visi Kepemimpinan -->
                    <div class="p-3.5 sm:p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md relative">
                        <div class="text-amber-400 text-2xl font-serif absolute -top-2.5 left-4 select-none opacity-50">“</div>
                        <p class="text-xs sm:text-[13px] text-slate-200 italic leading-relaxed pt-0.5 font-medium">
                            {{ $profile['motto'] }}
                        </p>
                    </div>

                    <!-- Key Metrics Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-2.5 pt-1">
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-xl sm:text-2xl font-black text-amber-400">{{ $profile['stat_karya'] ?? ($totalArticles . '+') }}</span>
                            <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_karya_label'] ?? 'Karya Tulis' }}</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-xl sm:text-2xl font-black text-white">{{ $profile['stat_kiprah'] ?? '18+ Th' }}</span>
                            <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_kiprah_label'] ?? 'Kiprah Jurnalistik' }}</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-xl sm:text-2xl font-black text-emerald-400">{{ $profile['stat_lisensi'] ?? 'Utama' }}</span>
                            <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_lisensi_label'] ?? 'Lisensi UKW' }}</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-white/5 border border-white/10 text-center backdrop-blur-xs">
                            <span class="block text-xl sm:text-2xl font-black text-blue-300">{{ $profile['stat_pendidikan'] ?? 'S.I.Kom.' }}</span>
                            <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">{{ $profile['stat_pendidikan_label'] ?? 'Ilmu Komunikasi' }}</span>
                        </div>
                    </div>

                    <!-- Call To Actions (Email, Portfolio, Copy Link) -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 pt-1 max-w-lg mx-auto lg:mx-0">
                        @if(!empty($profile['kontak']['email']))
                        <!-- Direct Email -->
                        <a href="mailto:{{ $profile['kontak']['email'] }}" class="px-3.5 py-2 rounded-xl text-xs font-black text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-md shadow-amber-500/20 transition-all transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-1.5 text-center whitespace-nowrap">
                            <i class="fa-solid fa-envelope text-xs text-slate-950"></i>
                            <span>Kirim Pesan</span>
                        </a>
                        @endif

                        <!-- Scroll to Writings -->
                        <a href="#karya-arsip" class="px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all inline-flex items-center justify-center gap-1.5 text-center whitespace-nowrap">
                            <i class="fa-solid fa-book-bookmark text-amber-400 text-xs"></i>
                            <span>Karya Tulis</span>
                        </a>

                        <!-- Share / Copy Link -->
                        <button @click="shareUrl()" type="button" class="px-3 py-2 rounded-xl text-xs font-bold text-slate-200 bg-white/5 hover:bg-white/10 border border-white/15 transition-all inline-flex items-center justify-center gap-1.5 cursor-pointer text-center whitespace-nowrap">
                            <i class="fa-solid text-xs" :class="copied ? 'fa-check text-emerald-400' : 'fa-share-nodes'"></i>
                            <span x-text="copied ? 'Tersalin!' : 'Bagikan'"></span>
                        </button>
                    </div>

                </div>

                <!-- Right Column: Official Portrait Picture & Identity Badge (5 Cols) -->
                <div class="lg:col-span-5 flex justify-center items-center">
                    <div class="relative w-full max-w-[310px] sm:max-w-[330px]">
                        
                        <!-- Glow Backdrop Frame -->
                        <div class="absolute -inset-1.5 rounded-3xl bg-gradient-to-tr from-amber-500 via-blue-600 to-amber-300 opacity-25 blur-xl"></div>

                        <!-- Card Container -->
                        <div class="relative rounded-3xl bg-gradient-to-b from-[#1C2541] to-[#0B132B] border-2 border-amber-400/40 p-3 sm:p-3.5 shadow-2xl space-y-2.5">
                            
                            <!-- Official Photo Frame with Balanced Height -->
                            <div class="relative w-full h-52 sm:h-56 rounded-2xl overflow-hidden bg-slate-900 border border-white/10 shadow-inner group">
                                <img src="{{ $profile['foto_url'] }}" 
                                     alt="{{ $profile['name'] }} - {{ $profile['title'] }}" 
                                     class="w-full h-full object-cover object-[center_18%] transform group-hover:scale-105 transition-transform duration-700"
                                     fetchpriority="high">
                                
                                <!-- Official Gold Ribbon Corner -->
                                <div class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[8.5px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-lg flex items-center gap-1 border border-white/30">
                                    <i class="fa-solid fa-award"></i>
                                    <span>Ketua 2025–2028</span>
                                </div>

                                <!-- Subtle Gradient Overlay at Bottom of Photo -->
                                <div class="absolute inset-x-0 bottom-0 h-12 bg-gradient-to-t from-[#0B132B] via-[#0B132B]/75 to-transparent flex items-end p-2.5">
                                    <div class="text-white leading-tight">
                                        <p class="text-[8.5px] font-bold text-amber-400 uppercase tracking-wider">SK PWI Pusat</p>
                                        <p class="text-[9.5px] font-mono font-bold text-slate-200">{{ $profile['sk_resmi'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Identity Summary Card -->
                            <div class="p-2.5 sm:p-3 rounded-2xl bg-white/5 border border-white/10 text-center space-y-1 backdrop-blur-xs">
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30">
                                    <i class="fa-solid fa-award text-[8px]"></i>
                                    <span>{{ $profile['badge_bawah_foto'] ?? 'PWI KABUPATEN BANYUASIN' }}</span>
                                </div>
                                <h3 class="text-sm sm:text-base font-black text-white tracking-wide">
                                    {{ $profile['judul_bawah_foto'] ?? 'Ketua PWI Banyuasin' }}
                                </h3>
                                <p class="text-[10px] text-slate-300 font-medium">
                                    {{ $profile['subjudul_bawah_foto'] ?? 'Masa Bakti 2025 – 2028' }}
                                </p>
                                
                                <!-- Social & Email Icons -->
                                <div class="pt-1 flex items-center justify-center gap-2">
                                    @if(!empty($profile['kontak']['instagram']))
                                    <a href="{{ $profile['kontak']['instagram'] }}" target="_blank" rel="noopener noreferrer" 
                                       class="w-7 h-7 rounded-lg bg-gradient-to-tr from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-90 hover:scale-105 active:scale-95 text-white flex items-center justify-center text-xs shadow-sm transition-all shrink-0" 
                                       title="Instagram @wardianstp" aria-label="Instagram">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    @endif

                                    @if(!empty($profile['kontak']['facebook']))
                                    <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" 
                                       class="w-7 h-7 rounded-lg bg-[#1877F2] hover:bg-[#166fe5] hover:scale-105 active:scale-95 text-white flex items-center justify-center text-xs shadow-sm transition-all shrink-0" 
                                       title="Facebook Wardoyo" aria-label="Facebook">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    @endif

                                    @if(!empty($profile['kontak']['email']))
                                    <a href="mailto:{{ $profile['kontak']['email'] }}" 
                                       class="w-7 h-7 rounded-lg bg-amber-400 hover:bg-amber-300 hover:scale-105 active:scale-95 text-slate-950 flex items-center justify-center text-[10px] shadow-sm transition-all shrink-0" 
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
    <section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left: Narrative Story (7 cols) -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                        <i class="fa-solid fa-user-pen"></i>
                        <span>{{ $profile['narasi_subjudul'] ?? 'Tentang Kepemimpinan & Pengabdian' }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
                        {{ $profile['narasi_judul'] ?? 'Komitmen Teruji Mengawal Integritas Pers & Pembangunan Banyuasin' }}
                    </h2>

                    <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed space-y-3.5">
                        @if(!empty($profile['narasi_paragraf_1']))
                            <p>{!! nl2br(e($profile['narasi_paragraf_1'])) !!}</p>
                        @endif
                        @if(!empty($profile['narasi_paragraf_2']))
                            <p>{!! nl2br(e($profile['narasi_paragraf_2'])) !!}</p>
                        @endif
                        @if(!empty($profile['narasi_paragraf_3']))
                            <p>{!! nl2br(e($profile['narasi_paragraf_3'])) !!}</p>
                        @endif
                    </div>

                    <!-- Fast Contact Pills (Rata Tengah di Mobile, Rata Kiri di Desktop, Rapi & Tidak Bertumpuk) -->
                    <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-2.5 sm:gap-3 text-xs font-semibold text-slate-600 dark:text-slate-300">
                        @if(!empty($profile['kontak']['email']))
                        <a href="mailto:{{ $profile['kontak']['email'] }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors shadow-2xs">
                            <i class="fa-solid fa-envelope text-amber-500"></i>
                            <span>{{ $profile['kontak']['email'] }}</span>
                        </a>
                        @endif

                        @if(!empty($profile['kontak']['instagram']))
                        <a href="{{ $profile['kontak']['instagram'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:text-pink-600 dark:hover:text-pink-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors shadow-2xs">
                            <i class="fa-brands fa-instagram text-pink-500 text-sm"></i>
                            <span>Instagram</span>
                        </a>
                        @endif
                        @if(!empty($profile['kontak']['facebook']))
                        <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors shadow-2xs">
                            <i class="fa-brands fa-facebook-f text-blue-600 text-xs"></i>
                            <span>Facebook</span>
                        </a>
                        @endif
                        @if(!empty($profile['lokasi_singkat']))
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 shadow-2xs">
                            <i class="fa-solid fa-location-dot text-rose-500"></i>
                            <span>{{ $profile['lokasi_singkat'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Strategic Value Pillars (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    @php
                        $pilarColors = [
                            ['bg' => 'bg-blue-600', 'text' => 'text-white'],
                            ['bg' => 'bg-amber-500', 'text' => 'text-slate-950'],
                            ['bg' => 'bg-emerald-600', 'text' => 'text-white'],
                            ['bg' => 'bg-indigo-600', 'text' => 'text-white'],
                        ];
                    @endphp
                    @foreach($profile['pilar_nilai'] as $idx => $pilar)
                        @php $color = $pilarColors[$idx % count($pilarColors)]; @endphp
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl {{ $color['bg'] }} {{ $color['text'] }} flex items-center justify-center font-bold shrink-0 shadow-md">
                                <i class="{{ $pilar['icon'] ?? 'fa-solid fa-award' }}"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $pilar['title'] }}</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    {{ $pilar['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($profile['organisasi'] as $org)
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-4 group hover:-translate-y-1">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800/80">
                                    {{ $org['masa'] }}
                                </span>
                                <div class="w-8 h-8 rounded-xl bg-amber-400/10 text-amber-500 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white leading-snug">
                                {{ $org['posisi'] }}
                            </h3>
                            @if(!empty($org['ket']))
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    {{ $org['ket'] }}
                                </p>
                            @endif
                        </div>
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-bold text-blue-600 dark:text-amber-400 flex items-center gap-1.5">
                            <i class="fa-solid fa-check text-[10px]"></i>
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
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ ($edu['is_completed'] ?? true) ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300' : 'bg-amber-100 text-amber-900 dark:bg-amber-950/70 dark:text-amber-300 border border-amber-300/60 dark:border-amber-700/60' }}">
                                            {{ $edu['tingkat'] }}
                                        </span>
                                        @if(isset($edu['is_completed']) && ! $edu['is_completed'])
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-50 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/80">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                <span>{{ $edu['status'] ?? 'Sedang Ditempuh' }}</span>
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white mt-1.5">{{ $edu['instansi'] }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $edu['prodi'] }}</p>
                                </div>
                                
                                @if(isset($edu['is_completed']) && ! $edu['is_completed'])
                                    <div class="w-8 h-8 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800/80 flex items-center justify-center text-xs shrink-0" title="Studi Berjalan (Sedang Ditempuh)">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs shrink-0" title="Lulus">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                @endif
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
                        Dokumentasi karya tulisan, esai teori komunikasi politik, analisis berita, dan liputan jurnalistik resmi yang telah disanitasi dan diarsipkan ke dalam format modern.
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button @click="shareUrl()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2 shadow-xs cursor-pointer">
                        <i class="fa-solid" :class="copied ? 'fa-check text-emerald-500' : 'fa-share-nodes text-amber-500'"></i>
                        <span x-text="copied ? 'Tautan Tersalin!' : 'Bagikan Katalog'"></span>
                    </button>
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
                            <a href="{{ $profile['kontak']['instagram'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-gradient-to-tr from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-90 text-white font-bold flex items-center justify-center gap-2 shadow-lg transition-all w-full sm:w-auto">
                                <i class="fa-brands fa-instagram text-sm"></i>
                                <span>Instagram</span>
                            </a>
                            @endif
                            @if(!empty($profile['kontak']['facebook']))
                            <a href="{{ $profile['kontak']['facebook'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-[#1877F2] hover:bg-[#166fe5] text-white font-bold flex items-center justify-center gap-2 shadow-lg transition-all w-full sm:w-auto">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                                <span>Facebook</span>
                            </a>
                            @endif
                            @if(!empty($profile['kontak']['email']))
                            <a href="mailto:{{ $profile['kontak']['email'] }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold border border-white/20 flex items-center justify-center gap-2 transition-all w-full sm:w-auto">
                                <i class="fa-solid fa-envelope text-amber-400"></i>
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
