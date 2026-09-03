{{-- Component Bagan Struktur Organisasi Visual Sesuai Kaidah & Referensi Standar --}}
<div x-data="{
    zoomLevel: 100,
    isFullscreen: false,
    isExporting: false,
    zoomIn() { if (this.zoomLevel < 150) this.zoomLevel += 10; },
    zoomOut() { if (this.zoomLevel > 60) this.zoomLevel -= 10; },
    resetZoom() { this.zoomLevel = 100; },
    toggleFullscreen() {
        const el = document.getElementById('org-chart-wrapper');
        if (!document.fullscreenElement) {
            el.requestFullscreen().catch(err => alert(`Error: ${err.message}`));
            this.isFullscreen = true;
        } else {
            document.exitFullscreen();
            this.isFullscreen = false;
        }
    },
    exportChartImage() {
        this.isExporting = true;
        const target = document.getElementById('org-chart-canvas');
        const prevTransform = target.style.transform;
        target.style.transform = 'none';

        const doCapture = () => {
            html2canvas(target, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                windowWidth: target.scrollWidth,
                windowHeight: target.scrollHeight,
            }).then(canvas => {
                target.style.transform = prevTransform;
                this.isExporting = false;
                const link = document.createElement('a');
                link.download = 'bagan-struktur-organisasi-pwi-banyuasin-2025-2028.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bagan Berhasil Diunduh!',
                        text: 'File gambar bagan struktur organisasi telah disimpan dalam format PNG resolusi tinggi.',
                        timer: 3000,
                        showConfirmButton: false,
                    });
                }
            }).catch(err => {
                target.style.transform = prevTransform;
                this.isExporting = false;
                console.error(err);
                alert('Gagal mengekspor gambar bagan.');
            });
        };

        if (typeof html2canvas === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
            script.onload = doCapture;
            document.head.appendChild(script);
        } else {
            doCapture();
        }
    }
}" class="space-y-4" id="org-chart-root">

    <!-- Top Action Bar & Controls -->
    <div class="flex flex-wrap items-center justify-between gap-3 p-3.5 sm:p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm print:hidden">
        
        <!-- Legend / Info -->
        <div class="flex items-center gap-2.5 sm:gap-3">
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-base sm:text-lg shadow-sm border border-blue-200 dark:border-blue-900/40">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center gap-1.5 sm:gap-2">
                    <span>Bagan Alur & Hirarki Kepengurusan</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                        2025–2028
                    </span>
                </h4>
                <p class="text-[10px] sm:text-[11px] text-slate-500 dark:text-slate-400">Kaidah resmi: Garis Komando Pimpinan, Staf Harian, dan Bidang Kerja</p>
            </div>
        </div>

        <!-- Interactive Tools (Zoom, Download, Print, Fullscreen) -->
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <!-- Zoom Controls -->
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-0.5 sm:p-1 rounded-xl border border-slate-200 dark:border-slate-700">
                <button type="button" @click="zoomOut()" aria-label="Perkecil (-)" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all" title="Perkecil (-)">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="px-1.5 sm:px-2 text-[10px] sm:text-xs font-bold text-slate-700 dark:text-slate-300 min-w-[2.8rem] sm:min-w-[3.2rem] text-center" x-text="zoomLevel + '%'">100%</span>
                <button type="button" @click="zoomIn()" aria-label="Perbesar (+)" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all" title="Perbesar (+)">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button type="button" @click="resetZoom()" aria-label="Reset Zoom" class="px-2 py-1 rounded-lg text-[9px] sm:text-[10px] font-bold text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700 transition-all" title="Reset Ukuran (Pas di Layar)">
                    Reset
                </button>
            </div>

            <!-- Fullscreen Button -->
            <button type="button" @click="toggleFullscreen()" aria-label="Layar Penuh" class="h-8 sm:h-9 px-2.5 sm:px-3 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 transition-all" title="Layar Penuh">
                <i class="fa-solid fa-expand"></i>
                <span class="hidden md:inline">Layar Penuh</span>
            </button>

            <!-- Export Image Button -->
            <button type="button" @click="exportChartImage()" :disabled="isExporting" aria-label="Unduh Gambar PNG" class="h-8 sm:h-9 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all cursor-pointer disabled:opacity-50">
                <i class="fa-solid fa-download" :class="isExporting ? 'fa-bounce' : ''"></i>
                <span x-text="isExporting ? 'Memproses...' : 'Unduh PNG'">Unduh PNG</span>
            </button>

            <!-- Print Button -->
            <button type="button" onclick="window.print()" aria-label="Cetak Bagan" class="h-8 sm:h-9 px-2.5 sm:px-3 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 transition-all">
                <i class="fa-solid fa-print"></i>
                <span class="hidden md:inline">Cetak</span>
            </button>
        </div>
    </div>

    <!-- Chart Canvas Container (Fluid, Auto-Fitting, Responsive) -->
    <div id="org-chart-wrapper" class="relative w-full overflow-x-auto rounded-3xl bg-slate-100/60 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 shadow-inner p-2 sm:p-5 lg:p-6 transition-all">
        
        <!-- The Printable & Exportable Canvas (Fitted to Screen Width) -->
        <div id="org-chart-canvas" 
             :style="'transform: scale(' + (zoomLevel / 100) + '); transform-origin: top center; transition: transform 0.2s ease-out;'"
             class="w-full max-w-5xl mx-auto p-4 sm:p-7 rounded-2xl sm:rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg space-y-6"
             style="background-image: radial-gradient(rgba(100, 116, 139, 0.12) 1px, transparent 1px); background-size: 20px 20px;">
            
            <!-- Bagan Header Title (Sesuai Format Resmi) -->
            <div class="text-center pb-4 border-b border-slate-200 dark:border-slate-800">
                <h2 class="text-base sm:text-xl md:text-2xl font-black text-[#0B132B] dark:text-white uppercase tracking-wide leading-tight">
                    STRUKTUR ORGANISASI PWI KABUPATEN BANYUASIN
                </h2>
                <p class="text-xs sm:text-sm font-extrabold text-blue-700 dark:text-blue-400 mt-1">
                    (PERSATUAN WARTAWAN INDONESIA KABUPATEN BANYUASIN)
                </p>
                <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">
                    MASA BHAKTI 2025–2028 • BUMI SEDULANG SETUDUNG
                </p>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 1: KETUA (PIMPINAN PUNCAK)                    -->
            <!-- ==================================================== -->
            @if($tree['ketua'])
                <div class="flex flex-col items-center">
                    <!-- Ketua Capsule Card (Sesuai Referensi Gambar) -->
                    <div class="w-64 sm:w-72 rounded-2xl bg-white dark:bg-slate-800 border-2 border-blue-600 dark:border-blue-500 shadow-lg shadow-blue-500/15 overflow-hidden transition-all hover:-translate-y-0.5 hover:shadow-xl group">
                        <!-- Header Capsule -->
                        <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-sky-500 text-white px-3 py-1.5 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-white text-blue-700 shadow-sm flex items-center justify-center font-black text-xs flex-shrink-0 overflow-hidden ring-2 ring-white/50">
                                @if($tree['ketua']->foto)
                                    <img src="{{ $tree['ketua']->foto_url }}" alt="{{ $tree['ketua']->nama }}" width="32" height="32" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-crown text-[11px]"></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-grow">
                                <span class="block text-[11px] sm:text-xs font-black uppercase tracking-wider leading-none">
                                    {{ $tree['ketua']->jabatan }}
                                </span>
                            </div>
                        </div>
                        <!-- Body -->
                        <div class="px-3 py-2 text-center bg-white dark:bg-slate-800">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white truncate">
                                {{ $tree['ketua']->nama }}
                            </h3>
                            <div class="flex items-center justify-center gap-1.5 mt-0.5 text-[10px] text-slate-500 dark:text-slate-400 font-medium">
                                <span>KTA: {{ $tree['ketua']->nomor_kartu ?? '-' }}</span>
                                <span>•</span>
                                <span class="font-bold text-blue-600 dark:text-blue-400">{{ $tree['ketua']->tingkat_ukw ?? 'Utama' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Vertical Line Connector from Ketua down -->
                    <div class="w-0.5 h-6 bg-blue-600 dark:bg-blue-400"></div>
                </div>
            @endif

            <!-- ==================================================== -->
            <!-- LEVEL 2: WAKIL KETUA (1, 2, 3) - BERJEJER HORIZONTAL  -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Horizontal Bus connecting Wakil Ketua 1, 2, 3 -->
                <div class="w-3/4 max-w-2xl h-0.5 bg-blue-600 dark:bg-blue-400"></div>

                <!-- 3 Columns for Wakil Ketua -->
                <div class="w-full max-w-3xl grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 pt-0">
                    @php
                        $wkColors = [
                            0 => ['bg' => 'from-rose-600 to-red-600', 'border' => 'border-rose-500', 'icon' => 'fa-star', 'icon_bg' => 'text-rose-600', 'label' => 'WAKIL KETUA 1'],
                            1 => ['bg' => 'from-sky-600 to-blue-600', 'border' => 'border-sky-500', 'icon' => 'fa-star', 'icon_bg' => 'text-sky-600', 'label' => 'WAKIL KETUA 2'],
                            2 => ['bg' => 'from-amber-500 to-amber-600', 'border' => 'border-amber-500', 'icon' => 'fa-star', 'icon_bg' => 'text-amber-600', 'label' => 'WAKIL KETUA 3'],
                        ];
                    @endphp

                    @foreach($tree['wakil_ketua'] as $idx => $wk)
                        @php $cfg = $wkColors[$idx] ?? $wkColors[0]; @endphp
                        <div class="flex flex-col items-center">
                            <!-- Drop stem to each Wakil Ketua -->
                            <div class="w-0.5 h-4 bg-blue-600 dark:bg-blue-400"></div>

                            <!-- Wakil Ketua Capsule Card -->
                            <div class="w-full max-w-[230px] rounded-xl bg-white dark:bg-slate-800 border {{ $cfg['border'] }} shadow-md overflow-hidden transition-all hover:-translate-y-0.5">
                                <div class="bg-gradient-to-r {{ $cfg['bg'] }} text-white px-2.5 py-1.5 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-white {{ $cfg['icon_bg'] }} shadow-sm flex items-center justify-center font-bold text-[10px] flex-shrink-0 overflow-hidden">
                                        @if($wk->foto)
                                            <img src="{{ $wk->foto_url }}" alt="{{ $wk->nama }}" width="28" height="28" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid {{ $cfg['icon'] }}"></i>
                                        @endif
                                    </div>
                                    <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-wide truncate">
                                        {{ $cfg['label'] }}
                                    </span>
                                </div>
                                <div class="px-2.5 py-1.5 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" title="{{ $wk->nama }}">
                                        {{ $wk->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-0.5 truncate">
                                        {{ $wk->tingkat_ukw ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Central Spine continuing down from Wakil Ketua row -->
                <div class="w-0.5 h-6 bg-blue-600 dark:bg-blue-400 mt-2"></div>
                <div class="w-4 h-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[8px] -mt-1 shadow-sm">
                    <i class="fa-solid fa-arrow-down"></i>
                </div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 3: SEKRETARIAT & KEBENDAHARAAN (KIRI & KANAN)  -->
            <!-- (Dengan Garis Koordinasi Horizontal Sesuai Referensi)-->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Two Parallel Stacks: Left (Sekretariat) & Right (Kebendaharaan) -->
                <div class="w-full max-w-2xl grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-8 relative">
                    
                    <!-- KIRI: SEKRETARIAT -->
                    <div class="flex flex-col items-center space-y-3">
                        <!-- 1. SEKRETARIS -->
                        @if($tree['sekretariat']['utama'])
                            @php $sec = $tree['sekretariat']['utama']; @endphp
                            <div class="w-full max-w-[240px] rounded-xl bg-white dark:bg-slate-800 border border-purple-500 shadow-md overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-700 to-indigo-600 text-white px-2.5 py-1.5 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-white text-purple-700 shadow-sm flex items-center justify-center text-[10px] font-bold flex-shrink-0 overflow-hidden">
                                        @if($sec->foto)
                                            <img src="{{ $sec->foto_url }}" alt="{{ $sec->nama }}" width="28" height="28" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-pen-nib"></i>
                                        @endif
                                    </div>
                                    <span class="text-[11px] font-black uppercase tracking-wide truncate">
                                        {{ $sec->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2.5 py-1.5 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                        {{ $sec->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-0.5">
                                        {{ $sec->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Vertical line to Wakil Sekretaris -->
                        <div class="w-0.5 h-3 bg-purple-500"></div>

                        <!-- 2. WAKIL SEKRETARIS -->
                        @if($tree['sekretariat']['wakil'])
                            @php $wsec = $tree['sekretariat']['wakil']; @endphp
                            <div class="w-full max-w-[240px] rounded-xl bg-white dark:bg-slate-800 border border-sky-500 shadow-md overflow-hidden">
                                <div class="bg-gradient-to-r from-sky-600 to-cyan-600 text-white px-2.5 py-1.5 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-white text-sky-600 shadow-sm flex items-center justify-center text-[10px] font-bold flex-shrink-0 overflow-hidden">
                                        @if($wsec->foto)
                                            <img src="{{ $wsec->foto_url }}" alt="{{ $wsec->nama }}" width="28" height="28" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-file-lines"></i>
                                        @endif
                                    </div>
                                    <span class="text-[11px] font-black uppercase tracking-wide truncate">
                                        {{ $wsec->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2.5 py-1.5 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                        {{ $wsec->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-0.5">
                                        {{ $wsec->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- KANAN: KEBENDAHARAAN -->
                    <div class="flex flex-col items-center space-y-3">
                        <!-- 1. BENDAHARA -->
                        @if($tree['kebendaharaan']['utama'])
                            @php $ben = $tree['kebendaharaan']['utama']; @endphp
                            <div class="w-full max-w-[240px] rounded-xl bg-white dark:bg-slate-800 border border-amber-500 shadow-md overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white px-2.5 py-1.5 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-white text-amber-600 shadow-sm flex items-center justify-center text-[10px] font-bold flex-shrink-0 overflow-hidden">
                                        @if($ben->foto)
                                            <img src="{{ $ben->foto_url }}" alt="{{ $ben->nama }}" width="28" height="28" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-coins"></i>
                                        @endif
                                    </div>
                                    <span class="text-[11px] font-black uppercase tracking-wide truncate">
                                        {{ $ben->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2.5 py-1.5 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                        {{ $ben->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-0.5">
                                        {{ $ben->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Vertical line to Wakil Bendahara -->
                        <div class="w-0.5 h-3 bg-amber-500"></div>

                        <!-- 2. WAKIL BENDAHARA -->
                        @if($tree['kebendaharaan']['wakil'])
                            @php $wben = $tree['kebendaharaan']['wakil']; @endphp
                            <div class="w-full max-w-[240px] rounded-xl bg-white dark:bg-slate-800 border border-emerald-500 shadow-md overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-2.5 py-1.5 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-white text-emerald-600 shadow-sm flex items-center justify-center text-[10px] font-bold flex-shrink-0 overflow-hidden">
                                        @if($wben->foto)
                                            <img src="{{ $wben->foto_url }}" alt="{{ $wben->nama }}" width="28" height="28" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-receipt"></i>
                                        @endif
                                    </div>
                                    <span class="text-[11px] font-black uppercase tracking-wide truncate">
                                        {{ $wben->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2.5 py-1.5 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                        {{ $wben->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-0.5">
                                        {{ $wben->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Garis Koordinasi Horizontal Antara Sekretaris <---> Bendahara (Hidden on Mobile) -->
                    <div class="hidden sm:flex absolute top-5 left-1/2 -translate-x-1/2 items-center justify-center gap-1 z-10">
                        <span class="text-blue-500 text-xs"><i class="fa-solid fa-arrow-left"></i></span>
                        <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-800 whitespace-nowrap shadow-xs">
                            Koordinasi
                        </span>
                        <span class="text-blue-500 text-xs"><i class="fa-solid fa-arrow-right"></i></span>
                    </div>

                    <!-- Garis Koordinasi Horizontal Antara Wakil Sekretaris <---> Wakil Bendahara -->
                    <div class="hidden sm:flex absolute bottom-5 left-1/2 -translate-x-1/2 items-center justify-center gap-1 z-10">
                        <span class="text-blue-500 text-xs"><i class="fa-solid fa-arrow-left"></i></span>
                        <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-800 whitespace-nowrap shadow-xs">
                            Koordinasi
                        </span>
                        <span class="text-blue-500 text-xs"><i class="fa-solid fa-arrow-right"></i></span>
                    </div>

                </div>

                <!-- Central Spine continuing down to Bidang-Bidang -->
                <div class="w-0.5 h-8 bg-blue-600 dark:bg-blue-400 mt-3"></div>
                <div class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[9px] -mt-2 shadow-sm">
                    <i class="fa-solid fa-arrow-down"></i>
                </div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 4: BIDANG-BIDANG KERJA (DIVISI OPERASIONAL)    -->
            <!-- (Sesuai Referensi: Header -> Kabid -> Wakabid -> Anggota)-->
            <!-- ==================================================== -->
            <div class="space-y-4 pt-2">
                <!-- Section Separator Banner -->
                <div class="text-center">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] sm:text-xs font-black uppercase tracking-wider bg-blue-600 text-white shadow-sm">
                        <i class="fa-solid fa-diagram-project"></i>
                        <span>JAJARAN BIDANG KERJA OPERASIONAL</span>
                    </span>
                </div>

                <!-- Responsive Grid for the 7 Bidang (Fitted, No Horizontal Scroll Needed) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    @php
                        $bidangStyles = [
                            'pembelaan' => ['grad' => 'from-indigo-700 to-blue-700', 'border' => 'border-indigo-400', 'icon_color' => 'text-indigo-700'],
                            'organisasi' => ['grad' => 'from-blue-700 to-sky-600', 'border' => 'border-blue-400', 'icon_color' => 'text-blue-700'],
                            'pendidikan' => ['grad' => 'from-emerald-700 to-teal-600', 'border' => 'border-emerald-400', 'icon_color' => 'text-emerald-700'],
                            'publikasi' => ['grad' => 'from-cyan-700 to-blue-600', 'border' => 'border-cyan-400', 'icon_color' => 'text-cyan-700'],
                            'kesejahteraan' => ['grad' => 'from-amber-600 to-yellow-600', 'border' => 'border-amber-400', 'icon_color' => 'text-amber-700'],
                            'siwo' => ['grad' => 'from-rose-700 to-red-600', 'border' => 'border-rose-400', 'icon_color' => 'text-rose-700'],
                            'kemasyarakatan' => ['grad' => 'from-teal-700 to-emerald-600', 'border' => 'border-teal-400', 'icon_color' => 'text-teal-700'],
                        ];
                    @endphp

                    @foreach($tree['bidangs'] as $bKey => $b)
                        @php $st = $bidangStyles[$bKey] ?? $bidangStyles['pembelaan']; @endphp
                        <div class="flex flex-col items-center bg-slate-50/70 dark:bg-slate-800/40 p-2.5 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-2">
                            
                            <!-- 1. Header Bidang Capsule -->
                            <div class="w-full rounded-xl bg-gradient-to-r {{ $st['grad'] }} text-white p-2 shadow-sm flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-white {{ $st['icon_color'] }} shadow-xs flex items-center justify-center text-[10px] font-bold flex-shrink-0">
                                    <i class="fa-solid {{ $b['info']['icon'] }}"></i>
                                </div>
                                <div class="min-w-0 flex-grow">
                                    <span class="block text-[9px] font-extrabold uppercase tracking-widest text-white/80">
                                        BIDANG {{ $b['info']['code'] ?? '' }}
                                    </span>
                                    <h5 class="text-[11px] font-black uppercase text-white truncate leading-tight">
                                        {{ $b['info']['title'] }}
                                    </h5>
                                </div>
                            </div>

                            <!-- Down Arrow Connector -->
                            <div class="w-0.5 h-2.5 bg-slate-300 dark:bg-slate-700 -my-1"></div>
                            <i class="fa-solid fa-caret-down text-slate-400 dark:text-slate-600 text-[10px]"></i>

                            <!-- 2. KEPALA BIDANG -->
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 p-2 shadow-xs text-center">
                                <span class="block text-[9px] font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    KEPALA BIDANG
                                </span>
                                <h6 class="text-xs font-black text-slate-900 dark:text-white mt-0.5 truncate">
                                    {{ $b['kabid']?->nama ?? 'Belum Ditunjuk' }}
                                </h6>
                            </div>

                            <!-- Down Arrow Connector -->
                            <div class="w-0.5 h-2.5 bg-slate-300 dark:bg-slate-700 -my-1"></div>
                            <i class="fa-solid fa-caret-down text-slate-400 dark:text-slate-600 text-[10px]"></i>

                            <!-- 3. WAKIL KEPALA BIDANG -->
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 p-2 shadow-xs text-center">
                                <span class="block text-[9px] font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    WAKIL KEPALA BIDANG
                                </span>
                                <h6 class="text-xs font-black text-slate-900 dark:text-white mt-0.5 truncate">
                                    {{ $b['wakabid']?->nama ?? 'Belum Ditunjuk' }}
                                </h6>
                            </div>

                            <!-- Down Arrow Connector -->
                            <div class="w-0.5 h-2.5 bg-slate-300 dark:bg-slate-700 -my-1"></div>
                            <i class="fa-solid fa-caret-down text-slate-400 dark:text-slate-600 text-[10px]"></i>

                            <!-- 4. ANGGOTA BIDANG -->
                            <div class="w-full rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 overflow-hidden text-center shadow-xs">
                                <div class="bg-blue-600 text-white text-[9px] font-black uppercase py-0.5 tracking-wider">
                                    ANGGOTA
                                </div>
                                <div class="p-1.5 space-y-1">
                                    @forelse($b['anggota'] as $ang)
                                        <p class="text-[11px] font-bold text-slate-800 dark:text-slate-200 truncate" title="{{ $ang->nama }}">
                                            {{ $ang->nama }}
                                        </p>
                                    @empty
                                        <p class="text-[10px] text-slate-400 italic">
                                            -
                                        </p>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- ==================================================== -->
                <!-- LEVEL 5: ANGGOTA PELAKSANA / PENDUKUNG               -->
                <!-- ==================================================== -->
                @if(count($tree['anggota_umum']) > 0)
                    <div class="pt-3 flex flex-col items-center">
                        <div class="w-0.5 h-4 bg-slate-300 dark:bg-slate-700"></div>
                        <div class="w-full max-w-xl rounded-2xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 p-3 shadow-sm text-center">
                            <span class="inline-block px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 mb-2">
                                <i class="fa-solid fa-users text-blue-600"></i> Anggota Pelaksana Tambahan
                            </span>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                @foreach($tree['anggota_umum'] as $au)
                                    <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-center">
                                        <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $au->nama }}</p>
                                        <span class="text-[9px] text-slate-500 dark:text-slate-400 font-mono">{{ $au->nomor_kartu ?? '-' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Footer SK & Legalitas Resmi -->
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                <span>Ditetapkan di Pangkalan Balai • Surat Keputusan PWI Banyuasin 2025–2028</span>
                <span class="mt-1 sm:mt-0 font-semibold text-slate-600 dark:text-slate-400">Portal Resmi: pwiba.or.id</span>
            </div>

        </div>

    </div>

</div>
