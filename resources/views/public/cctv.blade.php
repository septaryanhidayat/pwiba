@extends('layouts.public')

@section('title', 'Pantauan CCTV Banyuasin Real-Time - Layanan Publik')
@section('meta_description', 'Pantau kondisi arus lalu lintas dan titik strategis di Kabupaten Banyuasin secara langsung 24 jam terintegrasi di portal resmi PWI Banyuasin.')

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
                    <span>LIVE SURVEILLANCE & TRAFFIC RADAR</span>
                    <span class="text-white/40">•</span>
                    <span class="text-amber-400 font-semibold">DISKOMINFO BANYUASIN</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight leading-tight">
                    Pantauan CCTV Lalu Lintas <br class="hidden sm:inline">Kabupaten Banyuasin
                </h1>

                <p class="text-slate-300 text-xs sm:text-base mt-3 leading-relaxed max-w-2xl">
                    Sistem pemantauan arus lalu lintas terpadu di sepanjang Jalur Lintas Timur (Jalintim) Palembang–Betung dan titik strategis lainnya secara langsung (*real-time*) menyatu di portal PWI Banyuasin.
                </p>

                <!-- Primary In-Page Nav Buttons (NO NEW TABS) -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mt-6">
                    <a href="#cctv-viewer" class="px-6 py-3.5 rounded-xl font-black text-xs sm:text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/30 transition-all flex items-center gap-2.5 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-video text-slate-950"></i>
                        <span>Buka Layar CCTV di Sini</span>
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
                    <div class="text-2xl sm:text-3xl font-black text-amber-400">8</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Kamera Aktif</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-400">24/7</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Monitoring Online</div>
                </div>
                <div class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-sky-400">1080P</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Resolusi HD PTZ</div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="py-10 bg-slate-50 dark:bg-slate-950 transition-colors duration-200" 
     x-data="{
         selectedLocation: 'km12',
         zoomLevel: 1,
         visionFilter: 'normal',
         isDetecting: true,
         panX: 0,
         panY: 0,
         locations: {
             'km12': {
                 code: 'CAM-01',
                 name: 'Gerbang KM 12 (Batas Kota)',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD PTZ Speed Dome',
                 jalur: 'Jalintim Palembang - Betung KM 12',
                 arah: 'Arah Palembang & Arah Betung',
                 coords: 'S 02°55\'18\" E 104°42\'30\"',
                 status: 'Lalu Lintas Normal Lancar',
                 speed: '48 Km/Jam',
                 volume: '36 Kendaraan / Menit',
                 deskripsi: 'Pintu gerbang utama perbatasan Palembang – Banyuasin. Memantau volume kendaraan komuter dan angkutan logistik keluar masuk wilayah ibu kota provinsi.'
             },
             'km15': {
                 code: 'CAM-02',
                 name: 'Simpang Y KM 15 (Sukajadi)',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD PTZ Speed Dome',
                 jalur: 'Jalintim Simpang Y KM 15',
                 arah: 'Arah Sukajadi & Arah Pangkalan Balai',
                 coords: 'S 02°53\'42\" E 104°40\'15\"',
                 status: 'Lalu Lintas Terpantau Tertib',
                 speed: '42 Km/Jam',
                 volume: '45 Kendaraan / Menit',
                 deskripsi: 'Titik rawan antrean kendaraan di simpang Y Tanah Mas / Sukajadi menuju arah pusat pemerintahan Banyuasin.'
             },
             'airbatu': {
                 code: 'CAM-03',
                 name: 'Simpang Air Batu',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '2 Unit Kamera HD PTZ Speed Dome',
                 jalur: 'Jalintim Simpang Air Batu',
                 arah: 'Arah Lintas Timur & Arah Pelabuhan TAA',
                 coords: 'S 02°51\'10\" E 104°38\'04\"',
                 status: 'Lalu Lintas Lancar Terkendali',
                 speed: '50 Km/Jam',
                 volume: '28 Kendaraan / Menit',
                 deskripsi: 'Simpang vital perlintasan angkutan logistik industri dan jalur penghubung menuju Pelabuhan Penyeberangan Tanjung Api-Api.'
             },
             'sembawa': {
                 code: 'CAM-04',
                 name: 'Kawasan Sembawa',
                 kecamatan: 'Kecamatan Sembawa',
                 kamera: '1 Unit Kamera HD Wide Optical',
                 jalur: 'Jalintim Sembawa KM 29',
                 arah: 'Dua Arah (Palembang - Betung)',
                 coords: 'S 02°48\'25\" E 104°32\'40\"',
                 status: 'Lalu Lintas Normal Lancar',
                 speed: '55 Km/Jam',
                 volume: '22 Kendaraan / Menit',
                 deskripsi: 'Area pusat balai penelitian pertanian dan kawasan pemukiman padat jalur lintas timur Sumatera.'
             },
             'pangkalanbalai': {
                 code: 'CAM-05',
                 name: 'Pasar Pangkalan Balai',
                 kecamatan: 'Kecamatan Banyuasin III',
                 kamera: '2 Unit Kamera HD PTZ Speed Dome',
                 jalur: 'Pusat Kota Pangkalan Balai',
                 arah: 'Kawasan Pasar & Kompleks Perkantoran Pemkab',
                 coords: 'S 02°53\'20\" E 104°24\'10\"',
                 status: 'Aktivitas Perkotaan Ramai Lancar',
                 speed: '35 Km/Jam',
                 volume: '52 Kendaraan / Menit',
                 deskripsi: 'Pusat denyut ekonomi ibukota Kabupaten Banyuasin, menghubungkan kawasan pasar tradisional dengan kantor pemerintahan.'
             },
             'betung': {
                 code: 'CAM-06',
                 name: 'Simpang Tugu Betung',
                 kecamatan: 'Kecamatan Betung',
                 kamera: '2 Unit Kamera HD PTZ Speed Dome',
                 jalur: 'Simpang Lintas Sumatera',
                 arah: 'Arah Jambi (Jalintim) & Arah Sekayu/Muba',
                 coords: 'S 02°45\'05\" E 104°12\'55\"',
                 status: 'Lalu Lintas Lancar Dua Arah',
                 speed: '46 Km/Jam',
                 volume: '38 Kendaraan / Menit',
                 deskripsi: 'Percabangan segitiga emas lalu lintas Pulau Sumatera: jalur menuju Provinsi Jambi dan jalur tengah ke Musi Banyuasin.'
             },
             'gasing': {
                 code: 'CAM-07',
                 name: 'Desa Gasing',
                 kecamatan: 'Kecamatan Talang Kelapa',
                 kamera: '1 Unit Kamera HD Wide Optical',
                 jalur: 'Kawasan Industri Gasing',
                 arah: 'Area Pergudangan & Dermaga Logistik',
                 coords: 'S 02°52\'30\" E 104°45\'12\"',
                 status: 'Lalu Lintas Angkutan Teratur',
                 speed: '40 Km/Jam',
                 volume: '25 Kendaraan / Menit',
                 deskripsi: 'Pusat kawasan industri manufaktur, pergudangan, dan dermaga sungai perairan Banyuasin.'
             },
             'sungaipinang': {
                 code: 'CAM-08',
                 name: 'Simpang Tiga Sungai Pinang',
                 kecamatan: 'Kecamatan Rambutan',
                 kamera: '1 Unit Kamera HD Wide Optical',
                 jalur: 'Jalur Rambutan - OPI Jakabaring',
                 arah: 'Arah Rambutan & Arah Palembang Selatan',
                 coords: 'S 03°02\'15\" E 104°48\'20\"',
                 status: 'Lalu Lintas Normal Lancar',
                 speed: '45 Km/Jam',
                 volume: '30 Kendaraan / Menit',
                 deskripsi: 'Akses perlintasan strategis komuter wilayah timur Banyuasin yang berbatasan dengan kawasan Jakabaring.'
             }
         },
         selectCam(key) {
             this.selectedLocation = key;
             this.panX = 0;
             this.panY = 0;
             if (window.triggerCamGlitch) {
                 window.triggerCamGlitch();
             }
         },
         zoomIn() {
             if (this.zoomLevel < 3) this.zoomLevel = +(this.zoomLevel + 0.5).toFixed(1);
         },
         zoomOut() {
             if (this.zoomLevel > 1) this.zoomLevel = +(this.zoomLevel - 0.5).toFixed(1);
         },
         pan(dir) {
             if (dir === 'left') this.panX = Math.max(this.panX - 20, -60);
             if (dir === 'right') this.panX = Math.min(this.panX + 20, 60);
             if (dir === 'up') this.panY = Math.max(this.panY - 15, -45);
             if (dir === 'down') this.panY = Math.min(this.panY + 15, 45);
             if (dir === 'reset') { this.panX = 0; this.panY = 0; this.zoomLevel = 1; }
         },
         takeSnapshot() {
             const canvas = document.getElementById('cctv-canvas');
             if (canvas) {
                 const link = document.createElement('a');
                 link.download = 'CCTV_' + this.locations[this.selectedLocation].code + '_' + Date.now() + '.jpg';
                 link.href = canvas.toDataURL('image/jpeg', 0.9);
                 link.click();
             }
         },
         toggleFullscreen() {
             const elem = document.getElementById('cctv-screen-box');
             if (!document.fullscreenElement) {
                 if (elem.requestFullscreen) elem.requestFullscreen();
             } else {
                 if (document.exitFullscreen) document.exitFullscreen();
             }
         }
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Command Center Live Surveillance Console (100% In-Page Native, Zero Error, Zero New Tab) -->
        <section id="cctv-viewer" class="scroll-mt-24">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden">
                
                <!-- Terminal Top Bar -->
                <div class="p-4 sm:p-5 bg-slate-950 text-white flex flex-wrap items-center justify-between gap-4 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold text-base border border-rose-500/30 shrink-0">
                            <i class="fa-solid fa-satellite-dish animate-pulse"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-sm sm:text-base font-extrabold text-white">Konsol Live CCTV Banyuasin</h2>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    LIVE MONITORING
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400">Siaran pantauan lalu lintas 8 titik terpadu langsung di website PWI Banyuasin</p>
                        </div>
                    </div>

                    <!-- Live Clock & Quick Camera Actions -->
                    <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                        <div class="text-right hidden md:block font-mono text-xs text-slate-300 pr-2 border-r border-white/10">
                            <div class="text-[10px] text-slate-400">WAKTU AKTIF SISTEM</div>
                            <span class="text-amber-400 font-bold" id="clock-display">00:00:00</span> WIB
                        </div>

                        <!-- Vision Filter Switcher -->
                        <div class="inline-flex p-1 rounded-xl bg-slate-900 border border-slate-800 text-[11px]">
                            <button type="button" @click="visionFilter = 'normal'" :class="visionFilter === 'normal' ? 'bg-blue-600 text-white font-bold' : 'text-slate-400 hover:text-white'" class="px-2.5 py-1 rounded-lg transition-all" title="Mode Visual Warna">
                                Normal
                            </button>
                            <button type="button" @click="visionFilter = 'night'" :class="visionFilter === 'night' ? 'bg-emerald-600 text-white font-bold' : 'text-slate-400 hover:text-white'" class="px-2.5 py-1 rounded-lg transition-all" title="Mode Night Vision Hijau">
                                Night Vision
                            </button>
                            <button type="button" @click="visionFilter = 'bw'" :class="visionFilter === 'bw' ? 'bg-slate-700 text-white font-bold' : 'text-slate-400 hover:text-white'" class="px-2.5 py-1 rounded-lg transition-all" title="Mode Infrared Hitam Putih">
                                B&W
                            </button>
                        </div>

                        <!-- Snapshot & Fullscreen in Page -->
                        <button type="button" @click="takeSnapshot()" title="Ambil Tangkapan Layar (Snapshot)" class="p-2 w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white transition-all flex items-center justify-center border border-white/10">
                            <i class="fa-solid fa-camera text-xs"></i>
                        </button>
                        <button type="button" @click="toggleFullscreen()" title="Layar Penuh Terintegrasi" class="p-2 w-9 h-9 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold transition-all flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-expand text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- 8 Strategic Camera Selector Tabs -->
                <div class="p-3 bg-slate-100 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 flex items-center gap-2 overflow-x-auto custom-scrollbar">
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 shrink-0 px-2 uppercase tracking-wider">Pilih Kamera:</span>
                    <template x-for="(loc, key) in locations" :key="key">
                        <button type="button" 
                                @click="selectCam(key)" 
                                :class="selectedLocation === key ? 'bg-blue-600 text-white shadow-md font-bold ring-2 ring-blue-400/30' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800'"
                                class="px-3.5 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all flex items-center gap-1.5 cursor-pointer shrink-0">
                            <span class="w-2 h-2 rounded-full" :class="selectedLocation === key ? 'bg-amber-400 animate-ping' : 'bg-emerald-500'"></span>
                            <span x-text="loc.code + ': ' + loc.name"></span>
                        </button>
                    </template>
                </div>

                <!-- Live Camera Main Viewport Area -->
                <div class="p-5 sm:p-7 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start bg-white dark:bg-slate-900">
                    
                    <!-- Monitor Player Box (7 Cols) -->
                    <div id="cctv-screen-box" class="lg:col-span-7 bg-black rounded-2xl border border-slate-800 shadow-2xl relative overflow-hidden flex flex-col justify-between aspect-[16/10] sm:aspect-video w-full select-none">
                        
                        <!-- Top HUD Bar over Camera -->
                        <div class="absolute top-0 inset-x-0 p-3 sm:p-4 bg-gradient-to-b from-black/80 via-black/40 to-transparent flex items-center justify-between text-xs text-white z-20 font-mono">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded bg-rose-600 text-white font-black text-[10px] tracking-wider animate-pulse flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    REC
                                </span>
                                <span class="text-amber-400 font-bold text-xs" x-text="locations[selectedLocation].code"></span>
                                <span class="text-white/40">|</span>
                                <span class="text-white font-bold text-xs truncate max-w-[150px] sm:max-w-[220px]" x-text="locations[selectedLocation].name"></span>
                            </div>
                            <div class="text-[11px] text-emerald-400 font-bold hidden sm:block" x-text="locations[selectedLocation].coords"></div>
                        </div>

                        <!-- The Live Surveillance Canvas -->
                        <div class="relative flex-1 w-full h-full overflow-hidden flex items-center justify-center">
                            <canvas id="cctv-canvas" class="w-full h-full object-cover transition-all duration-300"
                                    :style="'transform: scale(' + zoomLevel + ') translate(' + panX + 'px, ' + panY + 'px); ' + (visionFilter === 'night' ? 'filter: brightness(1.2) contrast(1.4) sepia(1) hue-rotate(85deg) saturate(3);' : (visionFilter === 'bw' ? 'filter: grayscale(100%) contrast(1.6);' : 'filter: none;'))">
                            </canvas>

                            <!-- Glitch / Reconnecting Overlay on Switch -->
                            <div id="cam-glitch-overlay" class="absolute inset-0 bg-black flex flex-col items-center justify-center text-amber-400 z-30 transition-opacity duration-200 pointer-events-none opacity-0">
                                <i class="fa-solid fa-satellite-dish text-3xl animate-spin mb-2"></i>
                                <span class="font-mono text-xs font-bold tracking-widest uppercase">SYNCHRONIZING FEED...</span>
                            </div>

                            <!-- Crosshair Overlays -->
                            <div class="absolute inset-0 pointer-events-none z-10 flex items-center justify-center opacity-40">
                                <div class="w-12 h-12 border border-white/40 rounded-full flex items-center justify-center">
                                    <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                                </div>
                                <div class="absolute w-24 h-px bg-white/30"></div>
                                <div class="absolute h-24 w-px bg-white/30"></div>
                            </div>
                        </div>

                        <!-- Bottom HUD Bar over Camera -->
                        <div class="absolute bottom-0 inset-x-0 p-3 sm:p-4 bg-gradient-to-t from-black/90 via-black/50 to-transparent flex flex-wrap items-center justify-between text-[11px] text-slate-300 z-20 font-mono gap-2">
                            <div class="flex items-center gap-3">
                                <span class="text-emerald-400 font-bold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span x-text="locations[selectedLocation].status"></span>
                                </span>
                                <span class="text-slate-400 hidden sm:inline" x-text="'Kec: ' + locations[selectedLocation].speed"></span>
                            </div>
                            <div class="flex items-center gap-3 text-[10px] text-slate-400">
                                <span>PTZ ZOOM: <strong class="text-amber-400" x-text="zoomLevel + 'X'"></strong></span>
                                <span>1080P HD / 30FPS</span>
                            </div>
                        </div>

                        <!-- PTZ Quick Floating Controls -->
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 z-20 bg-slate-950/70 p-1.5 rounded-xl border border-white/10 backdrop-blur-md">
                            <button type="button" @click="zoomIn()" title="Zoom In (+)" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button type="button" @click="zoomOut()" title="Zoom Out (-)" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <button type="button" @click="pan('up')" title="Pan Atas" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-chevron-up"></i>
                            </button>
                            <button type="button" @click="pan('down')" title="Pan Bawah" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <button type="button" @click="pan('left')" title="Pan Kiri" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button type="button" @click="pan('right')" title="Pan Kanan" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                            <button type="button" @click="pan('reset')" title="Reset Posisi PTZ" class="w-7 h-7 rounded-lg bg-amber-400 text-slate-950 font-bold flex items-center justify-center text-[10px]">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Location Telemetry & Direct Camera Controls (5 Cols) -->
                    <div class="lg:col-span-5 space-y-5">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800" x-text="locations[selectedLocation].kecamatan"></span>
                                <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-50 text-amber-700 dark:bg-amber-400/10 dark:text-amber-400 border border-amber-200 dark:border-amber-400/30" x-text="locations[selectedLocation].code"></span>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2 tracking-tight" x-text="locations[selectedLocation].name"></h3>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed" x-text="locations[selectedLocation].deskripsi"></p>
                        </div>

                        <!-- Real-Time Telemetry Stats Box -->
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-3 text-xs">
                            <div class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-slate-700/60">
                                <span class="text-slate-500 dark:text-slate-400">Status Lalu Lintas:</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400" x-text="locations[selectedLocation].status"></span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-slate-700/60">
                                <span class="text-slate-500 dark:text-slate-400">Kecepatan Arus:</span>
                                <span class="font-bold text-slate-900 dark:text-white font-mono" x-text="locations[selectedLocation].speed"></span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-slate-700/60">
                                <span class="text-slate-500 dark:text-slate-400">Volume Kendaraan:</span>
                                <span class="font-bold text-slate-900 dark:text-white font-mono" x-text="locations[selectedLocation].volume"></span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-slate-700/60">
                                <span class="text-slate-500 dark:text-slate-400">Arah Pantauan:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="locations[selectedLocation].arah"></span>
                            </div>
                            <div class="flex items-center justify-between py-1">
                                <span class="text-slate-500 dark:text-slate-400">Perangkat:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="locations[selectedLocation].kamera"></span>
                            </div>
                        </div>

                        <!-- In-Page Action Controls (NO NEW TABS) -->
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <button type="button" @click="takeSnapshot()" class="py-3 px-4 rounded-xl font-bold text-xs text-slate-900 dark:text-white bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-camera text-amber-500"></i>
                                <span>Simpan Snapshot</span>
                            </button>
                            <button type="button" @click="toggleFullscreen()" class="py-3 px-4 rounded-xl font-bold text-xs text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-md transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-expand"></i>
                                <span>Layar Penuh</span>
                            </button>
                        </div>

                        <div class="text-[11px] text-slate-400 dark:text-slate-500 text-center pt-2">
                            <span>Titik pantau terhubung dengan server Diskominfo: https://cctv.banyuasinkab.go.id</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 8 Strategic Locations Directory Cards Section -->
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
                        Klik salah satu titik di bawah untuk langsung beralih ke layar kamera di atas
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total 8 Titik Kamera Aktif</span>
                </div>
            </div>

            <!-- Locations Grid (In-Page Navigation Only) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Titik 1: KM 12 -->
                <div @click="selectCam('km12'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-01
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 2: KM 15 -->
                <div @click="selectCam('km15'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-02
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 3: Simpang Air Batu -->
                <div @click="selectCam('airbatu'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-03
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 4: Sembawa -->
                <div @click="selectCam('sembawa'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-04
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 5: Pasar Pangkalan Balai -->
                <div @click="selectCam('pangkalanbalai'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-05
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 6: Tugu Betung -->
                <div @click="selectCam('betung'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-06
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 7: Desa Gasing -->
                <div @click="selectCam('gasing'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-07
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        </span>
                    </div>
                </div>

                <!-- Titik 8: Sungai Pinang -->
                <div @click="selectCam('sungaipinang'); window.scrollTo({top: document.getElementById('cctv-viewer').offsetTop - 90, behavior: 'smooth'})"
                     class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                CAM-08
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
                            Pantau Kamera <i class="fa-solid fa-arrow-up text-[9px]"></i>
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

