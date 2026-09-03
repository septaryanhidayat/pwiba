@extends('layouts.admin')

@section('title', 'Dashboard MIS')
@section('page_title', 'Dashboard Manajemen Sistem')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action & Welcome Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">Executive Panel</span>
                <span class="text-xs text-slate-500 dark:text-slate-400">PWI Kabupaten Banyuasin</span>
            </div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white">Ringkasan & Metrik Operasional Organisasi</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">Pantau publikasi berita, persuratan resmi, hasil notulen rapat, dan sertifikasi anggota</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-pen-nib"></i>
                <span>Tulis Berita</span>
            </a>
            <a href="{{ route('admin.letters.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 shadow-sm transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-envelope-open-text"></i>
                <span>Buat Surat</span>
            </a>
            <a href="{{ route('admin.meetings.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Catat Notulen</span>
            </a>
        </div>
    </div>

    <!-- 4 Kotak-Kotak Angka Berwarna-Warni & Menarik (Vibrant Gradients) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Belum UKW (Indigo / Purple Gradient) -->
        <div class="p-6 rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-900 text-white shadow-xl shadow-indigo-600/20 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <!-- Background Glow Circle -->
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-extrabold uppercase tracking-wider text-indigo-200">Belum UKW</span>
                <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-xl text-white shadow-inner">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
            </div>
            
            <div class="mt-4 flex items-baseline gap-2 relative z-10">
                <span class="text-4xl font-black tracking-tight text-white">{{ $ukwStats['belum_ukw'] }}</span>
                <span class="text-xs font-semibold text-indigo-200">Wartawan</span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4 relative z-10">
                <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-indigo-300 h-1.5 rounded-full" style="width: {{ round(($ukwStats['belum_ukw'] / max(1, $ukwStats['total_aktif'])) * 100) }}%"></div>
                </div>
            </div>
            
            <div class="mt-3 pt-3 border-t border-white/15 flex items-center justify-between text-xs text-indigo-200 relative z-10 font-medium">
                <span>Porsi: <strong>{{ round(($ukwStats['belum_ukw'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</strong></span>
                <span class="px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-bold">Anggota Muda</span>
            </div>
        </div>

        <!-- Card 2: Wartawan Muda (Emerald / Teal Gradient) -->
        <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-500 via-teal-700 to-emerald-950 text-white shadow-xl shadow-emerald-600/20 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-200">Wartawan Muda</span>
                <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-xl text-white shadow-inner">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </div>
            
            <div class="mt-4 flex items-baseline gap-2 relative z-10">
                <span class="text-4xl font-black tracking-tight text-white">{{ $ukwStats['muda'] }}</span>
                <span class="text-xs font-semibold text-emerald-200">Wartawan</span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4 relative z-10">
                <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-emerald-300 h-1.5 rounded-full" style="width: {{ round(($ukwStats['muda'] / max(1, $ukwStats['total_aktif'])) * 100) }}%"></div>
                </div>
            </div>
            
            <div class="mt-3 pt-3 border-t border-white/15 flex items-center justify-between text-xs text-emerald-200 relative z-10 font-medium">
                <span>Porsi: <strong>{{ round(($ukwStats['muda'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</strong></span>
                <span class="px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-bold">UKW Tingkat Muda</span>
            </div>
        </div>

        <!-- Card 3: Wartawan Madya (Royal Blue / Cyan Gradient) -->
        <div class="p-6 rounded-3xl bg-gradient-to-br from-blue-600 via-cyan-700 to-blue-950 text-white shadow-xl shadow-blue-600/20 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-200">Wartawan Madya</span>
                <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-xl text-white shadow-inner">
                    <i class="fa-solid fa-medal"></i>
                </div>
            </div>
            
            <div class="mt-4 flex items-baseline gap-2 relative z-10">
                <span class="text-4xl font-black tracking-tight text-white">{{ $ukwStats['madya'] }}</span>
                <span class="text-xs font-semibold text-cyan-200">Wartawan</span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4 relative z-10">
                <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-cyan-300 h-1.5 rounded-full" style="width: {{ round(($ukwStats['madya'] / max(1, $ukwStats['total_aktif'])) * 100) }}%"></div>
                </div>
            </div>
            
            <div class="mt-3 pt-3 border-t border-white/15 flex items-center justify-between text-xs text-cyan-200 relative z-10 font-medium">
                <span>Porsi: <strong>{{ round(($ukwStats['madya'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</strong></span>
                <span class="px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-bold">UKW Tingkat Madya</span>
            </div>
        </div>

        <!-- Card 4: Wartawan Utama (Crimson / Ruby / Gold Gradient) -->
        <div class="p-6 rounded-3xl bg-gradient-to-br from-rose-600 via-red-700 to-amber-900 text-white shadow-xl shadow-rose-600/20 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-extrabold uppercase tracking-wider text-rose-200">Wartawan Utama</span>
                <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-xl text-white shadow-inner">
                    <i class="fa-solid fa-crown"></i>
                </div>
            </div>
            
            <div class="mt-4 flex items-baseline gap-2 relative z-10">
                <span class="text-4xl font-black tracking-tight text-white">{{ $ukwStats['utama'] }}</span>
                <span class="text-xs font-semibold text-rose-200">Wartawan</span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4 relative z-10">
                <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-amber-300 h-1.5 rounded-full" style="width: {{ round(($ukwStats['utama'] / max(1, $ukwStats['total_aktif'])) * 100) }}%"></div>
                </div>
            </div>
            
            <div class="mt-3 pt-3 border-t border-white/15 flex items-center justify-between text-xs text-rose-200 relative z-10 font-medium">
                <span>Porsi: <strong>{{ round(($ukwStats['utama'] / max(1, $ukwStats['total_aktif'])) * 100) }}%</strong></span>
                <span class="px-2 py-0.5 rounded-md bg-amber-400 text-slate-950 text-[10px] font-black uppercase">Tingkat Tertinggi</span>
            </div>
        </div>

    </div>

    <!-- Ringkasan Cepat Angka Portal (4 Key Indicators) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="text-lg font-black text-slate-900 dark:text-white">{{ $totalNews }} Berita</div>
                <div class="text-[11px] text-slate-500 font-medium">{{ number_format($totalViews) }} Kali Dibaca</div>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
            <div>
                <div class="text-lg font-black text-slate-900 dark:text-white">{{ $totalLettersOut }} Surat Keluar</div>
                <div class="text-[11px] text-slate-500 font-medium">{{ $totalLettersIn }} Surat Masuk</div>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <div>
                <div class="text-lg font-black text-slate-900 dark:text-white">{{ $totalMeetings }} Rapat</div>
                <div class="text-[11px] text-slate-500 font-medium">Notulen & Presensi Sah</div>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-900/40 dark:text-purple-400 flex items-center justify-center text-lg">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="text-lg font-black text-slate-900 dark:text-white">{{ $totalInboxes }} Aspirasi</div>
                <div class="text-[11px] {{ $unreadInboxes > 0 ? 'text-rose-600 font-bold' : 'text-slate-500 font-medium' }}">
                    {{ $unreadInboxes }} Belum Dibaca
                </div>
            </div>
        </div>
    </div>

    <!-- Row 1: CMS Berita Terkini & Persuratan Resmi Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Panel 1: Publikasi Berita Terkini -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">Publikasi Berita & Media</h3>
                            <p class="text-[11px] text-slate-500">Artikel jurnalistik terkini di website resmi</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.posts.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Semua Berita <i class="fa-solid fa-chevron-right text-[10px] ms-0.5"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($latestPosts as $post)
                        <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors flex items-center gap-4">
                            <div class="w-16 h-12 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0 shadow-sm">
                                <img src="{{ $post->gambar_url }}" alt="{{ $post->judul }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        {{ $post->kategori ?? 'Berita' }}
                                    </span>
                                    <span class="text-[11px] text-slate-400">
                                        <i class="fa-regular fa-clock text-[10px]"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : '-' }}
                                    </span>
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate leading-tight hover:text-blue-600 transition-colors">
                                    <a href="{{ route('news.show', $post->slug) }}" target="_blank">
                                        {{ $post->judul }}
                                    </a>
                                </h4>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                    <i class="fa-solid fa-eye text-[10px] text-slate-400"></i> {{ number_format($post->views_count) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-400">Belum ada berita terpublikasi.</div>
                    @endforelse
                </div>
            </div>

            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 flex items-center justify-between text-xs">
                <span class="text-slate-500">Total: <strong>{{ $totalNews }}</strong> Berita Terpublikasi</span>
                <a href="{{ route('admin.posts.create') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline">
                    + Tambah Berita Baru
                </a>
            </div>
        </div>

        <!-- Panel 2: Persuratan Resmi Terbaru -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-stamp"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">Persuratan Keluar Terbaru</h3>
                            <p class="text-[11px] text-slate-500">Arsip surat resmi dengan verifikasi digital QR</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.letters.index') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline">
                        Buku Register <i class="fa-solid fa-chevron-right text-[10px] ms-0.5"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($latestLetters as $letter)
                        <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-mono text-[11px] font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 px-2 py-0.5 rounded">
                                        {{ $letter->nomor_surat }}
                                    </span>
                                    <span class="text-[11px] text-slate-400">
                                        {{ $letter->tanggal ? $letter->tanggal->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                    {{ $letter->perihal ?? $letter->keperluan }}
                                </h4>
                                <p class="text-[11px] text-slate-500 truncate">
                                    Tujuan: <strong>{{ $letter->tujuan }}</strong>
                                </p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                <span class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-400">
                                    <i class="fa-solid fa-shield-check text-[9px]"></i> Sah
                                </span>
                                <a href="{{ route('admin.letters.print', $letter->id) }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-600 flex items-center justify-center text-xs transition-colors shadow-sm" title="Cetak Surat">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-400">Belum ada surat tercatat.</div>
                    @endforelse
                </div>
            </div>

            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 flex items-center justify-between text-xs">
                <span class="text-slate-500">Total: <strong>{{ $totalLettersOut }}</strong> Surat Keluar</span>
                <a href="{{ route('admin.letters.create') }}" class="font-bold text-amber-600 dark:text-amber-400 hover:underline">
                    + Buat Surat Baru
                </a>
            </div>
        </div>

    </div>

    <!-- Row 2: Agenda Notulen Rapat & Buku Tamu Publik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Panel 3: Agenda & Notulensi Rapat -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">Agenda & Notulen Rapat</h3>
                            <p class="text-[11px] text-slate-500">Dokumentasi hasil musyawarah & rekap kehadiran anggota</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.meetings.index') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                        Semua Notulen <i class="fa-solid fa-chevron-right text-[10px] ms-0.5"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($latestMeetings as $meet)
                        <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[11px] font-semibold text-slate-500">
                                        <i class="fa-regular fa-calendar text-[10px]"></i> {{ $meet->tanggal ? $meet->tanggal->format('d F Y') : '-' }}
                                    </span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-400">
                                        {{ $meet->attendances_count }} Hadir/Peserta
                                    </span>
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                    {{ $meet->judul_rapat }}
                                </h4>
                                <p class="text-[11px] text-slate-500 truncate">
                                    Pemimpin: {{ $meet->pemimpin_rapat }} | Lokasi: {{ $meet->tempat }}
                                </p>
                            </div>
                            <div class="shrink-0">
                                <a href="{{ route('admin.meetings.print', $meet->id) }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-600 flex items-center justify-center text-xs transition-colors shadow-sm" title="Cetak Lembar Notulen">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-400">Belum ada rapat dicatat.</div>
                    @endforelse
                </div>
            </div>

            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 flex items-center justify-between text-xs">
                <span class="text-slate-500">Total: <strong>{{ $totalMeetings }}</strong> Notulen Resmi</span>
                <a href="{{ route('admin.meetings.create') }}" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                    + Catat Rapat Baru
                </a>
            </div>
        </div>

        <!-- Panel 4: Buku Tamu & Aspirasi Publik -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">Buku Tamu & Aspirasi Publik</h3>
                            <p class="text-[11px] text-slate-500">Pesan dan aspirasi yang masuk dari masyarakat / instansi</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.inbox.index') }}" class="text-xs font-bold text-purple-600 dark:text-purple-400 hover:underline">
                        Lihat Semua <i class="fa-solid fa-chevron-right text-[10px] ms-0.5"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($latestInboxes as $inbox)
                        <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $inbox->nama }}</span>
                                    @if($inbox->instansi)
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-semibold">{{ $inbox->instansi }}</span>
                                    @endif
                                    <span class="text-[11px] text-slate-400">{{ $inbox->tanggal ? $inbox->tanggal->diffForHumans() : '-' }}</span>
                                </div>
                                <h4 class="text-xs font-semibold text-slate-700 dark:text-slate-300 truncate">
                                    {{ $inbox->keperluan ?? $inbox->pesan }}
                                </h4>
                            </div>
                            <div class="shrink-0">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold {{ $inbox->status === 'belum_dibaca' ? 'bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-950/60 dark:text-rose-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                                    {{ $inbox->status === 'belum_dibaca' ? 'Baru' : 'Dibaca' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-400">Belum ada pesan masuk.</div>
                    @endforelse
                </div>
            </div>

            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 flex items-center justify-between text-xs">
                <span class="text-slate-500">Total: <strong>{{ $totalInboxes }}</strong> Pesan Masuk</span>
                <a href="{{ route('admin.inbox.index') }}" class="font-bold text-purple-600 dark:text-purple-400 hover:underline">
                    Buka Kotak Masuk
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
