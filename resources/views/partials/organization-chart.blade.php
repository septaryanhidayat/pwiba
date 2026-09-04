{{-- Component Bagan Struktur Organisasi Visual Landscape Simetris Presisi Tanpa Foto dengan Logo PWI --}}
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
            const renderCanvas = () => {
                html2canvas(target, {
                    scale: 3,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    logging: false,
                    windowWidth: 1140,
                    windowHeight: target.scrollHeight,
                    onclone: (clonedDoc) => {
                        const canvasEl = clonedDoc.getElementById('org-chart-canvas');
                        if (canvasEl) {
                            canvasEl.style.transform = 'none';
                            canvasEl.style.width = '1140px';
                            canvasEl.style.maxWidth = '1140px';
                            canvasEl.style.overflow = 'visible';
                            canvasEl.querySelectorAll('*').forEach(el => {
                                el.style.overflow = 'visible';
                            });
                        }
                    }
                }).then(canvas => {
                    target.style.transform = prevTransform;
                    this.isExporting = false;
                    const link = document.createElement('a');
                    link.download = 'bagan-struktur-organisasi-pwi-banyuasin.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bagan Berhasil Diunduh!',
                            text: 'File gambar bagan landscape resolusi tinggi telah disimpan dalam format PNG dengan garis presisi tanpa terpotong.',
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

            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(renderCanvas);
            } else {
                renderCanvas();
            }
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
        #org-chart-canvas {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        #org-chart-canvas * {
            box-sizing: border-box;
        }
        #org-chart-canvas h1,
        #org-chart-canvas h2,
        #org-chart-canvas h3,
        #org-chart-canvas h4,
        #org-chart-canvas h5,
        #org-chart-canvas h6,
        #org-chart-canvas p {
            margin: 0;
            padding: 0;
            line-height: 1.25;
            text-align: center;
        }
        #org-chart-canvas svg {
            display: block;
            overflow: visible;
            flex-shrink: 0;
            shape-rendering: geometricPrecision;
        }
        @media print {
            @page {
                size: landscape;
                margin: 5mm;
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
                        Format Landscape Simetris
                    </span>
                </h4>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Bagan resmi: Garis instruksi presisi, simetris rapi, dan bebas teks terpotong</p>
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
        
        <!-- The Printable & Exportable Canvas (Landscape Width ~1140px, Simetris & Anti-Clipping) -->
        <div id="org-chart-canvas" 
             :style="'transform: scale(' + (zoomLevel / 100) + '); transform-origin: top center; transition: transform 0.2s ease-out;'"
             class="w-[1140px] mx-auto p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md space-y-4"
             style="background-image: radial-gradient(rgba(100, 116, 139, 0.08) 1px, transparent 1px); background-size: 16px 16px;">
            
            <!-- Bagan Header Title dengan Logo PWI Resmi -->
            <div class="text-center pb-3 border-b border-slate-200 dark:border-slate-800">
                <!-- Logo PWI di Atas Bagan -->
                <div class="flex items-center justify-center mb-2">
                    <img src="{{ $settings['logo_url'] ?? asset('assets/images/pwi-logo.png') }}" 
                         alt="Logo Persatuan Wartawan Indonesia (PWI)" 
                         class="h-14 w-auto object-contain drop-shadow-sm" 
                         loading="eager" 
                         crossorigin="anonymous">
                </div>

                <h2 class="text-base sm:text-lg font-black text-[#0B132B] dark:text-white uppercase tracking-wider leading-snug text-center m-0">
                    STRUKTUR ORGANISASI PERSATUAN WARTAWAN INDONESIA (PWI)
                </h2>
                <div class="flex items-center justify-center gap-2 mt-1">
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
                    <!-- Ketua Card (Dimensi Tetap Simetris) -->
                    <div class="w-64 rounded-xl bg-white dark:bg-slate-800 border-2 border-blue-600 dark:border-blue-500 shadow-md">
                        <!-- Header Capsule -->
                        <div class="h-8 bg-gradient-to-r from-blue-700 to-sky-600 text-white rounded-t-lg px-3 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-crown text-xs text-amber-300"></i>
                            <span class="text-xs font-black uppercase tracking-wider text-center">
                                {{ $tree['ketua']->jabatan }}
                            </span>
                        </div>
                        <!-- Body -->
                        <div class="h-14 px-3 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white leading-tight text-center m-0">
                                {{ $tree['ketua']->nama }}
                            </h3>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium mt-1 leading-none text-center m-0">
                                KTA: {{ $tree['ketua']->nomor_kartu ?? '-' }} • <span class="font-bold text-blue-600 dark:text-blue-400">{{ $tree['ketua']->tingkat_ukw ?? 'Utama' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Direct Vertical Line Connector from Ketua down -->
                    <div class="w-[2px] h-4 bg-blue-600 dark:bg-blue-400"></div>
                </div>
            @endif

            <!-- ==================================================== -->
            <!-- LEVEL 2: WAKIL KETUA (1, 2, 3) - BERJEJER HORIZONTAL  -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                
                <!-- SVG Bracket Penghubung Presisi Wakil Ketua 1, 2, 3 (Zero Overhang) -->
                <svg class="w-[600px] h-7 text-blue-600 dark:text-blue-400 mx-auto block" viewBox="0 0 600 28" fill="none">
                    <!-- Turun dari Ketua di tengah (x=300) -->
                    <path d="M 300 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <!-- Garis horizontal dari pusat Wakil Ketua 1 (x=90) ke Wakil Ketua 3 (x=510) -->
                    <path d="M 90 14 H 510" stroke="currentColor" stroke-width="2"/>
                    <!-- Garis turun tepat ke tengah masing-masing kartu -->
                    <path d="M 90 14 V 28 M 300 14 V 28 M 510 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <!-- 3 Columns for Wakil Ketua (Lebar 600px, Tiap Kolom w-[180px], Centers: 90, 300, 510) -->
                <div class="w-[600px] mx-auto flex justify-between items-stretch">
                    @php
                        $wkColors = [
                            0 => ['bg' => 'from-rose-600 to-red-600', 'border' => 'border-rose-500', 'icon' => 'fa-award', 'label' => 'WAKIL KETUA 1'],
                            1 => ['bg' => 'from-sky-600 to-blue-600', 'border' => 'border-sky-500', 'icon' => 'fa-award', 'label' => 'WAKIL KETUA 2'],
                            2 => ['bg' => 'from-amber-500 to-amber-600', 'border' => 'border-amber-500', 'icon' => 'fa-award', 'label' => 'WAKIL KETUA 3'],
                        ];
                    @endphp

                    @foreach($tree['wakil_ketua'] as $idx => $wk)
                        @php $cfg = $wkColors[$idx] ?? $wkColors[0]; @endphp
                        <div class="w-[180px] flex flex-col items-center">
                            <!-- Wakil Ketua Card -->
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border {{ $cfg['border'] }} shadow-xs">
                                <div class="h-7 bg-gradient-to-r {{ $cfg['bg'] }} text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                                    <i class="fa-solid {{ $cfg['icon'] }} text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide text-center">
                                        {{ $cfg['label'] }}
                                    </span>
                                </div>
                                <div class="h-14 px-2 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white leading-tight text-center m-0">
                                        {{ $wk->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1 leading-none text-center m-0">
                                        {{ $wk->tingkat_ukw ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Central Spine continuing down from Wakil Ketua row -->
                <div class="w-[2px] h-4 bg-blue-600 dark:bg-blue-400"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 3: SEKRETARIAT & KEBENDAHARAAN (KIRI & KANAN)  -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                
                <!-- SVG Penghubung ke Sekretariat (Kiri) dan Kebendaharaan (Kanan) -->
                <svg class="w-[600px] h-7 text-blue-600 dark:text-blue-400 mx-auto block" viewBox="0 0 600 28" fill="none">
                    <!-- Turun dari poros tengah (x=300) -->
                    <path d="M 300 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <!-- Cabang horizontal ke pusat Sekretariat (x=115) dan Kebendaharaan (x=485) -->
                    <path d="M 115 14 H 485" stroke="currentColor" stroke-width="2"/>
                    <!-- Turun tepat ke puncak kartu dan poros tengah -->
                    <path d="M 115 14 V 28 M 300 14 V 28 M 485 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <!-- Two Parallel Stacks: Left (Sekretariat w-[230px]), Center Spine (w-[140px]), Right (Kebendaharaan w-[230px]) -->
                <div class="w-[600px] mx-auto flex items-stretch">
                    
                    <!-- KIRI: SEKRETARIAT -->
                    <div class="w-[230px] flex flex-col items-center">
                        <!-- 1. SEKRETARIS -->
                        @if($tree['sekretariat']['utama'])
                            @php $sec = $tree['sekretariat']['utama']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-purple-500 shadow-xs">
                                <div class="h-7 bg-gradient-to-r from-purple-700 to-indigo-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                                    <i class="fa-solid fa-pen-nib text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide text-center">
                                        {{ $sec->jabatan }}
                                    </span>
                                </div>
                                <div class="h-14 px-2 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white leading-tight text-center m-0">
                                        {{ $sec->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1 leading-none text-center m-0">
                                        {{ $sec->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Vertical Continuous SVG Arrow to Wakil Sekretaris -->
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 block -my-[1px]" viewBox="0 0 16 16" fill="none">
                            <line x1="8" y1="0" x2="8" y2="10" stroke="currentColor" stroke-width="2"/>
                            <polygon points="4,9 8,15 12,9" fill="currentColor"/>
                        </svg>

                        <!-- 2. WAKIL SEKRETARIS -->
                        @if($tree['sekretariat']['wakil'])
                            @php $wsec = $tree['sekretariat']['wakil']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-sky-500 shadow-xs">
                                <div class="h-7 bg-gradient-to-r from-sky-600 to-cyan-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                                    <i class="fa-solid fa-file-signature text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide text-center">
                                        {{ $wsec->jabatan }}
                                    </span>
                                </div>
                                <div class="h-14 px-2 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white leading-tight text-center m-0">
                                        {{ $wsec->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1 leading-none text-center m-0">
                                        {{ $wsec->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- TENGAH: CENTRAL SPINE LINE THROUGH LEVEL 3 -->
                    <div class="w-[140px] flex justify-center items-stretch">
                        <div class="w-[2px] h-full bg-blue-600 dark:bg-blue-400"></div>
                    </div>

                    <!-- KANAN: KEBENDAHARAAN -->
                    <div class="w-[230px] flex flex-col items-center">
                        <!-- 1. BENDAHARA -->
                        @if($tree['kebendaharaan']['utama'])
                            @php $ben = $tree['kebendaharaan']['utama']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-amber-500 shadow-xs">
                                <div class="h-7 bg-gradient-to-r from-amber-600 to-yellow-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                                    <i class="fa-solid fa-coins text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide text-center">
                                        {{ $ben->jabatan }}
                                    </span>
                                </div>
                                <div class="h-14 px-2 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white leading-tight text-center m-0">
                                        {{ $ben->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1 leading-none text-center m-0">
                                        {{ $ben->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Vertical Continuous SVG Arrow to Wakil Bendahara -->
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 block -my-[1px]" viewBox="0 0 16 16" fill="none">
                            <line x1="8" y1="0" x2="8" y2="10" stroke="currentColor" stroke-width="2"/>
                            <polygon points="4,9 8,15 12,9" fill="currentColor"/>
                        </svg>

                        <!-- 2. WAKIL BENDAHARA -->
                        @if($tree['kebendaharaan']['wakil'])
                            @php $wben = $tree['kebendaharaan']['wakil']; @endphp
                            <div class="w-full rounded-xl bg-white dark:bg-slate-800 border border-emerald-500 shadow-xs">
                                <div class="h-7 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                                    <i class="fa-solid fa-receipt text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wide text-center">
                                        {{ $wben->jabatan }}
                                    </span>
                                </div>
                                <div class="h-14 px-2 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white leading-tight text-center m-0">
                                        {{ $wben->nama }}
                                    </h4>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1 leading-none text-center m-0">
                                        {{ $wben->nomor_kartu ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Central Spine continuing down from Level 3 to Level 4 -->
                <div class="w-[2px] h-4 bg-blue-600 dark:bg-blue-400"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 4: 7 BIDANG KERJA (BERDERET HORIZONTAL SIMETRIS)-->
            <!-- ==================================================== -->
            <div class="relative space-y-0 pt-0">
                
                <!-- Bus SVG: 7 Kolom Persis dari x=72 ke x=984 (Center=528, Zero Overhang) -->
                <svg class="w-[1056px] h-7 text-blue-600 dark:text-blue-400 mx-auto block" viewBox="0 0 1056 28" fill="none">
                    <!-- Turun dari poros tengah atas (x=528) -->
                    <path d="M 528 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <!-- Garis horizontal bus HANYA dari x=72 sampai x=984 -->
                    <path d="M 72 14 H 984" stroke="currentColor" stroke-width="2"/>
                    <!-- 7 Ticks vertikal tepat menuju ke masing-masing 7 kepala kolom -->
                    <path d="M 72 14 V 28 M 224 14 V 28 M 376 14 V 28 M 528 14 V 28 M 680 14 V 28 M 832 14 V 28 M 984 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <!-- 7 Columns Side-by-Side (Width 1056px, each w-[144px], gap-2 = 8px) -->
                <div class="w-[1056px] mx-auto grid grid-cols-7 gap-2">
                    @php
                        $bidangStyles = [
                            'pembelaan' => ['grad' => 'from-indigo-700 to-blue-700', 'border' => 'border-indigo-400'],
                            'organisasi' => ['grad' => 'from-blue-700 to-sky-600', 'border' => 'border-blue-400'],
                            'pendidikan' => ['grad' => 'from-emerald-700 to-teal-600', 'border' => 'border-emerald-400'],
                            'publikasi' => ['grad' => 'from-cyan-700 to-blue-600', 'border' => 'border-cyan-400'],
                            'kesejahteraan' => ['grad' => 'from-amber-600 to-yellow-600', 'border' => 'border-amber-400'],
                            'siwo' => ['grad' => 'from-rose-700 to-red-600', 'border' => 'border-rose-400'],
                            'kemasyarakatan' => ['grad' => 'from-teal-700 to-emerald-600', 'border' => 'border-teal-400'],
                        ];
                    @endphp

                    @foreach($tree['bidangs'] as $bKey => $b)
                        @php $st = $bidangStyles[$bKey] ?? $bidangStyles['pembelaan']; @endphp
                        <div class="w-[144px] flex flex-col items-center">
                            
                            <!-- 1. Header Bidang Capsule -->
                            <div class="w-full h-12 rounded-lg bg-gradient-to-r {{ $st['grad'] }} text-white px-1.5 py-1 shadow-xs text-center flex flex-col justify-center items-center">
                                <span class="block text-[8px] font-extrabold uppercase tracking-widest text-white/90 leading-none text-center m-0">
                                    BIDANG {{ $b['info']['code'] ?? '' }}
                                </span>
                                <h5 class="text-[9px] font-black uppercase text-white leading-tight mt-1 text-center m-0 truncate max-w-full" title="{{ $b['info']['title'] }}">
                                    {{ $b['info']['title'] }}
                                </h5>
                            </div>

                            <!-- Continuous SVG Arrow -->
                            <svg class="w-4 h-3.5 text-blue-500 dark:text-blue-400 block -my-[1px]" viewBox="0 0 16 14" fill="none">
                                <line x1="8" y1="0" x2="8" y2="8" stroke="currentColor" stroke-width="2"/>
                                <polygon points="4,7 8,13 12,7" fill="currentColor"/>
                            </svg>

                            <!-- 2. KEPALA BIDANG -->
                            <div class="w-full h-[52px] rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 px-1.5 py-1 text-center shadow-2xs flex flex-col justify-center items-center">
                                <span class="block text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider leading-none text-center m-0">
                                    KEPALA BIDANG
                                </span>
                                <h6 class="text-[10px] font-extrabold text-slate-900 dark:text-white leading-tight mt-1 text-center m-0 truncate max-w-full" title="{{ $b['kabid']?->nama ?? '-' }}">
                                    {{ $b['kabid']?->nama ?? '-' }}
                                </h6>
                            </div>

                            <!-- Continuous SVG Arrow -->
                            <svg class="w-4 h-3.5 text-blue-500 dark:text-blue-400 block -my-[1px]" viewBox="0 0 16 14" fill="none">
                                <line x1="8" y1="0" x2="8" y2="8" stroke="currentColor" stroke-width="2"/>
                                <polygon points="4,7 8,13 12,7" fill="currentColor"/>
                            </svg>

                            <!-- 3. WAKIL KEPALA BIDANG -->
                            <div class="w-full h-[52px] rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 px-1.5 py-1 text-center shadow-2xs flex flex-col justify-center items-center">
                                <span class="block text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider leading-none text-center m-0">
                                    WAKIL KEPALA
                                </span>
                                <h6 class="text-[10px] font-extrabold text-slate-900 dark:text-white leading-tight mt-1 text-center m-0 truncate max-w-full" title="{{ $b['wakabid']?->nama ?? '-' }}">
                                    {{ $b['wakabid']?->nama ?? '-' }}
                                </h6>
                            </div>

                            <!-- Continuous SVG Arrow -->
                            <svg class="w-4 h-3.5 text-blue-500 dark:text-blue-400 block -my-[1px]" viewBox="0 0 16 14" fill="none">
                                <line x1="8" y1="0" x2="8" y2="8" stroke="currentColor" stroke-width="2"/>
                                <polygon points="4,7 8,13 12,7" fill="currentColor"/>
                            </svg>

                            <!-- 4. ANGGOTA BIDANG -->
                            <div class="w-full min-h-[50px] rounded-lg bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 text-center shadow-2xs flex flex-col justify-between overflow-hidden">
                                <div class="bg-blue-600 text-white text-[8px] font-black uppercase py-0.5 tracking-wider leading-none text-center">
                                    ANGGOTA
                                </div>
                                <div class="px-1 py-1.5 flex flex-col justify-center items-center flex-grow text-center">
                                    @forelse($b['anggota'] as $ang)
                                        <p class="text-[9px] font-bold text-slate-800 dark:text-slate-200 leading-tight text-center m-0 truncate max-w-full" title="{{ $ang->nama }}">
                                            {{ $ang->nama }}
                                        </p>
                                    @empty
                                        <p class="text-[8px] text-slate-400 italic leading-none text-center m-0">-</p>
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
                        <div class="w-[2px] h-3.5 bg-blue-500 dark:bg-blue-400"></div>
                        <div class="w-full max-w-lg rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 px-3 py-2 text-center shadow-2xs">
                            <span class="inline-block px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1 leading-normal text-center">
                                <i class="fa-solid fa-users text-blue-600"></i> Anggota Pelaksana Tambahan
                            </span>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($tree['anggota_umum'] as $au)
                                    <div class="h-8 px-2 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-center flex items-center justify-center">
                                        <p class="text-[10px] font-bold text-slate-900 dark:text-white leading-tight text-center m-0">{{ $au->nama }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Footer SK & Legalitas Resmi -->
            <div class="pt-2.5 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-[9px] text-slate-400 dark:text-slate-500 font-medium">
                <span>Ditetapkan di Pangkalan Balai • SK Resmi Pengurus PWI Banyuasin 2025–2028</span>
                <span class="font-semibold text-slate-500 dark:text-slate-400">Portal Resmi: pwiba.or.id</span>
            </div>

        </div>

    </div>

</div>
