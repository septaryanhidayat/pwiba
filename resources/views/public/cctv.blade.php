@extends('layouts.public')

@section('title', 'Pantauan CCTV Banyuasin Real-Time - Layanan Publik')
@section('meta_description', 'Pusat informasi pantauan kamera CCTV arus lalu lintas dan titik strategis di Kabupaten Banyuasin secara langsung (real-time) bekerja sama dengan Diskominfo Banyuasin.')

@push('styles')
<style>
    /* CCTV Surveillance Authentic Effects */
    .cctv-scanlines {
        background: linear-gradient(
            rgba(18, 16, 16, 0) 50%, 
            rgba(0, 0, 0, 0.25) 50%
        ), linear-gradient(
            90deg,
            rgba(255, 0, 0, 0.03),
            rgba(0, 255, 0, 0.01),
            rgba(0, 0, 255, 0.03)
        );
        background-size: 100% 4px, 6px 100%;
        pointer-events: none;
    }
    
    .cctv-reticle {
        background-image: 
            radial-gradient(circle at center, transparent 96%, rgba(255, 255, 255, 0.15) 97%, transparent 98%),
            linear-gradient(to right, transparent 48%, rgba(255, 255, 255, 0.1) 49%, rgba(255, 255, 255, 0.1) 51%, transparent 52%),
            linear-gradient(to bottom, transparent 48%, rgba(255, 255, 255, 0.1) 49%, rgba(255, 255, 255, 0.1) 51%, transparent 52%);
        pointer-events: none;
    }

    .cctv-night-vision {
        filter: brightness(1.2) contrast(1.3) hue-rotate(85deg) saturate(2) !important;
    }

    .cam-card-active {
        border-color: #f59e0b !important;
        background-color: rgba(245, 158, 11, 0.1) !important;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.25) !important;
    }
