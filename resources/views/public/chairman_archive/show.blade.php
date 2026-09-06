@extends('layouts.public')

@section('title', $article->title . ' - Arsip Wardoyo')
@section('meta_description', Str::limit(strip_tags($article->excerpt), 150))

@section('content')
<div class="py-10 sm:py-14 bg-slate-50 dark:bg-slate-950 transition-colors duration-200" x-data="{ copied: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('home') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Beranda</a>
            <span>/</span>
            <a href="{{ route('chairman.archive.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 font-bold">Arsip Wardoyo</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-slate-200 font-semibold truncate max-w-xs">{{ $article->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
            
            <!-- Main Content Area (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <article class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-10 shadow-sm space-y-6">
                    
                    <!-- Top Category & Time Pill -->
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800/80">
                            <i class="fa-solid fa-tag text-[10px]"></i>
                            <span>{{ $article->category }}</span>
                        </span>

                        <div class="flex items-center gap-3 text-xs text-slate-400">
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $article->reading_time }} mnt baca</span>
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-eye"></i>
                                <span>{{ number_format($article->views_count) }} pembaca</span>
                            </span>
                        </div>
                    </div>

                    <!-- Article Headline -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white leading-tight tracking-tight">
                        {{ $article->title }}
                    </h1>

                    <!-- Author & Attribution Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-4 py-4 border-y border-slate-100 dark:border-slate-800 text-xs text-slate-500 dark:text-slate-400">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-[#0B132B] text-amber-400 flex items-center justify-center font-bold text-sm shadow-md ring-1 ring-amber-400/30">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <div>
                                <span class="block font-black text-slate-900 dark:text-white">{{ $profile['name'] }}</span>
                                <span class="text-[11px] text-amber-600 dark:text-amber-400 font-semibold">{{ $profile['title'] }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar-check text-slate-400"></i>
                            <span class="font-medium">{{ $article->published_at ? $article->published_at->translatedFormat('l, d F Y') : '-' }}</span>
                        </div>
                    </div>

                    <!-- Original Source Notice Banner -->
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/80 text-xs text-amber-900 dark:text-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-brands fa-wordpress text-lg text-amber-600 dark:text-amber-400 shrink-0"></i>
                            <span>Dokumentasi tulisan arsip resmi dari portal <strong>wardianst.wordpress.com</strong></span>
                        </div>
                        @if($article->original_url)
                            <a href="{{ $article->original_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs shadow-sm transition-all flex items-center gap-1.5 shrink-0">
                                <span>Lihat Postingan Asli</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        @endif
                    </div>

                    <!-- Article Sanitized Rich Content -->
                    <div class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-200 text-sm sm:text-base leading-relaxed space-y-4 pt-2">
                        {!! $article->content !!}
                    </div>

                    <!-- Article Share Bar -->
                    <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                            Bagikan Tulisan Ini:
                        </span>

                        <div class="flex items-center gap-2">
                            <!-- WhatsApp Share -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center text-sm shadow-md transition-all" title="Bagikan ke WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <!-- Facebook Share -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center text-sm shadow-md transition-all" title="Bagikan ke Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <!-- Twitter / X Share -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-slate-900 hover:bg-slate-800 text-white flex items-center justify-center text-sm shadow-md transition-all" title="Bagikan ke X">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            <!-- Copy Link Button -->
                            <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2500)" class="px-3.5 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs flex items-center gap-1.5 transition-all cursor-pointer">
                                <i class="fa-solid" :class="copied ? 'fa-check text-emerald-500' : 'fa-link'"></i>
                                <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'"></span>
                            </button>
                        </div>
                    </div>

                </article>

                <!-- Previous & Next Navigation -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($previous)
                        <a href="{{ route('chairman.archive.show', $previous->slug) }}" class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-blue-500 transition-all group flex flex-col justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-arrow-left"></i>
                                <span>Tulisan Sebelumnya</span>
                            </span>
                            <p class="text-xs font-bold text-slate-900 dark:text-white mt-1.5 group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors line-clamp-2">
                                {{ $previous->title }}
                            </p>
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($next)
                        <a href="{{ route('chairman.archive.show', $next->slug) }}" class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-blue-500 transition-all group flex flex-col justify-between text-right">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center justify-end gap-1">
                                <span>Tulisan Selanjutnya</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                            <p class="text-xs font-bold text-slate-900 dark:text-white mt-1.5 group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors line-clamp-2">
                                {{ $next->title }}
                            </p>
                        </a>
                    @endif
                </div>

            </div>

            <!-- Sidebar Area (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Author Profile Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-5">
                    <div class="flex items-center gap-3.5 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-700 to-slate-900 text-amber-400 flex items-center justify-center font-bold text-lg shadow-md shrink-0 ring-1 ring-amber-400/40">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">{{ $profile['name'] }}</h3>
                            <p class="text-xs font-bold text-amber-600 dark:text-amber-400">{{ $profile['title'] }}</p>
                            <p class="text-[10px] text-slate-400">{{ $profile['sk_resmi'] }}</p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                        Wartawan Utama Dewan Pers, Magister Ilmu Komunikasi Politik STISIPOL Candradimuka, dan pegiat advokasi jurnalisme di Kabupaten Banyuasin, Sumatera Selatan.
                    </p>

                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60">
                            <span class="text-slate-500 dark:text-slate-400">Kompetensi Pers:</span>
                            <span class="font-extrabold text-emerald-600 dark:text-emerald-400">UKW Utama Dewan Pers</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60">
                            <span class="text-slate-500 dark:text-slate-400">Alumni SJI:</span>
                            <span class="font-bold text-slate-900 dark:text-white">Angkatan III Palembang (2011)</span>
                        </div>
                    </div>

                    <a href="{{ route('chairman.archive.index') }}" class="w-full py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all flex items-center justify-center gap-2 shadow-md">
                        <i class="fa-solid fa-boxes-packing"></i>
                        <span>Lihat Semua 320 Tulisan</span>
                    </a>
                </div>

                <!-- Related Articles in Same Category -->
                @if($related->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                            <i class="fa-solid fa-layer-group text-blue-600 dark:text-amber-400"></i>
                            <span>Tulisan Serupa ({{ $article->category }})</span>
                        </h4>

                        <div class="space-y-3">
                            @foreach($related as $rel)
                                <a href="{{ route('chairman.archive.show', $rel->slug) }}" class="block p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group">
                                    <h5 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors line-clamp-2 leading-snug">
                                        {{ $rel->title }}
                                    </h5>
                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 mt-1">
                                        <span><i class="fa-regular fa-calendar text-[10px]"></i> {{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : '-' }}</span>
                                        <span>•</span>
                                        <span>{{ $rel->reading_time }} mnt baca</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Original Blog Reference Card -->
                <div class="p-5 rounded-3xl bg-gradient-to-br from-[#0B132B] to-[#1C2541] text-white border border-blue-900/60 shadow-xl space-y-3">
                    <div class="flex items-center gap-2.5 text-amber-400">
                        <i class="fa-brands fa-wordpress text-xl"></i>
                        <span class="text-xs font-black uppercase tracking-wider">Arsip Blog Wardiansyah</span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Blog pribadi <strong>wardianst.wordpress.com</strong> merupakan wadah arsip digital catatan pribadi, pemikiran, dan rilis sejak tahun 2007.
                    </p>
                    <a href="https://wardianst.wordpress.com/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs font-extrabold text-amber-300 hover:text-amber-200 underline pt-1">
                        <span>Buka Tautan Blog Asli</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
