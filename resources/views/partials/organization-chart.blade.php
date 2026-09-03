{{-- Component Bagan Struktur Organisasi Visual Landscape Tanpa Foto --}}
<div x-data="{
    zoomLevel: 100,
    isFullscreen: false,
    isExporting: false,
    zoomIn() { if (this.zoomLevel < 140) this.zoomLevel += 10; },
    zoomOut() { if (this.zoomLevel > 50) this.zoomLevel -= 10; },
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
                scale: 2.5,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                windowWidth: target.scrollWidth,
                windowHeight: target.scrollHeight,
            }).then(canvas => {
                target.style.transform = prevTransform;
                this.isExporting = false;
                const link = document.createElement('a');
                link.download = 'bagan-struktur-organisasi-pwi-banyuasin-landscape.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bagan Berhasil Diunduh!',
                        text: 'File gambar bagan landscape resolusi tinggi telah disimpan dalam format PNG.',
                        timer: 2500,
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
}" class="space-y-3" id="org-chart-root">

    <style>
        @media print {
            @page {
                size: landscape;
                margin: 6mm;
            }
            body {
                background: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .print\:hidden {
                display: none !important;
            }
            #org-chart-wrapper {
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
                overflow: visible !important;
                box-shadow: none !important;
            }
            #org-chart-canvas {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 4mm !important;
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                transform: none !important;
            }
        }
    </style>

    <!-- Top Action Bar & Controls -->
    <div class="flex flex-wrap items-center justify-between gap-2.5 p-3 sm:p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm print:hidden">
        
        <!-- Legend / Info -->
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm sm:text-base shadow-sm border border-blue-200 dark:border-blue-900/40">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-black text-[#0B132B] dark:text-white flex items-center gap-1.5">
                    <span>Bagan Alur & Hirarki Kepengurusan</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                        Format Landscape
                    </span>
                </h4>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Bagan resmi: Kompak, proporsional, dan siap cetak tanpa terpotong</p>
            </div>
        </div>

        <!-- Interactive Tools (Zoom, Download, Print, Fullscreen) -->
        <div class="flex flex-wrap items-center gap-1.5">
            <!-- Zoom Controls -->
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-0.5 rounded-xl border border-slate-200 dark:border-slate-700">
                <button type="button" @click="zoomOut()" aria-label="Perkecil (-)" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all" title="Perkecil (-)">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="px-2 text-[10px] sm:text-xs font-bold text-slate-700 dark:text-slate-300 min-w-[2.8rem] text-center" x-text="zoomLevel + '%'">100%</span>
                <button type="button" @click="zoomIn()" aria-label="Perbesar (+)" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all" title="Perbesar (+)">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button type="button" @click="resetZoom()" aria-label="Reset Zoom" class="px-2 py-1 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700 transition-all" title="Reset Ukuran (Pas di Layar)">
                    Reset
                </button>
            </div>

            <!-- Fullscreen Button -->
            <button type="button" @click="toggleFullscreen()" aria-label="Layar Penuh" class="h-8 px-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 transition-all" title="Layar Penuh">
                <i class="fa-solid fa-expand"></i>
                <span class="hidden md:inline">Layar Penuh</span>
            </button>

            <!-- Export Image Button -->
            <button type="button" @click="exportChartImage()" :disabled="isExporting" aria-label="Unduh Gambar PNG Landscape" class="h-8 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all cursor-pointer disabled:opacity-50">
                <i class="fa-solid fa-download" :class="isExporting ? 'fa-bounce' : ''"></i>
                <span x-text="isExporting ? 'Memproses...' : 'Unduh PNG'">Unduh PNG</span>
            </button>

            <!-- Print Button -->
            <button type="button" onclick="window.print()" aria-label="Cetak Bagan" class="h-8 px-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 transition-all">
                <i class="fa-solid fa-print"></i>
                <span class="hidden md:inline">Cetak</span>
            </button>
        </div>
    </div>

    <!-- Chart Canvas Container (Landscape Scroll Wrapper) -->
    <div id="org-chart-wrapper" class="relative w-full overflow-x-auto rounded-3xl bg-slate-100/60 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 shadow-inner p-2 sm:p-4 transition-all">
        
        <!-- The Printable & Exportable Canvas (Landscape Width ~1100px) -->
        <div id="org-chart-canvas" 
             :style="'transform: scale(' + (zoomLevel / 100) + '); transform-origin: top center; transition: transform 0.2s ease-out;'"
             class="w-[1120px] mx-auto p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md space-y-4"
             style="background-image: radial-gradient(rgba(100, 116, 139, 0.1) 1px, transparent 1px); background-size: 16px 16px;">
            
            <!-- Bagan Header Title (Landscape Style) -->
            <div class="text-center pb-3 border-b border-slate-200 dark:border-slate-800">
                <h2 class="text-base sm:text-lg font-black text-[#0B132B] dark:text-white uppercase tracking-wider leading-tight">
                    STRUKTUR ORGANISASI PERSATUAN WARTAWAN INDONESIA (PWI)
                </h2>
                <div class="flex items-center justify-center gap-2 mt-0.5">
                    <span class="text-xs sm:text-sm font-extrabold text-blue-700 dark:text-blue-400">
                        KABUPATEN BANYUASIN
                    </span>
                    <span class="text-slate-300 dark:text-slate-700">•</span>
                    <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300">
                        MASA BHAKTI 2025–2028
                    </span>
                </div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 1: KETUA (PIMPINAN PUNCAK)                    -->
            <!-- ==================================================== -->
            @if($tree['ketua'])
                <div class="flex flex-col items-center">
                    <!-- Ketua Compact Capsule Card (Tanpa Foto) -->
                    <div class="w-60 rounded-xl bg-white dark:bg-slate-800 border-2 border-blue-600 dark:border-blue-500 shadow-md overflow-hidden transition-all hover:shadow-lg">
                        <!-- Header Capsule -->
                        <div class="bg-gradient-to-r from-blue-700 to-sky-600 text-white px-2.5 py-1 flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-crown text-[10px] text-amber-300"></i>
                            <span class="text-[11px] font-black uppercase tracking-wider">
                                {{ $tree['ketua']->jabatan }}
                            </span>
                        </div>
                        <!-- Body -->
                        <div class="px-2.5 py-1.5 text-center bg-white dark:bg-slate-800">
                            <h3 class="text-xs font-black text-slate-900 dark:text-white truncate">
                                {{ $tree['ketua']->nama }}
                            </h3>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400 font-medium mt-0.5">
                                KTA: {{ $tree['ketua']->nomor_kartu ?? '-' }} • <span class="font-bold text-blue-600 dark:text-blue-400">{{ $tree['ketua']->tingkat_ukw ?? 'Utama' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Vertical Line Connector from Ketua down -->
                    <div class="w-0.5 h-3.5 bg-blue-600 dark:bg-blue-400"></div>
                </div>
            @endif

            <!-- ==================================================== -->
            <!-- LEVEL 2: WAKIL KETUA (1, 2, 3) - BERJEJER HORIZONTAL  -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Horizontal Bus connecting Wakil Ketua 1, 2, 3 -->
                <div class="w-[580px] h-0.5 bg-blue-600 dark:bg-blue-400"></div>

                <!-- 3 Columns for Wakil Ketua -->
                <div class="w-[620px] grid grid-cols-3 gap-3 pt-0">
                    @php
                        $wkColors = [
                            0 => ['bg' => 'from-rose-600 to-red-600', 'border' => 'border-rose-500', 'icon' => 'fa-award', 'label' => 'WAKIL KETUA 1'],
                            1 => ['bg' => 'from-sky-600 to-blue-600', 'border' => 'border-sky-500', 'icon' => 'fa-award', 'label' => 'WAKIL KETUA 2'],
                            2 => ['bg' => 'from-amber-500 to-amber-600', 'border' => 'border-amber-500', 'icon' => 'fa-award', 'label' => 'WAKIL KETUA 3'],
                        ];
                    @endphp

                    @foreach($tree['wakil_ketua'] as $idx => $wk)
                        @php $cfg = $wkColors[$idx] ?? $wkColors[0]; @endphp
                        <div class="flex flex-col items-center">
                            <!-- Drop stem to each Wakil Ketua -->
                            <div class="w-0.5 h-3 bg-blue-600 dark:bg-blue-400"></div>

                            <!-- Wakil Ketua Card -->
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border {{ $cfg['border'] }} shadow-xs overflow-hidden">
                                <div class="bg-gradient-to-r {{ $cfg['bg'] }} text-white px-2 py-0.5 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid {{ $cfg['icon'] }} text-[9px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide truncate">
                                        {{ $cfg['label'] }}
                                    </span>
                                </div>
                                <div class="px-2 py-1 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-[11px] font-bold text-slate-900 dark:text-white truncate" title="{{ $wk->nama }}">
                                        {{ $wk->nama }}
                                    </h4>
                                    <p class="text-[8px] text-slate-500 dark:text-slate-400 truncate">
                                        {{ $wk->tingkat_ukw ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Central Spine continuing down from Wakil Ketua row -->
                <div class="w-0.5 h-3.5 bg-blue-600 dark:bg-blue-400 mt-1"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 3: SEKRETARIAT & KEBENDAHARAAN (KIRI & KANAN)  -->
            <!-- (Dengan Garis Koordinasi Horizontal)                 -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Two Parallel Stacks: Left (Sekretariat) & Right (Kebendaharaan) -->
                <div class="w-[580px] grid grid-cols-2 gap-6 relative">
                    
                    <!-- KIRI: SEKRETARIAT -->
                    <div class="flex flex-col items-center space-y-2">
                        <!-- 1. SEKRETARIS -->
                        @if($tree['sekretariat']['utama'])
                            @php $sec = $tree['sekretariat']['utama']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-purple-500 shadow-xs overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-700 to-indigo-600 text-white px-2 py-0.5 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-pen-nib text-[9px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide">
                                        {{ $sec->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2 py-1 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-[11px] font-bold text-slate-900 dark:text-white truncate">
                                        {{ $sec->nama }}
                                    </h4>
                                    <p class="text-[8px] text-slate-500 dark:text-slate-400">
                                        {{ $sec->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Vertical stem to Wakil Sekretaris -->
                        <div class="w-0.5 h-2 bg-purple-500"></div>

                        <!-- 2. WAKIL SEKRETARIS -->
                        @if($tree['sekretariat']['wakil'])
                            @php $wsec = $tree['sekretariat']['wakil']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-sky-500 shadow-xs overflow-hidden">
                                <div class="bg-gradient-to-r from-sky-600 to-cyan-600 text-white px-2 py-0.5 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-file-signature text-[9px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide">
                                        {{ $wsec->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2 py-1 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-[11px] font-bold text-slate-900 dark:text-white truncate">
                                        {{ $wsec->nama }}
                                    </h4>
                                    <p class="text-[8px] text-slate-500 dark:text-slate-400">
                                        {{ $wsec->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- KANAN: KEBENDAHARAAN -->
                    <div class="flex flex-col items-center space-y-2">
                        <!-- 1. BENDAHARA -->
                        @if($tree['kebendaharaan']['utama'])
                            @php $ben = $tree['kebendaharaan']['utama']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-amber-500 shadow-xs overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white px-2 py-0.5 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-coins text-[9px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide">
                                        {{ $ben->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2 py-1 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-[11px] font-bold text-slate-900 dark:text-white truncate">
                                        {{ $ben->nama }}
                                    </h4>
                                    <p class="text-[8px] text-slate-500 dark:text-slate-400">
                                        {{ $ben->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Vertical stem to Wakil Bendahara -->
                        <div class="w-0.5 h-2 bg-amber-500"></div>

                        <!-- 2. WAKIL BENDAHARA -->
                        @if($tree['kebendaharaan']['wakil'])
                            @php $wben = $tree['kebendaharaan']['wakil']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-emerald-500 shadow-xs overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-2 py-0.5 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-receipt text-[9px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide">
                                        {{ $wben->jabatan }}
                                    </span>
                                </div>
                                <div class="px-2 py-1 text-center bg-white dark:bg-slate-800">
                                    <h4 class="text-[11px] font-bold text-slate-900 dark:text-white truncate">
                                        {{ $wben->nama }}
                                    </h4>
                                    <p class="text-[8px] text-slate-500 dark:text-slate-400">
                                        {{ $wben->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Garis Koordinasi Horizontal 1 (Sekretaris <-> Bendahara) --}}
                    <div class="absolute top-4 left-1/2 -translate-x-1/2 flex items-center justify-center gap-1 z-10">
                        <span class="text-blue-500 text-[10px]"><i class="fa-solid fa-caret-left"></i></span>
                        <span class="px-1.5 py-0.2 rounded text-[7px] font-extrabold uppercase bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-2xs">
                            Koordinasi
                        </span>
                        <span class="text-blue-500 text-[10px]"><i class="fa-solid fa-caret-right"></i></span>
                    </div>

                    {{-- Garis Koordinasi Horizontal 2 (Wakil Sekretaris <-> Wakil Bendahara) --}}
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center justify-center gap-1 z-10">
                        <span class="text-blue-500 text-[10px]"><i class="fa-solid fa-caret-left"></i></span>
                        <span class="px-1.5 py-0.2 rounded text-[7px] font-extrabold uppercase bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-2xs">
                            Koordinasi
                        </span>
                        <span class="text-blue-500 text-[10px]"><i class="fa-solid fa-caret-right"></i></span>
                    </div>

                </div>

                <!-- Central Spine continuing down to 7 Bidang -->
                <div class="w-0.5 h-4 bg-blue-600 dark:bg-blue-400 mt-1"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 4: 7 BIDANG KERJA (BERDERET HORIZONTAL)       -->
            <!-- (Landscape: Header -> Kabid -> Wakabid -> Anggota)  -->
            <!-- ==================================================== -->
            <div class="relative space-y-2 pt-1">
                
                <!-- Main Horizontal Distribution Bus across 7 Bidang -->
                <div class="relative flex justify-center">
                    <div class="w-[1020px] h-0.5 bg-blue-600 dark:bg-blue-400"></div>
                </div>

                <!-- 7 Columns Side-by-Side in Clean Landscape -->
                <div class="grid grid-cols-7 gap-2">
                    @php
                        $bidangStyles = [
                            'pembelaan' => ['grad' => 'from-indigo-700 to-blue-700', 'border' => 'border-indigo-400', 'icon' => 'fa-shield-halved'],
                            'organisasi' => ['grad' => 'from-blue-700 to-sky-600', 'border' => 'border-blue-400', 'icon' => 'fa-sitemap'],
                            'pendidikan' => ['grad' => 'from-emerald-700 to-teal-600', 'border' => 'border-emerald-400', 'icon' => 'fa-graduation-cap'],
                            'publikasi' => ['grad' => 'from-cyan-700 to-blue-600', 'border' => 'border-cyan-400', 'icon' => 'fa-bullhorn'],
                            'kesejahteraan' => ['grad' => 'from-amber-600 to-yellow-600', 'border' => 'border-amber-400', 'icon' => 'fa-hand-holding-heart'],
                            'siwo' => ['grad' => 'from-rose-700 to-red-600', 'border' => 'border-rose-400', 'icon' => 'fa-trophy'],
                            'kemasyarakatan' => ['grad' => 'from-teal-700 to-emerald-600', 'border' => 'border-teal-400', 'icon' => 'fa-users'],
                        ];
                    @endphp

                    @foreach($tree['bidangs'] as $bKey => $b)
                        @php $st = $bidangStyles[$bKey] ?? $bidangStyles['pembelaan']; @endphp
                        <div class="flex flex-col items-center space-y-1.5">
                            
                            <!-- Drop stem from bus to column header -->
                            <div class="w-0.5 h-2 bg-blue-600 dark:bg-blue-400 -mt-2"></div>

                            <!-- 1. Header Bidang Capsule -->
                            <div class="w-full rounded-lg bg-gradient-to-r {{ $st['grad'] }} text-white p-1.5 shadow-xs text-center">
                                <span class="block text-[8px] font-extrabold uppercase tracking-widest text-white/80">
                                    BIDANG {{ $b['info']['code'] ?? '' }}
                                </span>
                                <h5 class="text-[9px] font-black uppercase text-white truncate leading-tight mt-0.5" title="{{ $b['info']['title'] }}">
                                    {{ $b['info']['title'] }}
                                </h5>
                            </div>

                            <!-- Stem -->
                            <div class="w-0.5 h-1.5 bg-slate-300 dark:bg-slate-700"></div>

                            <!-- 2. KEPALA BIDANG -->
                            <div class="w-full rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 p-1.5 text-center shadow-2xs">
                                <span class="block text-[7px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                    KEPALA BIDANG
                                </span>
                                <h6 class="text-[10px] font-bold text-slate-900 dark:text-white truncate mt-0.5" title="{{ $b['kabid']?->nama ?? '-' }}">
                                    {{ $b['kabid']?->nama ?? '-' }}
                                </h6>
                            </div>

                            <!-- Stem -->
                            <div class="w-0.5 h-1.5 bg-slate-300 dark:bg-slate-700"></div>

                            <!-- 3. WAKIL KEPALA BIDANG -->
                            <div class="w-full rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 p-1.5 text-center shadow-2xs">
                                <span class="block text-[7px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                    WAKIL KEPALA
                                </span>
                                <h6 class="text-[10px] font-bold text-slate-900 dark:text-white truncate mt-0.5" title="{{ $b['wakabid']?->nama ?? '-' }}">
                                    {{ $b['wakabid']?->nama ?? '-' }}
                                </h6>
                            </div>

                            <!-- Stem -->
                            <div class="w-0.5 h-1.5 bg-slate-300 dark:bg-slate-700"></div>

                            <!-- 4. ANGGOTA BIDANG -->
                            <div class="w-full rounded-lg bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 overflow-hidden text-center shadow-2xs">
                                <div class="bg-blue-600 text-white text-[7px] font-black uppercase py-0.5 tracking-wider">
                                    ANGGOTA
                                </div>
                                <div class="p-1 space-y-0.5">
                                    @forelse($b['anggota'] as $ang)
                                        <p class="text-[9px] font-bold text-slate-800 dark:text-slate-200 truncate" title="{{ $ang->nama }}">
                                            {{ $ang->nama }}
                                        </p>
                                    @empty
                                        <p class="text-[8px] text-slate-400 italic">-</p>
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
                    <div class="pt-2 flex flex-col items-center">
                        <div class="w-0.5 h-2 bg-slate-300 dark:bg-slate-700"></div>
                        <div class="w-full max-w-lg rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 px-3 py-1.5 text-center shadow-2xs">
                            <span class="inline-block px-2 py-0.2 rounded text-[8px] font-black uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">
                                <i class="fa-solid fa-users text-blue-600"></i> Anggota Pelaksana Tambahan
                            </span>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($tree['anggota_umum'] as $au)
                                    <div class="px-2 py-1 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-center">
                                        <p class="text-[10px] font-bold text-slate-900 dark:text-white truncate">{{ $au->nama }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Footer SK & Legalitas Resmi -->
            <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-[9px] text-slate-400 dark:text-slate-500 font-medium">
                <span>Ditetapkan di Pangkalan Balai • SK Resmi Pengurus PWI Banyuasin 2025–2028</span>
                <span class="font-semibold text-slate-500 dark:text-slate-400">Portal Resmi: pwiba.or.id</span>
            </div>

        </div>

    </div>

</div>