</style>
@endpush

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
                    <span>MONITORING LALU LINTAS 24 JAM</span>
                    <span class="text-white/40">•</span>
                    <span class="text-amber-400 font-semibold">DISKOMINFO BANYUASIN</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight leading-tight">
                    Pantauan CCTV Lalu Lintas <br class="hidden sm:inline">Kabupaten Banyuasin
                </h1>

                <p class="text-slate-300 text-xs sm:text-base mt-3 leading-relaxed max-w-2xl">
                    Informasi terpadu pemantauan arus lalu lintas di sepanjang Jalur Lintas Timur (Jalintim) Palembang–Betung dan titik strategis lainnya secara langsung (*real-time*) bekerja sama dengan Pemerintah Kabupaten Banyuasin.
                </p>

                <!-- Primary Action Buttons (In-Page Navigation, NO New Tab) -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mt-6">
                    <a href="#cctv-monitor-station" class="px-6 py-3.5 rounded-xl font-black text-xs sm:text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/30 transition-all flex items-center gap-2.5 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-display text-slate-950"></i>
                        <span>Buka Layar Pantau CCTV</span>
                        <i class="fa-solid fa-arrow-down text-xs"></i>
                    </a>
                    <a href="#titik-pantau" class="px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-amber-400"></i>
                        <span>Pilih Dari 8 Kamera</span>
                    </a>
                </div>
            </div>

            <!-- Header Quick Info Stats -->
            <div class="w-full lg:w-auto flex-shrink-0 grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-amber-400">8 Titik</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Kamera Pengawas</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-400">24 Jam</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Siaga Online</div>
                </div>
                <div class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-sky-400">Full HD</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Kualitas Visual</div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="py-10 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- ========================================================================= -->
        <!-- CCTV LIVE MONITOR STATION (EMBEDDED IN-PAGE VIEWER)                       -->
        <!-- ========================================================================= -->
        <section id="cctv-monitor-station" class="scroll-mt-24">
            
            <div class="bg-slate-950 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden text-white">
                
                <!-- Monitor Top Telemetry & Control Bar -->
                <div class="bg-slate-900/90 border-b border-slate-800 px-4 sm:px-6 py-3.5 flex flex-wrap items-center justify-between gap-3">
                    
                    <!-- Left: REC Status & Active Camera Title -->
                    <div class="flex items-center gap-3">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-red-950/80 border border-red-500/40 text-red-400 font-mono text-xs font-bold">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                            <span>REC LIVE</span>
                        </div>
                        <div>
                            <span id="active-cam-badge" class="font-extrabold text-xs sm:text-sm text-amber-400 font-mono tracking-wide">
                                CAM-01
                            </span>
                            <span class="text-white/40 mx-1.5">•</span>
                            <span id="active-cam-title" class="font-bold text-xs sm:text-sm text-white">
                                Gerbang KM 12 - Talang Kelapa
                            </span>
                            <span id="active-cam-road" class="hidden md:inline text-xs text-slate-400 font-mono ms-2">
                                [Jalintim KM 12 - Perbatasan]
                            </span>
                        </div>
                    </div>

                    <!-- Right: Live Timestamp, Signal & Mode Tabs -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <!-- Digital Clock -->
                        <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-800/80 border border-slate-700 text-emerald-400 font-mono text-xs font-bold tracking-wider">
                            <i class="fa-solid fa-clock text-[10px] text-emerald-500"></i>
                            <span id="live-cctv-clock">00:00:00 WIB</span>
                        </div>

                        <!-- Signal Badge -->
                        <div class="hidden lg:flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-950/50 border border-sky-500/30 text-sky-300 font-mono text-xs">
                            <i class="fa-solid fa-signal text-[10px]"></i>
                            <span>1080p 30FPS</span>
                        </div>

                        <!-- Mode Switch Buttons -->
                        <div class="inline-flex rounded-xl bg-slate-800 p-1 border border-slate-700/60 text-xs">
                            <button id="tab-btn-multi" onclick="setMonitorMode('multi')" class="px-3 py-1.5 rounded-lg font-bold transition-all bg-amber-400 text-slate-950 flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-video text-xs"></i>
                                <span>Multi-Kamera</span>
                            </button>
                            <button id="tab-btn-bridge" onclick="setMonitorMode('bridge')" class="px-3 py-1.5 rounded-lg font-bold transition-all text-slate-300 hover:text-white flex items-center gap-1.5">
                                <i class="fa-solid fa-satellite-dish text-xs"></i>
                                <span>Bridge Pemkab</span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Monitor Display Viewport -->
                <div id="cctv-viewport-container" class="relative w-full bg-black flex items-center justify-center overflow-hidden min-h-[340px] sm:min-h-[480px] lg:min-h-[580px] select-none">
                    
                    <!-- MODE 1: MULTI-CAMERA SURVEILLANCE FEED -->
                    <div id="view-multi-cam" class="relative w-full h-full min-h-[340px] sm:min-h-[480px] lg:min-h-[580px] flex items-center justify-center bg-slate-950">
                        
                        <!-- Main Surveillance Image / Video Feed -->
                        <img id="cctv-display-img" 
                             src="{{ asset('images/cctv/cam_km12.jpg') }}" 
                             alt="Pantauan CCTV Banyuasin" 
                             class="w-full h-full object-cover transition-all duration-300 filter" 
                             style="max-height: 580px;" />

                        <!-- Authentic CCTV Surveillance Scanlines & Grid Overlay -->
                        <div class="cctv-scanlines absolute inset-0"></div>
                        <div class="cctv-reticle absolute inset-0 opacity-40"></div>

                        <!-- Top-Left Telemetry HUD Overlay -->
                        <div class="absolute top-4 left-4 z-20 pointer-events-none">
                            <div class="bg-black/70 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/15 text-white font-mono text-[11px] sm:text-xs shadow-lg space-y-0.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                    <span id="hud-cam-id" class="text-amber-400 font-bold tracking-wider">CAM 01 // KM 12</span>
                                </div>
                                <div id="hud-location-name" class="text-slate-200 font-semibold text-[10px] sm:text-xs">
                                    GERBANG PERBATASAN TALANG KELAPA
                                </div>
                                <div id="hud-coordinates" class="text-slate-400 text-[9px] sm:text-[10px]">
                                    KOORDINAT: -2.9381° S, 104.6812° E
                                </div>
                            </div>
                        </div>

                        <!-- Top-Right Timestamp & FPS HUD Overlay -->
                        <div class="absolute top-4 right-4 z-20 pointer-events-none text-right">
                            <div class="bg-black/70 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/15 text-white font-mono text-[11px] sm:text-xs shadow-lg space-y-0.5">
                                <div id="hud-timestamp" class="text-emerald-400 font-bold tracking-wider">
                                    2026-09-07 00:00:00 WIB
                                </div>
                                <div class="text-slate-300 text-[10px] flex items-center justify-end gap-1.5">
                                    <span class="text-sky-400 font-semibold">29.97 FPS</span>
                                    <span class="text-white/30">•</span>
                                    <span class="text-amber-300">4.8 Mbps</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom-Left Traffic Condition Telemetry Pill -->
                        <div class="absolute bottom-4 left-4 z-20 pointer-events-none">
                            <div class="bg-black/75 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/15 text-white font-mono text-xs shadow-lg flex items-center gap-3">
                                <div class="flex items-center gap-2">
                                    <span id="telemetry-status-dot" class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span id="telemetry-status-text" class="text-emerald-400 font-bold text-xs">ARUS LANCAR TERKENDALI</span>
                                </div>
                                <span class="text-white/30 hidden sm:inline">•</span>
                                <div id="telemetry-speed" class="text-slate-300 text-[11px] hidden sm:inline">
                                    Kecepatan: ~45-60 km/j
                                </div>
                                <span class="text-white/30 hidden md:inline">•</span>
                                <div id="telemetry-weather" class="text-amber-300 text-[11px] hidden md:inline">
                                    Cuaca: Cerah / Kering
                                </div>
                            </div>
                        </div>

                        <!-- Bottom-Right Watermark -->
                        <div class="absolute bottom-4 right-4 z-20 pointer-events-none hidden sm:block">
                            <div class="bg-black/60 backdrop-blur-sm px-3 py-1.5 rounded-lg border border-white/10 text-white/70 font-mono text-[10px] tracking-wide">
                                DISKOMINFO BANYUASIN &bull; PWI MONITOR
                            </div>
                        </div>

                        <!-- Interactive Floating Quick Controls (Center-Bottom) -->
                        <div class="absolute bottom-16 sm:bottom-4 z-30 flex items-center gap-2 bg-slate-900/90 backdrop-blur-md border border-slate-700/80 px-3 py-1.5 rounded-2xl shadow-2xl">
                            <!-- Toggle Night Vision -->
                            <button onclick="toggleNightVision()" id="btn-night-vision" title="Mode Malam / Infra Red" class="p-2 rounded-xl text-slate-300 hover:text-emerald-400 hover:bg-slate-800 transition-colors text-xs font-bold flex items-center gap-1">
                                <i class="fa-solid fa-moon"></i>
                                <span class="hidden md:inline">IR Vision</span>
                            </button>

                            <div class="w-px h-4 bg-slate-700"></div>

                            <!-- Toggle Zoom -->
                            <button onclick="toggleZoom()" id="btn-zoom" title="Perbesar / Zoom" class="p-2 rounded-xl text-slate-300 hover:text-amber-400 hover:bg-slate-800 transition-colors text-xs font-bold flex items-center gap-1">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                                <span id="zoom-label" class="hidden md:inline">1.0x</span>
                            </button>

                            <div class="w-px h-4 bg-slate-700"></div>

                            <!-- Refresh Frame -->
                            <button onclick="refreshCurrentFeed()" title="Segarkan Kamera" class="p-2 rounded-xl text-slate-300 hover:text-sky-400 hover:bg-slate-800 transition-colors text-xs font-bold flex items-center gap-1">
                                <i id="refresh-icon" class="fa-solid fa-rotate-right"></i>
                                <span class="hidden md:inline">Refresh</span>
                            </button>

                            <div class="w-px h-4 bg-slate-700"></div>

                            <!-- Fullscreen -->
                            <button onclick="toggleFullscreen()" title="Layar Penuh" class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition-colors text-xs font-bold flex items-center gap-1">
                                <i class="fa-solid fa-expand"></i>
                                <span class="hidden md:inline">Fullscreen</span>
                            </button>
                        </div>

                    </div>

                    <!-- MODE 2: IN-PAGE BRIDGE GATEWAY (NATIVE DISKOMINFO SERVER IFRAME) -->
                    <div id="view-bridge-frame" class="hidden w-full h-[580px] bg-white relative">
                        <iframe id="diskominfo-bridge-iframe" 
                                src="{{ route('cctv.live-bridge') }}" 
                                title="Siaran CCTV Diskominfo Kab. Banyuasin" 
                                class="w-full h-full border-0"
                                loading="lazy"></iframe>
                        
                        <!-- In-Frame Overlay Info Bar -->
                        <div class="absolute top-3 left-3 z-30 bg-slate-900/90 backdrop-blur-md px-3.5 py-1.5 rounded-xl border border-slate-700 text-white font-mono text-xs flex items-center gap-2 shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-amber-400 font-bold">IN-PAGE BRIDGE:</span>
                            <span class="text-slate-300">Origin Host 103.75.150.75</span>
                        </div>
                    </div>

                </div>

                <!-- Camera Quick Selection Dock (8 Strategic Cameras) -->
                <div class="bg-slate-900/95 border-t border-slate-800 p-4 sm:p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-amber-400 text-xs"></i>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-300">Pilih Kamera Pengawas (8 Titik Jalintim)</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-mono">Klik kamera untuk beralih siaran langsung</span>
                    </div>

                    <!-- Horizontal Grid of 8 Cameras -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2.5">
                        
                        <!-- CAM 01 -->
                        <button onclick="switchCamera(0)" id="cam-selector-0" class="cam-card cam-card-active p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-amber-400">CAM 01</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">KM 12</div>
                            <div class="text-[10px] text-slate-400 truncate">Gerbang Utama</div>
                        </button>

                        <!-- CAM 02 -->
                        <button onclick="switchCamera(1)" id="cam-selector-1" class="cam-card p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-slate-300 group-hover:text-amber-400">CAM 02</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">KM 15</div>
                            <div class="text-[10px] text-slate-400 truncate">Simpang Y Sukajadi</div>
                        </button>

                        <!-- CAM 03 -->
                        <button onclick="switchCamera(2)" id="cam-selector-2" class="cam-card p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-slate-300 group-hover:text-amber-400">CAM 03</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">Air Batu</div>
                            <div class="text-[10px] text-slate-400 truncate">Tanjung Api-Api</div>
                        </button>

                        <!-- CAM 04 -->
                        <button onclick="switchCamera(3)" id="cam-selector-3" class="cam-card p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-slate-300 group-hover:text-amber-400">CAM 04</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">KM 29</div>
                            <div class="text-[10px] text-slate-400 truncate">Sembawa</div>
                        </button>

                        <!-- CAM 05 -->
                        <button onclick="switchCamera(4)" id="cam-selector-4" class="cam-card p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-slate-300 group-hover:text-amber-400">CAM 05</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">Pangkalan Balai</div>
                            <div class="text-[10px] text-slate-400 truncate">Pasar & Kota</div>
                        </button>

                        <!-- CAM 06 -->
                        <button onclick="switchCamera(5)" id="cam-selector-5" class="cam-card p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-slate-300 group-hover:text-amber-400">CAM 06</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">Betung</div>
                            <div class="text-[10px] text-slate-400 truncate">Simpang Tugu</div>
                        </button>

                        <!-- CAM 07 -->
                        <button onclick="switchCamera(6)" id="cam-selector-6" class="cam-card p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-slate-300 group-hover:text-amber-400">CAM 07</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">Gasing</div>
                            <div class="text-[10px] text-slate-400 truncate">Kawasan Industri</div>
                        </button>

                        <!-- CAM 08 -->
                        <button onclick="switchCamera(7)" id="cam-selector-7" class="cam-card p-2.5 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-left transition-all duration-200 group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-[10px] font-extrabold text-slate-300 group-hover:text-amber-400">CAM 08</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="font-bold text-xs text-white group-hover:text-amber-300 truncate">Sungai Pinang</div>
                            <div class="text-[10px] text-slate-400 truncate">Rambutan</div>
                        </button>

                    </div>
                </div>

            </div>

        </section>

        <!-- Official Streaming Server Portal Card (Integrated In-Page Bridge Info) -->
        <section class="bg-gradient-to-r from-blue-950 via-slate-900 to-[#0B132B] text-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-blue-900/60 relative overflow-hidden">
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6">
                
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold text-2xl shrink-0 shadow-lg shadow-amber-400/20">
                        <i class="fa-solid fa-satellite-dish"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-1.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                SERVER RESMI AKTIF
                            </span>
                            <span class="text-xs text-slate-400 font-mono">https://cctv.banyuasinkab.go.id</span>
                            <span class="text-xs text-emerald-400 font-mono hidden sm:inline">• Origin Host: 103.75.150.75</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                            Portal Resmi CCTV Diskominfo Kab. Banyuasin
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1.5 max-w-3xl leading-relaxed">
                            Siaran langsung video kamera pemantau lalu lintas dikelola dan ditransmisikan secara terpusat oleh Dinas Komunikasi, Informatika, Statistik dan Persandian (Diskominfo) Pemerintah Kabupaten Banyuasin. Telah terintegrasi langsung pada layar pantau website PWI Banyuasin.
                        </p>
                    </div>
                </div>

                <div class="shrink-0 w-full lg:w-auto flex flex-col sm:flex-row items-center gap-3">
                    <button onclick="setMonitorMode('bridge'); document.getElementById('cctv-monitor-station').scrollIntoView({ behavior: 'smooth' });" class="w-full sm:w-auto px-7 py-4 rounded-xl font-black text-xs sm:text-sm text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-xl shadow-amber-400/30 transition-all flex items-center justify-center gap-2.5 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-satellite-dish"></i>
                        <span>Tampilkan Bridge Pemkab di Layar</span>
                    </button>
                </div>

            </div>
            
            <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        </section>

        <!-- 8 Strategic Locations Directory Cards Section -->
        <section id="titik-pantau" class="scroll-mt-28 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-400/10 px-3.5 py-1 rounded-full border border-amber-200 dark:border-amber-400/30">
                        Titik Pengawasan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Daftar 8 Titik CCTV Strategis Banyuasin
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm mt-1">
                        Sebaran kamera pemantau arus lalu lintas di titik rawan kepadatan dan gerbang perbatasan Jalintim
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total 8 Titik Utama</span>
                </div>
            </div>

            <!-- Locations Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Titik 1: KM 12 -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-01
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Gerbang KM 12
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Pintu gerbang utama perbatasan Palembang – Banyuasin. Memantau arus kendaraan keluar masuk wilayah metropolitan.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Jalintim KM 12</span>
                        <button onclick="switchCamera(0)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Titik 2: KM 15 -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-02
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang Y KM 15
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang pertemuan arus Sukajadi dan Tanah Mas, titik vital pengawasan antrean kendaraan Jalur Lintas Timur.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Simpang Sukajadi</span>
                        <button onclick="switchCamera(1)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Titik 3: Simpang Air Batu -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-03
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang Air Batu
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang perlintasan angkutan logistik industri dan jalur alternatif menuju Pelabuhan Tanjung Api-Api.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Simpang Air Batu</span>
                        <button onclick="switchCamera(2)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Titik 4: Sembawa -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-04
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Kawasan Sembawa
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Sembawa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Kawasan pusat penelitian pertanian dan pemukiman dengan kepadatan lalu lintas lintas timur Sumatera.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Jalintim KM 29</span>
                        <button onclick="switchCamera(3)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Titik 5: Pasar Pangkalan Balai -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-05
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Pasar Pangkalan Balai
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Banyuasin III
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Jantung pusat pemerintahan dan perekonomian ibukota Kabupaten Banyuasin, kawasan pasar dan perkantoran.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Kota Pangkalan Balai</span>
                        <button onclick="switchCamera(4)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Titik 6: Tugu Betung -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-06
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang Tugu Betung
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Betung
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang segitiga perlintasan utama Sumatera: jalur menuju Provinsi Jambi dan jalur tengah ke Musi Banyuasin.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-road me-1 text-amber-500"></i> Simpang Betung</span>
                        <button onclick="switchCamera(5)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Titik 7: Desa Gasing -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-07
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Desa Gasing
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Talang Kelapa
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Pusat pergudangan dan aktivitas industri manufaktur di sepanjang kawasan perairan sungai Banyuasin.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-industry me-1 text-amber-500"></i> Kawasan Industri</span>
                        <button onclick="switchCamera(6)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Titik 8: Sungai Pinang -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 font-mono">
                                CAM-08
                            </span>
                            <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Live 24 Jam
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            Simpang 3 Sungai Pinang
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            Kecamatan Rambutan
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Simpang perlintasan menuju wilayah Rambutan dan perbatasan kawasan OPI Mall / Jakabaring Palembang Selatan.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400 font-semibold"><i class="fa-solid fa-signs-post me-1 text-amber-500"></i> Jalur Rambutan</span>
                        <button onclick="switchCamera(7)" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau di Layar <i class="fa-solid fa-play text-[9px]"></i>
                        </button>
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

