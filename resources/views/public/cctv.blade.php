@extends('layouts.public')

@section('title', 'Pantauan CCTV Banyuasin Real-Time - Layanan Publik')
@section('meta_description', 'Pantau kondisi arus lalu lintas dan titik strategis di Kabupaten Banyuasin secara langsung (live streaming) 24 jam terintegrasi melalui portal CCTV Diskominfo Banyuasin.')

@section('content')
<!-- Header Banner Section -->
<div class="gradient-mesh text-white py-12 sm:py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
            
            <div class="max-w-3xl flex flex-col items-center lg:items-start">
                <!-- Live Indicator Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-rose-500/20 border border-rose-500/40 text-rose-300 text-xs font-bold tracking-wide shadow-sm">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                    </span>
                    <span>LIVE STREAMING 24 JAM</span>
                    <span class="text-white/40">•</span>
                    <span class="text-amber-400 font-semibold">DISKOMINFO BANYUASIN</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight leading-tight">
                    Pantauan CCTV Lalu Lintas <br class="hidden sm:inline">Kabupaten Banyuasin
                </h1>

                <p class="text-slate-300 text-xs sm:text-base mt-3 leading-relaxed max-w-2xl">
                    Sistem pemantauan arus lalu lintas terpadu di sepanjang Jalur Lintas Timur (Jalintim) Palembang–Betung dan titik strategis lainnya secara langsung (*real-time*) menyatu di portal PWI Banyuasin.
                </p>

                <!-- Primary CTA Launch Buttons -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mt-6">
                    <a href="#cctv-viewer" class="px-6 py-3.5 rounded-xl font-black text-xs sm:text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/30 transition-all flex items-center gap-2.5 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-tower-broadcast text-slate-950"></i>
                        <span>Tonton CCTV di Halaman Ini</span>
                        <i class="fa-solid fa-arrow-down text-xs"></i>
                    </a>
                    <a href="#titik-pantau" class="px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-amber-400"></i>
                        <span>Lihat 8 Titik Kamera</span>
                    </a>
                </div>
            </div>

            <!-- Header Quick Info Stats -->
            <div class="w-full lg:w-auto flex-shrink-0 grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-amber-400">8+</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Lokasi Pantau</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-400">24/7</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Aktif Non-Stop</div>
                </div>
                <div class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-sky-400">HD</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Kualitas Visual</div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="py-10 bg-slate-50 dark:bg-slate-950 transition-colors duration-200" 
     x-data="{
         viewMode: 'embed', // 'embed' or 'monitor'
         isTheater: false,
         selectedLocation: 'km12',
         locations: {
             'km12': {
                 name: 'Gerbang KM 12 (Batas Kota)',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD',
                 jalur: 'Jalintim Palembang - Betung KM 12',
                 arah: 'Arah Palembang & Arah Betung',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Pintu gerbang utama perbatasan Palembang – Banyuasin. Memantau kepadatan kendaraan keluar masuk wilayah metropolitan.'
             },
             'km15': {
                 name: 'Simpang Y KM 15 (Sukajadi)',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD',
                 jalur: 'Jalintim Simpang Y KM 15',
                 arah: 'Arah Sukajadi & Arah Pangkalan Balai',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Titik rawan antrean kendaraan di simpang Y Tanah Mas / Sukajadi menuju arah pusat pemerintahan.'
             },
             'airbatu': {
                 name: 'Simpang Air Batu',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD',
                 jalur: 'Jalintim Simpang Air Batu',
                 arah: 'Arah Lintas Timur & Arah Pelabuhan TAA',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Simpang vital perlintasan angkutan logistik industri dan jalur penghubung menuju Pelabuhan Penyeberangan Tanjung Api-Api.'
             },
             'sembawa': {
                 name: 'Kawasan Sembawa',
                 kecamatan: 'Kecamatan Sembawa',
                 kamera: '1 Unit Kamera HD',
                 jalur: 'Jalintim Sembawa KM 29',
                 arah: 'Dua Arah (Palembang - Betung)',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Area pusat balai penelitian pertanian dan kawasan pemukiman padat jalur lintas timur Sumatera.'
             },
             'pangkalanbalai': {
                 name: 'Pasar Pangkalan Balai',
                 kecamatan: 'Kecamatan Banyuasin III',
                 kamera: '2 Unit Kamera HD',
                 jalur: 'Pusat Kota Pangkalan Balai',
                 arah: 'Kawasan Pasar & Kompleks Perkantoran Pemkab',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Pusat denyut ekonomi ibukota Kabupaten Banyuasin, menghubungkan kawasan pasar tradisional dengan kantor pemerintahan.'
             },
             'betung': {
                 name: 'Simpang Tugu Betung',
                 kecamatan: 'Kecamatan Betung',
                 kamera: '2 Unit Kamera HD',
                 jalur: 'Simpang Lintas Sumatera',
                 arah: 'Arah Jambi (Jalintim) & Arah Sekayu/Muba',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Percabangan segitiga emas lalu lintas Pulau Sumatera: jalur menuju Provinsi Jambi dan jalur tengah ke Musi Banyuasin.'
             },
             'gasing': {
                 name: 'Desa Gasing',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '1 Unit Kamera HD',
                 jalur: 'Kawasan Industri Gasing',
                 arah: 'Area Pergudangan & Dermaga Logistik',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Pusat kawasan industri manufaktur, pergudangan, dan dermaga sungai perairan Banyuasin.'
             },
             'sungaipinang': {
                 name: 'Simpang Tiga Sungai Pinang',
                 kecamatan: 'Kecamatan Rambutan',
                 kamera: '1 Unit Kamera HD',
                 jalur: 'Jalur Rambutan - OPI Jakabaring',
                 arah: 'Arah Rambutan & Arah Palembang Selatan',
                 status: 'Live Aktif 24 Jam',
                 deskripsi: 'Akses perlintasan strategis komuter wilayah barat Banyuasin yang berbatasan dengan kawasan Jakabaring.'
             }
         },
         reloadIframe() {
             const frame = document.getElementById('cctv-live-iframe');
             if (frame) {
                 frame.src = frame.src;
             }
         }
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- In-Page Embedded CCTV Viewer (Unified with PWI Website) -->
        <section id="cctv-viewer" class="scroll-mt-24">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden">
                
                <!-- Terminal Control Bar -->
                <div class="p-4 sm:p-5 bg-slate-950 text-white flex flex-wrap items-center justify-between gap-4 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold text-base border border-rose-500/30 shrink-0">
                            <i class="fa-solid fa-satellite-dish animate-pulse"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-sm sm:text-base font-extrabold text-white">Layar Streaming CCTV Banyuasin</h2>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    LIVE STREAM
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400">Siaran langsung lalu lintas terpadu dari Diskominfo Kabupaten Banyuasin</p>
                        </div>
                    </div>

                    <!-- Mode Switch & Controls -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="inline-flex p-1 rounded-xl bg-slate-900 border border-slate-800 text-xs">
                            <button type="button" 
                                    @click="viewMode = 'embed'" 
                                    :class="viewMode === 'embed' ? 'bg-blue-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white'"
                                    class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-tv text-xs"></i>
                                <span>Layar CCTV Langsung</span>
                            </button>
                            <button type="button" 
                                    @click="viewMode = 'monitor'" 
                                    :class="viewMode === 'monitor' ? 'bg-blue-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white'"
                                    class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-list-check text-xs"></i>
                                <span>Navigasi Titik & Data</span>
                            </button>
                        </div>

                        <!-- Action Controls -->
                        <button type="button" 
                                @click="reloadIframe()" 
                                title="Muat Ulang Tampilan CCTV" 
                                class="p-2 w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white transition-all flex items-center justify-center border border-white/10">
                            <i class="fa-solid fa-arrow-rotate-right text-xs"></i>
                        </button>
                        <button type="button" 
                                @click="isTheater = !isTheater" 
                                title="Mode Layar Lebar Terintegrasi" 
                                class="p-2 w-9 h-9 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold transition-all flex items-center justify-center shadow-sm">
                            <i class="fa-solid" :class="isTheater ? 'fa-compress' : 'fa-expand'"></i>
                        </button>
                    </div>
                </div>

                <!-- Camera Quick Selection Pills -->
                <div class="p-3 bg-slate-100 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 flex items-center gap-2 overflow-x-auto custom-scrollbar">
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 shrink-0 px-2 uppercase tracking-wider">Titik Kamera:</span>
                    <template x-for="(loc, key) in locations" :key="key">
                        <button type="button" 
                                @click="selectedLocation = key; viewMode = 'monitor'" 
                                :class="selectedLocation === key ? 'bg-blue-600 text-white shadow-md font-bold' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800'"
                                class="px-3 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all flex items-center gap-1.5 cursor-pointer shrink-0">
                            <i class="fa-solid fa-video text-[10px]" :class="selectedLocation === key ? 'text-amber-400' : 'text-slate-400'"></i>
                            <span x-text="loc.name"></span>
                        </button>
                    </template>
                </div>

                <!-- Main Viewport Display Area -->
                <div class="relative bg-slate-950 transition-all duration-300" :class="isTheater ? 'h-[700px] sm:h-[800px]' : 'h-[500px] sm:h-[620px]'">
                    
                    <!-- MODE 1: Embedded Direct CCTV Frame -->
                    <div x-show="viewMode === 'embed'" class="w-full h-full relative flex flex-col">
                        <!-- Top HUD Bar -->
                        <div class="px-4 py-2 bg-slate-900/90 backdrop-blur-md border-b border-white/10 flex items-center justify-between text-xs text-slate-300 font-mono z-20">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                <span class="text-white font-bold text-[11px]">PORTAL RESMI: cctv.banyuasinkab.go.id</span>
                            </div>
                            <div class="text-[11px] text-amber-400">
                                {{ date('d/m/Y') }} • <span id="clock-display">00:00:00</span> WIB
                            </div>
                        </div>

                        <!-- The Live Iframe Container -->
                        <div class="relative flex-1 w-full h-full overflow-hidden bg-slate-950">
                            <iframe id="cctv-live-iframe" 
                                    src="https://cctv.banyuasinkab.go.id" 
                                    class="w-full h-full border-0 absolute inset-0 z-10" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen
                                    title="Streaming Langsung CCTV Banyuasin">
                            </iframe>

                            <!-- In-Page Assist Overlay (Visible underneath / if browser restricts iframe display) -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center z-0 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
                                <div class="w-16 h-16 rounded-2xl bg-amber-400/10 border border-amber-400/30 flex items-center justify-center text-amber-400 text-3xl mb-4 animate-bounce">
                                    <i class="fa-solid fa-video"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl font-black text-white">Menghubungkan ke Server CCTV Banyuasin...</h3>
                                <p class="text-xs sm:text-sm text-slate-400 mt-2 max-w-lg leading-relaxed">
                                    Siaran langsung sedang dimuat dari server resmi Diskominfo Banyuasin di dalam halaman ini.
                                </p>
                                <div class="mt-5 flex items-center gap-3">
                                    <button type="button" @click="reloadIframe()" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition-all">
                                        <i class="fa-solid fa-arrow-rotate-right me-1.5"></i> Segarkan Layar
                                    </button>
                                    <button type="button" @click="viewMode = 'monitor'" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition-all shadow-md">
                                        <i class="fa-solid fa-list-check me-1.5"></i> Lihat Navigasi Titik
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Notice inside Frame -->
                        <div class="px-4 py-2.5 bg-slate-900/90 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400 z-20">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-amber-400"></i>
                                <span>Tampilan menyatu di website PWI Banyuasin tanpa membuka tab baru.</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" @click="isTheater = !isTheater" class="text-amber-400 hover:underline font-semibold">
                                    <i class="fa-solid fa-expand me-1"></i> Mode Teater
                                </button>
                                <a href="https://cctv.banyuasinkab.go.id" class="text-sky-400 hover:underline font-semibold">
                                    <i class="fa-solid fa-up-right-from-square me-1"></i> Buka Penuh
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- MODE 2: Interactive Monitor HUD & Location Intelligence -->
                    <div x-show="viewMode === 'monitor'" class="w-full h-full p-6 sm:p-8 flex flex-col justify-between overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-400 border-b border-white/10 pb-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-rose-600 text-white font-black text-[10px] tracking-wider animate-pulse flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    LIVE MONITORING
                                </span>
                                <span class="text-emerald-400 font-bold" x-text="locations[selectedLocation].status"></span>
                            </div>
                            <button type="button" @click="viewMode = 'embed'" class="text-amber-400 hover:underline text-xs font-sans font-bold flex items-center gap-1">
                                <i class="fa-solid fa-tv"></i>
                                <span>Kembali ke Layar Video</span>
                            </button>
                        </div>

                        <div class="my-6 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                            <!-- Left: Camera Graphic Simulation -->
                            <div class="lg:col-span-6 text-center space-y-4">
                                <div class="w-24 h-24 rounded-3xl bg-white/5 border border-white/10 mx-auto flex items-center justify-center text-amber-400 text-4xl shadow-inner">
                                    <i class="fa-solid fa-video animate-pulse"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-black text-white" x-text="locations[selectedLocation].name"></h3>
                                    <p class="text-xs text-slate-400 mt-1" x-text="locations[selectedLocation].jalur"></p>
                                </div>
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-mono">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                    <span>Signal Quality: 1080p HD Full Bandwidth</span>
                                </div>
                            </div>

                            <!-- Right: Detailed Specs -->
                            <div class="lg:col-span-6 space-y-3 text-xs">
                                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-2.5">
                                    <div class="flex items-center justify-between py-1 border-b border-white/5">
                                        <span class="text-slate-400">Wilayah:</span>
                                        <span class="font-bold text-white" x-text="locations[selectedLocation].kecamatan"></span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 border-b border-white/5">
                                        <span class="text-slate-400">Perangkat:</span>
                                        <span class="font-bold text-amber-400" x-text="locations[selectedLocation].kamera"></span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 border-b border-white/5">
                                        <span class="text-slate-400">Arah Pantauan:</span>
                                        <span class="font-bold text-white" x-text="locations[selectedLocation].arah"></span>
                                    </div>
                                    <div class="flex items-center justify-between py-1">
                                        <span class="text-slate-400">Deskripsi:</span>
                                        <span class="font-medium text-slate-300 text-right max-w-xs" x-text="locations[selectedLocation].deskripsi"></span>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="button" @click="viewMode = 'embed'" class="w-full py-3 rounded-xl font-extrabold text-xs text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all flex items-center justify-center gap-2 shadow-lg shadow-amber-400/20">
                                        <i class="fa-solid fa-play"></i>
                                        <span>Lihat Layar CCTV Langsung</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-slate-500 border-t border-white/10 pt-3 font-mono">
                            <span>Sistem Pengawasan Terpadu PWI & Diskominfo Banyuasin</span>
                            <span>Protokol: RTSP / HLS 24 Jam</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Technical Integration & API Notice Section -->
        <section class="bg-gradient-to-r from-blue-900 to-[#0B132B] text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-blue-800/80 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row items-start justify-between gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold text-xl shrink-0 shadow-md">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-500/20 text-sky-300 border border-blue-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                            STATUS INTEGRASI API & STREAM CCTV
                        </div>
                        <h3 class="text-lg sm:text-xl font-black text-white">Informasi API & Integrasi Layanan CCTV Banyuasin</h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-3xl">
                            Pemerintah Kabupaten Banyuasin melalui <strong>Diskominfo Banyuasin</strong> mengelola siaran CCTV secara terpusat melalui situs resmi <span class="text-amber-400 font-bold">cctv.banyuasinkab.go.id</span>. Akses streaming dikunci secara internal dengan perlindungan keamanan <em>Cloudflare Guard</em> dan <em>SAMEORIGIN</em>, serta belum membuka Public API terbuka untuk umum guna menjaga keamanan infrastruktur dan hak cipta rekaman lalu lintas.
                        </p>
                        <p class="text-xs text-slate-400 leading-relaxed max-w-3xl">
                            Website PWI Banyuasin telah dirancang <strong>100% siap integrasi (*API & Native Video Ready*)</strong>: Apabila di masa mendatang Diskominfo Banyuasin memberikan akses khusus berupa feed RTSP, HLS (.m3u8), atau API token bagi PWI, pemutar video di halaman ini langsung siap menyiarkan video secara native.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Strategis Locations Directory Cards Section -->
        <section id="titik-pantau" class="scroll-mt-24 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-400/10 px-3.5 py-1 rounded-full border border-amber-200 dark:border-amber-400/30">
                        Titik Pengawasan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Daftar 8 Titik CCTV Strategis Banyuasin
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm mt-1">
                        Pilih salah satu lokasi untuk langsung memfokuskan pemantauan di konsol atas
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total 8 Titik Aktif</span>
                </div>
            </div>

            <!-- Locations Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Titik 1: KM 12 -->
                <div @click="selectedLocation = 'km12'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                2 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Gerbang KM 12
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Pintu gerbang perbatasan Palembang – Banyuasin. Memantau arus keluar masuk kendaraan kedua arah.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Jalintim KM 12</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 2: KM 15 -->
                <div @click="selectedLocation = 'km15'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                2 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang Y KM 15
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang pertemuan arus Sukajadi dan Tanah Mas, titik vital pengawasan antrean kendaraan Jalintim.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Simpang Sukajadi</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 3: Simpang Air Batu -->
                <div @click="selectedLocation = 'airbatu'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                2 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang Air Batu
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang perlintasan angkutan logistik industri dan jalur alternatif Tanjung Api-Api.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Simpang Air Batu</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 4: Sembawa -->
                <div @click="selectedLocation = 'sembawa'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                1 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Kawasan Sembawa
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Sembawa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Kawasan pusat penelitian dan pemukiman dengan kepadatan lalu lintas antarkota.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Jalintim KM 29</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 5: Pasar Pangkalan Balai -->
                <div @click="selectedLocation = 'pangkalanbalai'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                2 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Pasar Pangkalan Balai
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Banyuasin III
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Jantung pusat pemerintahan dan perekonomian ibukota Kabupaten Banyuasin.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Pusat Kota Pangkalan Balai</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 6: Tugu Betung -->
                <div @click="selectedLocation = 'betung'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                2 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang Tugu Betung
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Betung
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang segitiga perlintasan utama Sumatera menuju Jambi (Jalintim) dan Sekayu/Muba.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Simpang Lintas Betung</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 7: Desa Gasing -->
                <div @click="selectedLocation = 'gasing'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                1 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Desa Gasing
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Pusat pergudangan dan aktivitas industri manufaktur di sepanjang perairan sungai Banyuasin.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-industry me-1 text-amber-500"></i> Kawasan Industri</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 8: Sungai Pinang -->
                <div @click="selectedLocation = 'sungaipinang'; viewMode = 'monitor'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                1 UNIT CCTV
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang 3 Sungai Pinang
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Rambutan
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang tiga perlintasan menuju wilayah Rambutan dan perbatasan Jakabaring Palembang Selatan.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-signs-post me-1 text-amber-500"></i> Rambutan Area</span>
                        <span class="text-blue-600 dark:text-amber-400 font-bold flex items-center gap-1">
                            Pilih <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    </div>
                </div>

            </div>
        </section>

        <!-- Terms, Guidelines & Emergency Call Centers -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-4">
            
            <!-- Guideline 1: Ketentuan Siaran -->
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Ketentuan Rekaman CCTV</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Layanan CCTV ini disediakan secara terbuka khusus untuk <strong>pemantauan langsung (*live stream*)</strong>. Rekaman arsip (*playback*) tidak dapat diunduh langsung dan hanya dapat diajukan secara resmi melalui Dinas Komunikasi, Informatika, Statistik dan Persandian (Diskominfo) Kab. Banyuasin untuk keperluan penegakan hukum atau investigasi resmi kepolisian.
                </p>
            </div>

            <!-- Guideline 2: Tips Pemudik & Pengendara -->
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-car-on"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Tips Pemudik Jalintim</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Sebelum melintasi Jalan Lintas Timur Palembang–Betung, periksa kondisi titik rawan antrean seperti KM 14–16 Sukajadi dan Simpang Tugu Betung. Patuhi rambu lalu lintas, hindari menyalip pada marka jalan tidak putus, dan istirahatlah di *rest area* atau SPBU terdekat jika lelah berkendara.
                </p>
            </div>

            <!-- Guideline 3: Kontak Darurat Banyuasin -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-[#0B132B] to-[#1C2541] text-white border border-slate-800 shadow-md space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-lg border border-amber-500/30">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white">Kontak Darurat Banyuasin</h3>
                        <p class="text-[11px] text-amber-400 font-medium">Bantuan Siaga 24 Jam</p>
                    </div>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-white/10">
                        <span class="text-slate-300"><i class="fa-solid fa-headset me-2 text-rose-400"></i> Call Center Darurat</span>
                        <span class="font-black text-amber-400 text-sm">112</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-white/10">
                        <span class="text-slate-300"><i class="fa-solid fa-shield me-2 text-sky-400"></i> Polres Banyuasin</span>
                        <span class="font-bold text-white">0813-7000-2110</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-white/10">
                        <span class="text-slate-300"><i class="fa-solid fa-truck-medical me-2 text-emerald-400"></i> BPBD Banyuasin</span>
                        <span class="font-bold text-white">0811-789-112</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-300"><i class="fa-solid fa-traffic-light me-2 text-amber-400"></i> Dishub Banyuasin</span>
                        <span class="font-bold text-white">0711-7690022</span>
                    </div>
                </div>
            </div>

        </section>

    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const display = document.getElementById('clock-display');
        if (display) {
            display.textContent = hours + ':' + minutes + ':' + seconds;
        }
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
