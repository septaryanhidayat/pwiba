@extends('layouts.public')

@section('title', 'Pantauan CCTV Banyuasin Real-Time - Layanan Publik')
@section('meta_description', 'Pusat informasi pantauan kamera CCTV arus lalu lintas dan titik strategis di Kabupaten Banyuasin secara langsung (real-time) melalui portal resmi Diskominfo Banyuasin.')

@section('content')
<!-- Header Banner Section -->
<div class="gradient-mesh text-white py-14 sm:py-16 relative overflow-hidden">
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

                <!-- Primary Action Buttons -->
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
                    <div class="text-2xl sm:text-3xl font-black text-amber-400">8 Titik</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Kamera Pengawas</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-400">24 Jam</div>
                    <div class="text-[11px] font-semibold text-slate-300 mt-0.5">Siaga Online</div>
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
<div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Official Streaming Server Portal Card -->
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
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                            Portal Resmi CCTV Diskominfo Kab. Banyuasin
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1.5 max-w-3xl leading-relaxed">
                            Siaran langsung video kamera pemantau lalu lintas dikelola dan ditransmisikan secara terpusat oleh Dinas Komunikasi, Informatika, Statistik dan Persandian (Diskominfo) Pemerintah Kabupaten Banyuasin.
                        </p>
                    </div>
                </div>

                <div class="shrink-0 w-full lg:w-auto flex flex-col sm:flex-row items-center gap-3">
                    <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto px-7 py-4 rounded-xl font-black text-xs sm:text-sm text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-xl shadow-amber-400/30 transition-all flex items-center justify-center gap-2.5 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-play"></i>
                        <span>Akses Siaran Langsung CCTV</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
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
                        Sebaran kamera pemantau arus lalu lintas di titik rawan kepadatan dan gerbang perbatasan
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
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Titik 2: KM 15 -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Titik 3: Simpang Air Batu -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Titik 4: Sembawa -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Titik 5: Pasar Pangkalan Balai -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Titik 6: Tugu Betung -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Titik 7: Desa Gasing -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Titik 8: Sungai Pinang -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg transition-all duration-200 flex flex-col justify-between group hover:-translate-y-1">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
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
                        <a href="https://cctv.banyuasinkab.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 font-bold hover:underline flex items-center gap-1">
                            Pantau <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
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
@endsection