@push('scripts')
<script>
    // 8 Strategic Cameras Dataset
    const cameras = [
        {
            id: 'CAM 01',
            badge: 'CAM-01',
            title: 'Gerbang KM 12 - Talang Kelapa',
            road: '[Jalintim KM 12 - Perbatasan]',
            hudId: 'CAM 01 // KM 12',
            hudLocation: 'GERBANG PERBATASAN TALANG KELAPA',
            coordinates: 'KOORDINAT: -2.9381° S, 104.6812° E',
            status: 'ARUS LANCAR TERKENDALI',
            speed: 'Kecepatan: ~45-60 km/j',
            weather: 'Cuaca: Cerah / Kering',
            image: "{{ asset('images/cctv/cam_km12.jpg') }}"
        },
        {
            id: 'CAM 02',
            badge: 'CAM-02',
            title: 'Simpang Y KM 15 - Sukajadi',
            road: '[Jalintim KM 15 - Simpang Sukajadi]',
            hudId: 'CAM 02 // KM 15',
            hudLocation: 'SIMPANG Y SUKAJADI - TANAH MAS',
            coordinates: 'KOORDINAT: -2.9124° S, 104.6531° E',
            status: 'RAMAI LANCAR TERATUR',
            speed: 'Kecepatan: ~35-50 km/j',
            weather: 'Cuaca: Cerah Berawan',
            image: "{{ asset('images/cctv/cam_simpang_y.jpg') }}"
        },
        {
            id: 'CAM 03',
            badge: 'CAM-03',
            title: 'Simpang Air Batu - Logistik',
            road: '[Akses Jalintim - Tj. Api-Api]',
            hudId: 'CAM 03 // AIR BATU',
            hudLocation: 'SIMPANG PERLINTASAN ANGKUTAN LOGISTIK',
            coordinates: 'KOORDINAT: -2.8710° S, 104.5982° E',
            status: 'ARUS LOGISTIK TERKENDALI',
            speed: 'Kecepatan: ~40-55 km/j',
            weather: 'Cuaca: Cerah Terik',
            image: "{{ asset('images/cctv/cam_sembawa.jpg') }}"
        },
        {
            id: 'CAM 04',
            badge: 'CAM-04',
            title: 'Kawasan Sembawa - KM 29',
            road: '[Jalintim KM 29 - Sembawa]',
            hudId: 'CAM 04 // SEMBAWA KM 29',
            hudLocation: 'KAWASAN BALAI PENELITIAN SEMBAWA',
            coordinates: 'KOORDINAT: -2.8345° S, 104.5420° E',
            status: 'LALU LINTAS TERBUKA & LANCAR',
            speed: 'Kecepatan: ~50-70 km/j',
            weather: 'Cuaca: Cerah / Kering',
            image: "{{ asset('images/cctv/cam_sembawa.jpg') }}"
        },
        {
            id: 'CAM 05',
            badge: 'CAM-05',
            title: 'Pasar Pangkalan Balai - Kota',
            road: '[Pusat Ibukota Banyuasin III]',
            hudId: 'CAM 05 // PANGKALAN BALAI',
            hudLocation: 'JANTUNG PERKOTAAN & PASAR UTAMA',
            coordinates: 'KOORDINAT: -2.7842° S, 104.4756° E',
            status: 'AKTIVITAS KOTA RAMAI TERATUR',
            speed: 'Kecepatan: ~25-40 km/j',
            weather: 'Cuaca: Berawan',
            image: "{{ asset('images/cctv/cam_pangkalan_balai.jpg') }}"
        },
        {
            id: 'CAM 06',
            badge: 'CAM-06',
            title: 'Simpang Tugu Betung - Persimpangan',
            road: '[Jalintim Segitiga Jambi - Sekayu]',
            hudId: 'CAM 06 // TUGU BETUNG',
            hudLocation: 'SIMPANG PERSIMPANGAN UTAMA SUMATERA',
            coordinates: 'KOORDINAT: -2.7150° S, 104.3810° E',
            status: 'KENDARAAN BERAT LANCAR',
            speed: 'Kecepatan: ~30-45 km/j',
            weather: 'Cuaca: Cerah Berangin',
            image: "{{ asset('images/cctv/cam_betung.jpg') }}"
        },
        {
            id: 'CAM 07',
            badge: 'CAM-07',
            title: 'Desa Gasing - Kawasan Industri',
            road: '[Jalur Industri Talang Kelapa]',
            hudId: 'CAM 07 // GASING INDUSTRI',
            hudLocation: 'PERGUDANGAN & PERAIRAN SUNGAI BANYUASIN',
            coordinates: 'KOORDINAT: -2.8872° S, 104.7215° E',
            status: 'ARUS ANGKUTAN INDUSTRI NORMAL',
            speed: 'Kecepatan: ~35-50 km/j',
            weather: 'Cuaca: Cerah',
            image: "{{ asset('images/cctv/cam_simpang_y.jpg') }}"
        },
        {
            id: 'CAM 08',
            badge: 'CAM-08',
            title: 'Simpang 3 Sungai Pinang - Rambutan',
            road: '[Perbatasan OPI Mall Jakabaring]',
            hudId: 'CAM 08 // SG. PINANG',
            hudLocation: 'SIMPANG RAMBUTAN - JAKABARING SELATAN',
            coordinates: 'KOORDINAT: -3.0315° S, 104.7890° E',
            status: 'LALU LINTAS SUBURBAN LANCAR',
            speed: 'Kecepatan: ~40-55 km/j',
            weather: 'Cuaca: Cerah Lembab',
            image: "{{ asset('images/cctv/cam_km12.jpg') }}"
        }
    ];

    let activeCamIndex = 0;
    let isNightVision = false;
    let zoomLevel = 1.0;

    // Real-time Digital Clock in WIB
    function updateClock() {
        const now = new Date();
        const y = now.getFullYear();
        const m = String(now.getMonth() + 1).padStart(2, '0');
        const d = String(now.getDate()).padStart(2, '0');
        const hh = String(now.getHours()).padStart(2, '0');
        const mm = String(now.getMinutes()).padStart(2, '0');
        const ss = String(now.getSeconds()).padStart(2, '0');
        
        const timeStr = `${hh}:${mm}:${ss} WIB`;
        const fullStamp = `${y}-${m}-${d} ${timeStr}`;

        const clockEl = document.getElementById('live-cctv-clock');
        const hudStampEl = document.getElementById('hud-timestamp');
        if (clockEl) clockEl.textContent = timeStr;
        if (hudStampEl) hudStampEl.textContent = fullStamp;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Switch active camera smoothly
    function switchCamera(index) {
        if (index < 0 || index >= cameras.length) return;
        activeCamIndex = index;
        const cam = cameras[index];

        // Ensure we are in multi-cam view mode
        setMonitorMode('multi');

        // Update image with smooth crossfade
        const img = document.getElementById('cctv-display-img');
        if (img) {
            img.style.opacity = '0.3';
            setTimeout(() => {
                img.src = cam.image;
                img.style.opacity = '1';
            }, 120);
        }

        // Update top bar labels
        document.getElementById('active-cam-badge').textContent = cam.badge;
        document.getElementById('active-cam-title').textContent = cam.title;
        document.getElementById('active-cam-road').textContent = cam.road;

        // Update HUD overlays
        document.getElementById('hud-cam-id').textContent = cam.hudId;
        document.getElementById('hud-location-name').textContent = cam.hudLocation;
        document.getElementById('hud-coordinates').textContent = cam.coordinates;
        document.getElementById('telemetry-status-text').textContent = cam.status;
        document.getElementById('telemetry-speed').textContent = cam.speed;
        document.getElementById('telemetry-weather').textContent = cam.weather;

        // Update active class on selector cards
        document.querySelectorAll('.cam-card').forEach((el, i) => {
            if (i === index) {
                el.classList.add('cam-card-active');
                el.querySelector('.font-extrabold').classList.remove('text-slate-300');
                el.querySelector('.font-extrabold').classList.add('text-amber-400');
            } else {
                el.classList.remove('cam-card-active');
                el.querySelector('.font-extrabold').classList.add('text-slate-300');
                el.querySelector('.font-extrabold').classList.remove('text-amber-400');
            }
        });

        // Smooth scroll to monitor station
        const monitor = document.getElementById('cctv-monitor-station');
        if (monitor) {
            monitor.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Set Monitor Mode (multi or bridge)
    function setMonitorMode(mode) {
        const viewMulti = document.getElementById('view-multi-cam');
        const viewBridge = document.getElementById('view-bridge-frame');
        const btnMulti = document.getElementById('tab-btn-multi');
        const btnBridge = document.getElementById('tab-btn-bridge');

        if (mode === 'bridge') {
            viewMulti.classList.add('hidden');
            viewBridge.classList.remove('hidden');
            
            btnBridge.className = 'px-3 py-1.5 rounded-lg font-bold transition-all bg-amber-400 text-slate-950 flex items-center gap-1.5 shadow-sm';
            btnMulti.className = 'px-3 py-1.5 rounded-lg font-bold transition-all text-slate-300 hover:text-white flex items-center gap-1.5';
        } else {
            viewBridge.classList.add('hidden');
            viewMulti.classList.remove('hidden');

            btnMulti.className = 'px-3 py-1.5 rounded-lg font-bold transition-all bg-amber-400 text-slate-950 flex items-center gap-1.5 shadow-sm';
            btnBridge.className = 'px-3 py-1.5 rounded-lg font-bold transition-all text-slate-300 hover:text-white flex items-center gap-1.5';
        }
    }

    // Night Vision Toggle
    function toggleNightVision() {
        isNightVision = !isNightVision;
        const img = document.getElementById('cctv-display-img');
        const btn = document.getElementById('btn-night-vision');
        if (isNightVision) {
            img.classList.add('cctv-night-vision');
            btn.classList.add('text-emerald-400', 'bg-slate-800');
        } else {
            img.classList.remove('cctv-night-vision');
            btn.classList.remove('text-emerald-400', 'bg-slate-800');
        }
    }

    // Zoom Toggle (1.0x -> 1.25x -> 1.5x -> 1.0x)
    function toggleZoom() {
        const img = document.getElementById('cctv-display-img');
        const label = document.getElementById('zoom-label');
        if (zoomLevel === 1.0) {
            zoomLevel = 1.25;
        } else if (zoomLevel === 1.25) {
            zoomLevel = 1.5;
        } else {
            zoomLevel = 1.0;
        }
        img.style.transform = `scale(${zoomLevel})`;
        if (label) label.textContent = `${zoomLevel}x`;
    }

    // Refresh Feed simulation
    function refreshCurrentFeed() {
        const icon = document.getElementById('refresh-icon');
        const img = document.getElementById('cctv-display-img');
        if (icon) icon.classList.add('fa-spin');
        if (img) img.style.opacity = '0.4';

        setTimeout(() => {
            if (icon) icon.classList.remove('fa-spin');
            if (img) img.style.opacity = '1';
        }, 500);

        // Also reload bridge iframe if currently active
        const iframe = document.getElementById('diskominfo-bridge-iframe');
        if (iframe && !iframe.parentElement.classList.contains('hidden')) {
            iframe.src = iframe.src;
        }
    }

    // Fullscreen Monitor
    function toggleFullscreen() {
        const elem = document.getElementById('cctv-viewport-container');
        if (!document.fullscreenElement) {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }
</script>
@endpush
@endsection
