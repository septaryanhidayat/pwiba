@extends('layouts.public')

@section('title', 'Pantauan CCTV Banyuasin Real-Time - Layanan Publik')
@section('meta_description', 'Pantau kondisi arus lalu lintas dan titik strategis di Kabupaten Banyuasin secara langsung (live streaming) 24 jam melalui portal CCTV resmi Diskominfo Banyuasin.')

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
                    <span>LIVE MONITORING 24 JAM</span>
                    <span class="text-white/40">•</span>
                    <span class="text-amber-400 font-semibold">DISKOMINFO BANYUASIN</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight leading-tight">
                    Pantauan CCTV Lalu Lintas <br class="hidden sm:inline">Kabupaten Banyuasin
                </h1>

                <p class="text-slate-300 text-xs sm:text-base mt-3 leading-relaxed max-w-2xl">
                    Sistem informasi dan navigasi pantauan arus lalu lintas di sepanjang Jalur Lintas Timur (Jalintim) Palembang–Betung dan titik strategis lainnya secara langsung (*real-time*).
                </p>

                <!-- Primary CTA Launch Buttons -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mt-6">
                    <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 rounded-xl font-black text-xs sm:text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/30 transition-all flex items-center gap-2.5 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-tower-broadcast text-slate-950"></i>
                        <span>Buka Siaran Langsung CCTV</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
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
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Titik Pantau</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-400">24/7</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Online Non-Stop</div>
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
         selectedLocation: 'km12',
         locations: {
             'km12': {
                 code: 'CAM-01',
                 name: 'Gerbang KM 12 (Batas Kota)',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD PTZ',
                 jalur: 'Jalintim Palembang - Betung KM 12',
                 arah: 'Arah Palembang & Arah Betung',
                 status: 'Lalu Lintas Normal Lancar',
                 deskripsi: 'Pintu gerbang utama perbatasan Palembang – Banyuasin. Memantau volume kendaraan komuter dan angkutan logistik keluar masuk wilayah ibu kota provinsi.'
             },
             'km15': {
                 code: 'CAM-02',
                 name: 'Simpang Y KM 15 (Sukajadi)',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD PTZ',
                 jalur: 'Jalintim Simpang Y KM 15',
                 arah: 'Arah Sukajadi & Arah Pangkalan Balai',
                 status: 'Lalu Lintas Terpantau Tertib',
                 deskripsi: 'Titik rawan antrean kendaraan di simpang Y Tanah Mas / Sukajadi menuju arah pusat pemerintahan Banyuasin.'
             },
             'airbatu': {
                 code: 'CAM-03',
                 name: 'Simpang Air Batu',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD PTZ',
                 jalur: 'Jalintim Simpang Air Batu',
                 arah: 'Arah Lintas Timur & Arah Pelabuhan TAA',
                 status: 'Lalu Lintas Lancar Terkendali',
                 deskripsi: 'Simpang vital perlintasan angkutan logistik industri dan jalur penghubung menuju Pelabuhan Penyeberangan Tanjung Api-Api.'
             },
             'sembawa': {
                 code: 'CAM-04',
                 name: 'Kawasan Sembawa',
                 kecamatan: 'Kecamatan Sembawa',
                 kamera: '1 Unit Kamera HD Wide',
                 jalur: 'Jalintim Sembawa KM 29',
                 arah: 'Dua Arah (Palembang - Betung)',
                 status: 'Lalu Lintas Normal Lancar',
                 deskripsi: 'Area pusat balai penelitian pertanian dan kawasan pemukiman padat jalur lintas timur Sumatera.'
             },
             'pangkalanbalai': {
                 code: 'CAM-05',
                 name: 'Pasar Pangkalan Balai',
                 kecamatan: 'Kecamatan Banyuasin III',
                 kamera: '2 Unit Kamera HD PTZ',
                 jalur: 'Pusat Kota Pangkalan Balai',
                 arah: 'Kawasan Pasar & Kompleks Perkantoran Pemkab',
                 status: 'Aktivitas Perkotaan Ramai Lancar',
                 deskripsi: 'Pusat denyut ekonomi ibukota Kabupaten Banyuasin, menghubungkan kawasan pasar tradisional dengan kantor pemerintahan.'
             },
             'betung': {
                 code: 'CAM-06',
                 name: 'Simpang Tugu Betung',
                 kecamatan: 'Kecamatan Betung',
                 kamera: '2 Unit Kamera HD PTZ',
                 jalur: 'Simpang Lintas Sumatera',
                 arah: 'Arah Jambi (Jalintim) & Arah Sekayu/Muba',
                 status: 'Lalu Lintas Lancar Dua Arah',
                 deskripsi: 'Percabangan segitiga emas lalu lintas Pulau Sumatera: jalur menuju Provinsi Jambi dan jalur tengah ke Musi Banyuasin.'
             },
             'gasing': {
                 code: 'CAM-07',
                 name: 'Desa Gasing',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '1 Unit Kamera HD Wide',
                 jalur: 'Kawasan Industri Gasing',
                 arah: 'Area Pergudangan & Dermaga Logistik',
                 status: 'Lalu Lintas Angkutan Teratur',
                 deskripsi: 'Pusat kawasan industri manufaktur, pergudangan, dan dermaga sungai perairan Banyuasin.'
             },
             'sungaipinang': {
                 code: 'CAM-08',
                 name: 'Simpang Tiga Sungai Pinang',
                 kecamatan: 'Kecamatan Rambutan',
                 kamera: '1 Unit Kamera HD Wide',
                 jalur: 'Jalur Rambutan - OPI Jakabaring',
                 arah: 'Arah Rambutan & Arah Palembang Selatan',
                 status: 'Lalu Lintas Normal Lancar',
                 deskripsi: 'Akses perlintasan strategis komuter wilayah timur Banyuasin yang berbatasan dengan kawasan Jakabaring.'
             }
         }
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Command Center Surveillance Monitor Section (No Broken Iframes) -->
        <section id="cctv-viewer" class="scroll-mt-24">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden">
                
                <!-- Terminal Bar -->
                <div class="p-4 sm:p-5 bg-slate-950 text-white flex flex-wrap items-center justify-between gap-4 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold text-base border border-rose-500/30 shrink-0">
                            <i class="fa-solid fa-satellite-dish animate-pulse"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-sm sm:text-base font-extrabold text-white">Konsol Monitoring CCTV Banyuasin</h2>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    SERVER ONLINE
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400">Pilih titik kamera untuk melihat status rute dan mengakses siaran resmi</p>
                        </div>
                    </div>

                    <!-- Live Clock & Server Direct Link -->
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block font-mono text-xs text-slate-300">
                            <div class="text-[10px] text-slate-400">WAKTU AKTIF SISTEM</div>
                            <span class="text-amber-400 font-bold" id="clock-display">00:00:00</span> WIB
                        </div>
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all flex items-center gap-2 shadow-sm shrink-0">
                            <i class="fa-solid fa-play"></i>
                            <span>Buka Siaran Langsung</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Camera Quick Selection Tabs -->
                <div class="p-3 bg-slate-100 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 flex items-center gap-2 overflow-x-auto custom-scrollbar">
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 shrink-0 px-2 uppercase tracking-wider">Pilih Kamera:</span>
                    <template x-for="(loc, key) in locations" :key="key">
                        <button type="button" 
                                @click="selectedLocation = key" 
                                :class="selectedLocation === key ? 'bg-blue-600 text-white shadow-md font-bold' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800'"
                                class="px-3 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all flex items-center gap-1.5 cursor-pointer shrink-0">
                            <i class="fa-solid fa-video text-[10px]" :class="selectedLocation === key ? 'text-amber-400' : 'text-slate-400'"></i>
                            <span x-text="loc.code + ': ' + loc.name"></span>
                        </button>
                    </template>
                </div>

                <!-- Active Surveillance Viewport Display -->
                <div class="p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-white dark:bg-slate-900">
                    
                    <!-- Simulated High-Tech Monitor HUD (7 Cols) -->
                    <div class="lg:col-span-7 bg-slate-950 rounded-2xl border border-slate-800 p-5 sm:p-7 shadow-2xl relative overflow-hidden flex flex-col justify-between min-h-[340px] sm:min-h-[400px]">
                        
                        <!-- Screen Top HUD -->
                        <div class="flex items-center justify-between text-xs relative z-10 border-b border-white/10 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-rose-600 text-white font-black text-[10px] tracking-wider animate-pulse flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    LIVE CCTV
                                </span>
                                <span class="text-amber-400 font-mono text-[11px] font-bold" x-text="locations[selectedLocation].code"></span>
                                <span class="text-white/30">•</span>
                                <span class="text-emerald-400 font-mono text-[11px]" x-text="locations[selectedLocation].status"></span>
                            </div>
                            <div class="text-slate-400 font-mono text-[11px] hidden sm:block">
                                1080P HD / 30FPS
                            </div>
                        </div>

                        <!-- Center Camera Graphic & Direct Launch -->
                        <div class="my-8 text-center space-y-4 relative z-10">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-white/5 border border-white/10 mx-auto flex items-center justify-center text-amber-400 text-3xl sm:text-4xl shadow-inner relative group">
                                <i class="fa-solid fa-video animate-pulse"></i>
                                <div class="absolute -top-1 -right-1 w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-slate-950 animate-ping"></div>
                            </div>

                            <div>
                                <h3 class="text-lg sm:text-2xl font-black text-white tracking-tight" x-text="locations[selectedLocation].name"></h3>
                                <p class="text-xs text-slate-400 max-w-md mx-auto mt-1" x-text="locations[selectedLocation].jalur"></p>
                            </div>
                            
                            <div class="pt-2">
                                <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-xl font-extrabold text-xs sm:text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-400/20 transition-all transform hover:scale-105">
                                    <i class="fa-solid fa-circle-play text-base"></i>
                                    <span>Tonton Siaran Langsung di Portal CCTV</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </a>
                            </div>

                            <p class="text-[11px] text-slate-400">
                                Transmisi video langsung resmi dari server Dinas Kominfo Kab. Banyuasin
                            </p>
                        </div>

                        <!-- Monitor Bottom Meta HUD -->
                        <div class="flex items-center justify-between text-[11px] text-slate-400 border-t border-white/10 pt-3 relative z-10 font-mono">
                            <span x-text="'Perangkat: ' + locations[selectedLocation].kamera"></span>
                            <span>Protokol: RTSP / HLS Secure</span>
                        </div>

                        <!-- Monitor Background Grid Texture -->
                        <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] opacity-40 pointer-events-none"></div>
                    </div>

                    <!-- Location Details Info (5 Cols) -->
                    <div class="lg:col-span-5 space-y-5">
                        <div>
                            <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800" x-text="locations[selectedLocation].kecamatan"></span>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2" x-text="locations[selectedLocation].name"></h3>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed" x-text="locations[selectedLocation].deskripsi"></p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-3 text-xs">
                            <div class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-slate-700/60">
                                <span class="text-slate-500 dark:text-slate-400">Unit Terpasang:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="locations[selectedLocation].kamera"></span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-slate-700/60">
                                <span class="text-slate-500 dark:text-slate-400">Arah Pantauan:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="locations[selectedLocation].arah"></span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-slate-700/60">
                                <span class="text-slate-500 dark:text-slate-400">Jalur Lintasan:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="locations[selectedLocation].jalur"></span>
                            </div>
                            <div class="flex items-center justify-between py-1">
                                <span class="text-slate-500 dark:text-slate-400">Pengelola Resmi:</span>
                                <span class="font-bold text-amber-600 dark:text-amber-400">Diskominfo Kab. Banyuasin</span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-4 rounded-xl font-bold text-xs text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-satellite-dish"></i>
                                <span>Koneksikan ke Server cctv.banyuasinkab.go.id</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
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
                        Pilih lokasi kamera untuk melihat kondisi titik pantau pada konsol di atas
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total 8 Titik Pantau Aktif</span>
                </div>
            </div>

            <!-- Locations Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Titik 1: KM 12 -->
                <div @click="selectedLocation = 'km12'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
                <div @click="selectedLocation = 'km15'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
                <div @click="selectedLocation = 'airbatu'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
                <div @click="selectedLocation = 'sembawa'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
                <div @click="selectedLocation = 'pangkalanbalai'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
                <div @click="selectedLocation = 'betung'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
                <div @click="selectedLocation = 'gasing'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
                <div @click="selectedLocation = 'sungaipinang'; window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
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