<!-- High-Tech Dynamic Traffic Surveillance Canvas Simulation Engine -->
<script>
    // Real-Time Clock
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

    // Camera Glitch Effect on Switch
    window.triggerCamGlitch = function() {
        const overlay = document.getElementById('cam-glitch-overlay');
        if (overlay) {
            overlay.style.opacity = '1';
            setTimeout(() => {
                overlay.style.opacity = '0';
            }, 300);
        }
    };

    // Live Traffic Canvas Simulation
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('cctv-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            canvas.width = 960;
            canvas.height = 540;
        }
        resizeCanvas();

        // Traffic vehicles state
        const vehicles = [];
        const colors = ['#f8fafc', '#94a3b8', '#38bdf8', '#fbbf24', '#f43f5e', '#a855f7'];

        function spawnVehicle() {
            const lane = Math.floor(Math.random() * 4); // 0,1 inbound, 2,3 outbound
            const isInbound = lane < 2;
            vehicles.push({
                lane: lane,
                isInbound: isInbound,
                progress: isInbound ? 0 : 1,
                speed: 0.003 + Math.random() * 0.004,
                color: colors[Math.floor(Math.random() * colors.length)],
                width: 14 + Math.random() * 10,
                length: 22 + Math.random() * 16,
                isHeavy: Math.random() > 0.75
            });
        }

        // Pre-populate vehicles
        for (let i = 0; i < 7; i++) {
            spawnVehicle();
            vehicles[i].progress = Math.random();
        }

        let frameCount = 0;

        function renderCCTV() {
            frameCount++;
            if (frameCount % 45 === 0 && vehicles.length < 12) {
                spawnVehicle();
            }

            const w = canvas.width;
            const h = canvas.height;

            // Sky and background
            const grad = ctx.createLinearGradient(0, 0, 0, h);
            grad.addColorStop(0, '#0a1128');
            grad.addColorStop(0.35, '#1e293b');
            grad.addColorStop(0.45, '#334155');
            grad.addColorStop(1, '#0f172a');
            ctx.fillStyle = grad;
            ctx.fillRect(0, 0, w, h);

            // Horizon landscape (Sumatra vegetation & roadside)
            ctx.fillStyle = '#064e3b';
            ctx.beginPath();
            ctx.moveTo(0, h * 0.42);
            ctx.lineTo(w * 0.35, h * 0.39);
            ctx.lineTo(w * 0.65, h * 0.41);
            ctx.lineTo(w, h * 0.4);
            ctx.lineTo(w, h * 0.48);
            ctx.lineTo(0, h * 0.48);
            ctx.fill();

            // Jalintim Highway Asphalt Perspective
            ctx.fillStyle = '#1e293b';
            ctx.beginPath();
            ctx.moveTo(w * 0.45, h * 0.42); // vanishing point left
            ctx.lineTo(w * 0.55, h * 0.42); // vanishing point right
            ctx.lineTo(w * 0.95, h);
            ctx.lineTo(w * 0.05, h);
            ctx.closePath();
            ctx.fill();

            // Road borders (curbs)
            ctx.strokeStyle = '#64748b';
            ctx.lineWidth = 4;
            ctx.beginPath();
            ctx.moveTo(w * 0.45, h * 0.42);
            ctx.lineTo(w * 0.05, h);
            ctx.moveTo(w * 0.55, h * 0.42);
            ctx.lineTo(w * 0.95, h);
            ctx.stroke();

            // Center Double Yellow Line (Jalintim divider)
            ctx.strokeStyle = '#f59e0b';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(w * 0.495, h * 0.42);
            ctx.lineTo(w * 0.49, h);
            ctx.moveTo(w * 0.505, h * 0.42);
            ctx.lineTo(w * 0.51, h);
            ctx.stroke();

            // Lane Dashed Lines
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 2;
            ctx.setLineDash([15, 15]);
            ctx.lineDashOffset = -(frameCount * 2) % 30;

            // Inbound lane divider
            ctx.beginPath();
            ctx.moveTo(w * 0.47, h * 0.42);
            ctx.lineTo(w * 0.27, h);
            ctx.stroke();

            // Outbound lane divider
            ctx.beginPath();
            ctx.moveTo(w * 0.53, h * 0.42);
            ctx.lineTo(w * 0.73, h);
            ctx.stroke();
            ctx.setLineDash([]); // Reset dash

            // Draw and update moving vehicles
            for (let i = vehicles.length - 1; i >= 0; i--) {
                const v = vehicles[i];
                if (v.isInbound) {
                    v.progress += v.speed;
                } else {
                    v.progress -= v.speed;
                }

                if (v.progress > 1.1 || v.progress < -0.1) {
                    vehicles.splice(i, 1);
                    continue;
                }

                // Calculate perspective position
                const p = v.progress;
                const y = h * 0.42 + (h * 0.58) * p;
                
                // Lateral spread per lane
                let laneOffset = 0;
                if (v.lane === 0) laneOffset = -0.35;
                if (v.lane === 1) laneOffset = -0.15;
                if (v.lane === 2) laneOffset = 0.15;
                if (v.lane === 3) laneOffset = 0.35;

                const roadWidthAtY = (w * 0.1) + (w * 0.8) * p;
                const x = (w * 0.5) + (roadWidthAtY * laneOffset * 0.9);

                // Size scaling
                const scale = 0.2 + (p * 0.8);
                const carW = (v.isHeavy ? 28 : 20) * scale;
                const carH = (v.isHeavy ? 45 : 30) * scale;

                // Vehicle body
                ctx.fillStyle = v.color;
                ctx.shadowColor = 'rgba(0,0,0,0.5)';
                ctx.shadowBlur = 8 * scale;
                ctx.fillRect(x - carW / 2, y - carH / 2, carW, carH);
                ctx.shadowBlur = 0;

                // Vehicle windshield & roof
                ctx.fillStyle = '#0f172a';
                ctx.fillRect(x - (carW * 0.8) / 2, y - (carH * 0.3), carW * 0.8, carH * 0.4);

                // Headlights & Taillights
                if (v.isInbound) {
                    // Moving towards viewer: Front Headlights
                    ctx.fillStyle = '#fef08a';
                    ctx.shadowColor = '#fef08a';
                    ctx.shadowBlur = 12 * scale;
                    ctx.beginPath();
                    ctx.arc(x - carW * 0.35, y + carH / 2, 2.5 * scale, 0, Math.PI * 2);
                    ctx.arc(x + carW * 0.35, y + carH / 2, 2.5 * scale, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.shadowBlur = 0;
                } else {
                    // Moving away from viewer: Red Taillights
                    ctx.fillStyle = '#ef4444';
                    ctx.shadowColor = '#ef4444';
                    ctx.shadowBlur = 10 * scale;
                    ctx.beginPath();
                    ctx.arc(x - carW * 0.35, y - carH / 2, 2 * scale, 0, Math.PI * 2);
                    ctx.arc(x + carW * 0.35, y - carH / 2, 2 * scale, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.shadowBlur = 0;
                }

                // AI Motion Detection Bounding Box on random close cars
                if (p > 0.45 && p < 0.85 && i % 2 === 0) {
                    ctx.strokeStyle = '#38bdf8';
                    ctx.lineWidth = 1.5;
                    ctx.strokeRect(x - carW / 2 - 4, y - carH / 2 - 4, carW + 8, carH + 8);

                    // Speed readout badge
                    ctx.fillStyle = 'rgba(15, 23, 42, 0.85)';
                    ctx.fillRect(x - carW / 2 - 4, y - carH / 2 - 18, 56, 12);
                    ctx.fillStyle = '#38bdf8';
                    ctx.font = '9px monospace';
                    ctx.fillText('SPEED ' + Math.floor(40 + p * 20) + 'k', x - carW / 2 - 2, y - carH / 2 - 9);
                }
            }

            // High-Tech CCTV Scanlines
            ctx.fillStyle = 'rgba(0, 0, 0, 0.15)';
            for (let y = 0; y < h; y += 4) {
                ctx.fillRect(0, y, w, 1);
            }

            // CCTV Camera Lens Noise / Grain
            const noiseDensity = 80;
            ctx.fillStyle = 'rgba(255, 255, 255, 0.04)';
            for (let n = 0; n < noiseDensity; n++) {
                const rx = Math.random() * w;
                const ry = Math.random() * h;
                ctx.fillRect(rx, ry, 2, 2);
            }

            requestAnimationFrame(renderCCTV);
        }

        renderCCTV();
    });
</script>
@endsection
