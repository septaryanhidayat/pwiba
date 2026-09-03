{{-- Component Bagan Struktur Organisasi Visual dengan Garis Instruksi --}}
<div x-data="{
    zoomLevel: 100,
    activeTab: 'all',
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

        // Load html2canvas dynamically if not loaded
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
                        text: 'File gambar bagan struktur organisasi telah disimpan sebagai format PNG resolusi tinggi.',
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
    <div class="flex flex-wrap items-center justify-between gap-3 p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm print:hidden">
        
        <!-- Legend / Info -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-lg shadow-sm border border-blue-200 dark:border-blue-900/40">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div>
                <h4 class="text-sm font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <span>Bagan Alur & Hirarki Kepengurusan</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                        Masa Bhakti 2025–2028
                    </span>
                </h4>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">Garis instruksi/komando pimpinan ke bidang operasional dan anggota</p>
            </div>
        </div>

        <!-- Interactive Tools (Zoom, Download, Print) -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Zoom Controls -->
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-xl border border-slate-200 dark:border-slate-700">
                <button type="button" @click="zoomOut()" aria-label="Perkecil Bagan (-)" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all" title="Perkecil (-)">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="px-2 text-xs font-bold text-slate-700 dark:text-slate-300 min-w-[3.5rem] text-center" x-text="zoomLevel + '%'">100%</span>
                <button type="button" @click="zoomIn()" aria-label="Perbesar Bagan (+)" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all" title="Perbesar (+)">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button type="button" @click="resetZoom()" aria-label="Reset Zoom Bagan" class="px-2 py-1 ml-1 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700 transition-all" title="Reset Zoom ke 100%">
                    Reset
                </button>
            </div>

            <!-- Fullscreen -->
            <button type="button" @click="toggleFullscreen()" aria-label="Tampilan Layar Penuh" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-all" title="Layar Penuh">
                <i class="fa-solid fa-expand"></i>
                <span class="hidden sm:inline">Layar Penuh</span>
            </button>

            <!-- Export Image Button -->
            <button type="button" @click="exportChartImage()" :disabled="isExporting" aria-label="Unduh bagan organisasi dalam format gambar PNG" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition-all cursor-pointer disabled:opacity-50" title="Unduh bagan organisasi dalam format gambar PNG resolusi tinggi">
                <template x-if="!isExporting">
                    <i class="fa-solid fa-file-arrow-down"></i>
                </template>
                <template x-if="isExporting">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </template>
                <span x-text="isExporting ? 'Memproses...' : 'Unduh Gambar (PNG)'">Unduh Gambar (PNG)</span>
            </button>

            <!-- Print Button -->
            <button type="button" onclick="window.print()" aria-label="Cetak atau Simpan PDF Bagan" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 shadow-sm transition-all" title="Cetak / Simpan PDF">
                <i class="fa-solid fa-print"></i>
                <span class="hidden sm:inline">Cetak</span>
            </button>
        </div>
    </div>

    <!-- Chart Canvas Container (Scrollable with zoom) -->
    <div id="org-chart-wrapper" class="relative w-full overflow-x-auto overflow-y-hidden rounded-3xl bg-slate-100/70 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-800 shadow-inner p-4 sm:p-8 transition-all">
        
        <!-- Hint on mobile -->
        <div class="sm:hidden text-center text-[11px] text-slate-500 font-semibold mb-3 flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-arrows-left-right text-blue-500 animate-pulse"></i>
            <span>Geser ke kanan/kiri untuk melihat seluruh bagan</span>
        </div>

        <!-- The Printable & Exportable Canvas -->
        <div id="org-chart-canvas" 
             :style="'transform: scale(' + (zoomLevel / 100) + '); transform-origin: top center; transition: transform 0.2s ease-out;'"
             class="min-w-[1280px] mx-auto p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl space-y-8"
             style="background-image: radial-gradient(rgba(100, 116, 139, 0.12) 1.5px, transparent 1.5px); background-size: 28px 28px;">
            
            <!-- Bagan Header Title (Visible on export / print) -->
            <div class="text-center pb-4 border-b border-slate-200 dark:border-slate-800">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-900/50 mb-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>BAGAN STRUKTUR ORGANISASI RESMI</span>
                </div>
                <h2 class="text-2xl font-black text-[#0B132B] dark:text-white uppercase tracking-wide">
                    Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-semibold">
                    Masa Bhakti 2025–2028 • SK Penetapan Pengurus Resmi PWI Provinsi Sumatera Selatan
                </p>
            </div>

            <!-- ========================================== -->
            <!-- LEVEL 1: KETUA (PIMPINAN PUNCAK)           -->
            <!-- ========================================== -->
            @if($tree['ketua'])
                <div class="flex flex-col items-center">
                    <div class="relative group">
                        <!-- Node Card Ketua -->
                        <div class="w-80 rounded-2xl bg-gradient-to-b from-amber-50 to-white dark:from-slate-800 dark:to-slate-900 border-2 border-amber-400 dark:border-amber-500 shadow-lg shadow-amber-500/10 p-5 text-center transition-all hover:-translate-y-1 hover:shadow-2xl">
                            <!-- Role Badge -->
                            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-black text-amber-900 bg-amber-300 dark:bg-amber-400 dark:text-slate-950 shadow-sm uppercase tracking-wider mb-3">
                                <i class="fa-solid fa-crown text-[11px]"></i>
                                <span>{{ $tree['ketua']->jabatan }}</span>
                            </div>

                            <!-- Avatar -->
                            <div class="relative w-20 h-20 rounded-2xl ring-4 ring-amber-400/40 dark:ring-amber-400/30 overflow-hidden mx-auto shadow-md mb-3 bg-slate-100 dark:bg-slate-800">
                                <img src="{{ $tree['ketua']->foto_url }}" alt="{{ $tree['ketua']->nama }}" width="80" height="80" loading="lazy" decoding="async" class="w-full h-full object-cover">
                            </div>

                            <!-- Name & KTA -->
                            <h3 class="text-base font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                                {{ $tree['ketua']->nama }}
                            </h3>
                            <div class="text-[11px] font-mono font-bold text-slate-600 dark:text-slate-300 mt-1">
                                KTA: {{ $tree['ketua']->nomor_kartu ?? '-' }}
                            </div>

                            <!-- UKW Badge -->
                            <div class="mt-2.5 pt-2.5 border-t border-amber-200/60 dark:border-slate-700/60 flex items-center justify-center gap-2">
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-extrabold {{ $tree['ketua']->ukw_badge_color }}">
                                    {{ $tree['ketua']->tingkat_ukw ?? 'Belum UKW' }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-semibold">Periode 2025–2028</span>
                            </div>
                        </div>

                        <!-- Top-to-Bottom Line connector out of Ketua -->
                        <div class="w-1 h-10 bg-gradient-to-b from-amber-400 to-blue-600 mx-auto"></div>
                        <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] mx-auto shadow-sm -mt-2">
                            <i class="fa-solid fa-arrow-down"></i>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Instruction Badge Indicator -->
            <div class="flex justify-center -my-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold text-blue-700 bg-blue-50 dark:bg-blue-950/80 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-sm uppercase tracking-widest">
                    <i class="fa-solid fa-code-branch"></i> Garis Koordinasi & Pimpinan Harian
                </span>
            </div>

            <!-- ========================================== -->
            <!-- LEVEL 2: WAKIL KETUA, SEKRETARIAT, BENDAHARA-->
            <!-- ========================================== -->
            <div class="relative">
                <!-- Main Horizontal Branch Connector for Executives -->
                <div class="absolute top-0 left-1/4 right-1/4 h-1 bg-blue-600 rounded-full"></div>

                <div class="grid grid-cols-3 gap-6 pt-6">
                    
                    <!-- 1. KLASTER WAKIL KETUA (Kiri) -->
                    <div class="flex flex-col items-center">
                        <div class="w-0.5 h-6 bg-blue-600 -mt-6"></div>
                        <div class="w-full max-w-sm rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-900/60 p-4 space-y-3">
                            <div class="text-center pb-2 border-b border-indigo-200 dark:border-indigo-900/40">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-indigo-700 dark:text-indigo-300 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-user-shield"></i>
                                    <span>Jajaran Wakil Ketua</span>
                                </span>
                            </div>

                            <div class="space-y-2.5">
                                @foreach($tree['wakil_ketua'] as $wk)
                                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-indigo-100 dark:border-indigo-950 shadow-sm hover:shadow transition-all">
                                        <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 flex items-center justify-center font-bold overflow-hidden flex-shrink-0 aspect-square ring-1 ring-indigo-200 dark:ring-indigo-800">
                                            <img src="{{ $wk->foto_url }}" alt="{{ $wk->nama }}" width="48" height="48" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <span class="inline-block px-2 py-0.5 rounded text-[9px] font-black uppercase text-indigo-700 bg-indigo-50 dark:bg-indigo-950/80 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-900 mb-0.5">
                                                {{ $wk->jabatan }}
                                            </span>
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" title="{{ $wk->nama }}">{{ $wk->nama }}</h4>
                                            <div class="flex items-center gap-2 mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">
                                                <span class="font-mono">{{ $wk->nomor_kartu ?? '-' }}</span>
                                                <span>•</span>
                                                <span class="font-bold text-[9px] {{ $wk->ukw_badge_color }} px-1.5 rounded">{{ $wk->tingkat_ukw }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 2. KLASTER SEKRETARIAT (Tengah) -->
                    <div class="flex flex-col items-center">
                        <div class="w-0.5 h-6 bg-blue-600 -mt-6"></div>
                        <div class="w-full max-w-sm rounded-2xl bg-teal-50/50 dark:bg-teal-950/30 border border-teal-200 dark:border-teal-900/60 p-4 space-y-3">
                            <div class="text-center pb-2 border-b border-teal-200 dark:border-teal-900/40">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-teal-700 dark:text-teal-300 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-file-signature"></i>
                                    <span>Sekretariat Organisasi</span>
                                </span>
                            </div>

                            <div class="space-y-2.5">
                                @if($tree['sekretariat']['utama'])
                                    @php $sec = $tree['sekretariat']['utama']; @endphp
                                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-teal-200 dark:border-teal-950 shadow-sm hover:shadow transition-all ring-1 ring-teal-400/30">
                                        <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-950 text-teal-700 flex items-center justify-center font-bold overflow-hidden flex-shrink-0 aspect-square ring-1 ring-teal-300 dark:ring-teal-700">
                                            <img src="{{ $sec->foto_url }}" alt="{{ $sec->nama }}" width="48" height="48" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <span class="inline-block px-2 py-0.5 rounded text-[9px] font-black uppercase text-teal-800 bg-teal-100 dark:bg-teal-900/60 dark:text-teal-200 mb-0.5">
                                                {{ $sec->jabatan }}
                                            </span>
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" title="{{ $sec->nama }}">{{ $sec->nama }}</h4>
                                            <div class="flex items-center gap-2 mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">
                                                <span class="font-mono">{{ $sec->nomor_kartu ?? '-' }}</span>
                                                <span>•</span>
                                                <span class="font-bold text-[9px] {{ $sec->ukw_badge_color }} px-1.5 rounded">{{ $sec->tingkat_ukw }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($tree['sekretariat']['wakil'])
                                    @php $wsec = $tree['sekretariat']['wakil']; @endphp
                                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-teal-100 dark:border-teal-950 shadow-sm hover:shadow transition-all">
                                        <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-950 text-teal-700 flex items-center justify-center font-bold overflow-hidden flex-shrink-0 aspect-square ring-1 ring-teal-200 dark:ring-teal-800">
                                            <img src="{{ $wsec->foto_url }}" alt="{{ $wsec->nama }}" width="48" height="48" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <span class="inline-block px-2 py-0.5 rounded text-[9px] font-black uppercase text-teal-700 bg-teal-50 dark:bg-teal-950/80 dark:text-teal-300 border border-teal-200 mb-0.5">
                                                {{ $wsec->jabatan }}
                                            </span>
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" title="{{ $wsec->nama }}">{{ $wsec->nama }}</h4>
                                            <div class="flex items-center gap-2 mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">
                                                <span class="font-mono">{{ $wsec->nomor_kartu ?? '-' }}</span>
                                                <span>•</span>
                                                <span class="font-bold text-[9px] {{ $wsec->ukw_badge_color }} px-1.5 rounded">{{ $wsec->tingkat_ukw }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 3. KLASTER KEBENDAHARAAN (Kanan) -->
                    <div class="flex flex-col items-center">
                        <div class="w-0.5 h-6 bg-blue-600 -mt-6"></div>
                        <div class="w-full max-w-sm rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900/60 p-4 space-y-3">
                            <div class="text-center pb-2 border-b border-emerald-200 dark:border-emerald-900/40">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-700 dark:text-emerald-300 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-coins"></i>
                                    <span>Kebendaharaan Organisasi</span>
                                </span>
                            </div>

                            <div class="space-y-2.5">
                                @if($tree['kebendaharaan']['utama'])
                                    @php $ben = $tree['kebendaharaan']['utama']; @endphp
                                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-emerald-200 dark:border-emerald-950 shadow-sm hover:shadow transition-all ring-1 ring-emerald-400/30">
                                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-700 flex items-center justify-center font-bold overflow-hidden flex-shrink-0 aspect-square ring-1 ring-emerald-300 dark:ring-emerald-700">
                                            <img src="{{ $ben->foto_url }}" alt="{{ $ben->nama }}" width="48" height="48" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <span class="inline-block px-2 py-0.5 rounded text-[9px] font-black uppercase text-emerald-800 bg-emerald-100 dark:bg-emerald-900/60 dark:text-emerald-200 mb-0.5">
                                                {{ $ben->jabatan }}
                                            </span>
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" title="{{ $ben->nama }}">{{ $ben->nama }}</h4>
                                            <div class="flex items-center gap-2 mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">
                                                <span class="font-mono">{{ $ben->nomor_kartu ?? '-' }}</span>
                                                <span>•</span>
                                                <span class="font-bold text-[9px] {{ $ben->ukw_badge_color }} px-1.5 rounded">{{ $ben->tingkat_ukw }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($tree['kebendaharaan']['wakil'])
                                    @php $wben = $tree['kebendaharaan']['wakil']; @endphp
                                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-emerald-100 dark:border-emerald-950 shadow-sm hover:shadow transition-all">
                                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-700 flex items-center justify-center font-bold overflow-hidden flex-shrink-0 aspect-square ring-1 ring-emerald-200 dark:ring-emerald-800">
                                            <img src="{{ $wben->foto_url }}" alt="{{ $wben->nama }}" width="48" height="48" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <span class="inline-block px-2 py-0.5 rounded text-[9px] font-black uppercase text-emerald-700 bg-emerald-50 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-200 mb-0.5">
                                                {{ $wben->jabatan }}
                                            </span>
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" title="{{ $wben->nama }}">{{ $wben->nama }}</h4>
                                            <div class="flex items-center gap-2 mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">
                                                <span class="font-mono">{{ $wben->nomor_kartu ?? '-' }}</span>
                                                <span>•</span>
                                                <span class="font-bold text-[9px] {{ $wben->ukw_badge_color }} px-1.5 rounded">{{ $wben->tingkat_ukw }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Central Bus Connector from Executives Down into 7 Divisions -->
            <div class="flex flex-col items-center -my-2">
                <div class="w-1 h-8 bg-blue-600"></div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-black text-white bg-blue-600 shadow-md uppercase tracking-wider">
                    <i class="fa-solid fa-arrow-down"></i>
                    <span>Garis Instruksi & Garis Komando Bidang Operasional</span>
                </div>
                <div class="w-1 h-8 bg-blue-600"></div>
            </div>

            <!-- ========================================== -->
            <!-- LEVEL 3: 7 BIDANG KERJA (PILAR-PILAR OPERASIONAL) -->
            <!-- ========================================== -->
            <div class="relative">
                <!-- Massive Horizontal Connector across all 7 Bidangs -->
                <div class="absolute top-0 left-6 right-6 h-1 bg-gradient-to-r from-amber-500 via-blue-600 to-teal-500 rounded-full"></div>

                <div class="grid grid-cols-7 gap-3.5 pt-6">
                    @foreach($tree['bidangs'] as $bKey => $b)
                        <div class="flex flex-col items-center">
                            <!-- Dropdown connector into each column -->
                            <div class="w-0.5 h-6 bg-blue-600 -mt-6"></div>

                            <!-- Bidang Pillar Container -->
                            <div class="w-full rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm p-3 flex flex-col justify-between hover:shadow-lg transition-all space-y-3">
                                
                                <!-- Bidang Header Title -->
                                <div class="text-center pb-2 border-b border-slate-100 dark:border-slate-800">
                                    <div class="w-8 h-8 rounded-lg mx-auto mb-1 flex items-center justify-center text-xs font-bold shadow-sm 
                                        {{ $b['info']['color'] === 'amber' ? 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400' : '' }}
                                        {{ $b['info']['color'] === 'emerald' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400' : '' }}
                                        {{ $b['info']['color'] === 'blue' ? 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-400' : '' }}
                                        {{ $b['info']['color'] === 'indigo' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-400' : '' }}
                                        {{ $b['info']['color'] === 'rose' ? 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-400' : '' }}
                                        {{ $b['info']['color'] === 'violet' ? 'bg-violet-100 text-violet-700 dark:bg-violet-950 dark:text-violet-400' : '' }}
                                        {{ $b['info']['color'] === 'cyan' ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-400' : '' }}">
                                        <i class="fa-solid {{ $b['info']['icon'] }}"></i>
                                    </div>
                                    <h4 class="text-[11px] font-black text-slate-900 dark:text-white leading-tight uppercase">
                                        {{ $b['info']['title'] }}
                                    </h4>
                                </div>

                                <!-- Sequential Hierarchy Cards inside the Bidang (Kabid -> Wakabid -> Anggota) -->
                                <div class="space-y-2">
                                    @forelse($b['members'] as $idx => $m)
                                        @if($idx > 0)
                                            <!-- Instruction connector between members within the same division -->
                                            <div class="flex justify-center -my-1">
                                                <div class="w-0.5 h-3 bg-slate-300 dark:bg-slate-700"></div>
                                            </div>
                                        @endif

                                        <div class="p-2 rounded-xl border text-center transition-all 
                                            {{ $idx === 0 ? 'bg-slate-50 dark:bg-slate-800/80 border-slate-300 dark:border-slate-700 shadow-sm' : 'bg-white dark:bg-slate-950 border-slate-200 dark:border-slate-800' }}">
                                            
                                            <!-- Mini Role Label -->
                                            <div class="text-[9px] font-black uppercase tracking-wider mb-1 truncate
                                                {{ $idx === 0 ? 'text-blue-700 dark:text-blue-400' : ($idx === 1 ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400') }}">
                                                {{ $m->jabatan }}
                                            </div>

                                            <!-- Photo -->
                                            <div class="w-10 h-10 rounded-xl overflow-hidden mx-auto mb-1 ring-1 ring-slate-200 dark:ring-slate-700 shadow-sm">
                                                <img src="{{ $m->foto_url }}" alt="{{ $m->nama }}" width="40" height="40" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                            </div>

                                            <!-- Name -->
                                            <h5 class="text-[11px] font-bold text-slate-900 dark:text-white leading-tight line-clamp-2" title="{{ $m->nama }}">
                                                {{ $m->nama }}
                                            </h5>

                                            <!-- UKW badge -->
                                            <div class="mt-1">
                                                <span class="inline-block text-[8px] font-bold px-1.5 py-0.5 rounded {{ $m->ukw_badge_color }}">
                                                    {{ $m->tingkat_ukw }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-slate-400 text-[10px]">
                                            Belum ada pengurus
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ========================================== -->
            <!-- LEVEL 4: ANGGOTA UMUM                      -->
            <!-- ========================================== -->
            @if($tree['anggota_umum']->count() > 0)
                <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex flex-col items-center mb-4">
                        <div class="w-1 h-6 bg-slate-300 dark:bg-slate-700 -mt-4"></div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 uppercase tracking-wider">
                            <i class="fa-solid fa-users"></i> Jajaran Anggota Kepengurusan
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center justify-center gap-3">
                        @foreach($tree['anggota_umum'] as $ag)
                            <div class="flex items-center gap-2.5 p-2 px-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 min-w-[200px]">
                                <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0 ring-1 ring-slate-300 dark:ring-slate-600">
                                    <img src="{{ $ag->foto_url }}" alt="{{ $ag->nama }}" width="32" height="32" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0 flex-grow">
                                    <h6 class="text-[11px] font-bold text-slate-900 dark:text-white truncate" title="{{ $ag->nama }}">{{ $ag->nama }}</h6>
                                    <div class="text-[9px] text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                        <span class="font-bold uppercase text-[8px] px-1 rounded bg-slate-200 dark:bg-slate-700">ANGGOTA</span>
                                        <span>•</span>
                                        <span class="font-mono">{{ $ag->nomor_kartu ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Watermark Footer on Canvas -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[10px] text-slate-400 font-semibold">
                <span>Dikeluarkan oleh Sekretariat PWI Kabupaten Banyuasin • Sistem Informasi MIS PWI</span>
                <span>Dokumen Bagan Resmi 32 Pejabat Pengurus • Dicetak: {{ date('d-m-Y') }}</span>
            </div>

        </div>

    </div>

</div>
