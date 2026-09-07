@extends('layouts.public')

@section('title', 'Galeri Video & Liputan Media PWI Kabupaten Banyuasin')

@section('content')
<!-- Header Banner -->
<div class="gradient-mesh text-white py-16 relative overflow-hidden text-center sm:text-left">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="max-w-3xl mx-auto sm:mx-0 flex flex-col items-center sm:items-start">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-white/10 px-3.5 py-1 rounded-full border border-white/15">
                    Dokumentasi Multimedia & Liputan Televisi
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-3">
                    Galeri Video & Liputan Resmi PWI
                </h1>
                <p class="text-slate-300 text-sm sm:text-base mt-2">
                    Saksikan tayangan liputan media televisi (TVRI, PalTV) dan rekaman audio-visual ragam kegiatan insan pers PWI Kabupaten Banyuasin.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('gallery.public') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition-all shadow-md">
                    <i class="fa-solid fa-images text-sky-400"></i>
                    <span>Beralih ke Galeri Foto</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="py-16 bg-slate-50 dark:bg-slate-950 transition-colors duration-200" 
     x-data="{ 
         selectedVideo: null 
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-brands fa-youtube text-amber-500 text-2xl"></i>
                    <span>Daftar Video Liputan Terkini</span>
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Klik salah satu video untuk memutar langsung di website</p>
            </div>
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-200/60 dark:bg-slate-900 px-3 py-1 rounded-xl">
                {{ $videos->total() }} Video
            </span>
        </div>

        <!-- Video Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            @forelse($videos as $v)
                <div @click="selectedVideo = { id: '{{ $v->youtube_id }}', title: '{{ addslashes($v->judul) }}', date: '{{ $v->tanggal ? $v->tanggal->translatedFormat('d F Y') : '-' }}', desc: '{{ addslashes($v->deskripsi) }}', url: '{{ $v->youtube_url }}' }" 
                     class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all duration-300 group cursor-pointer hover:-translate-y-1 flex flex-col">
                    
                    <!-- Video Thumbnail with Play Button -->
                    <div class="relative aspect-video bg-slate-950 overflow-hidden">
                        <img src="{{ $v->thumbnail_url }}" alt="{{ $v->judul }}" width="640" height="360" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-slate-950/30 group-hover:bg-slate-950/50 transition-colors"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-3.5 left-3.5 flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500 text-slate-950 text-[10px] font-black uppercase tracking-wider shadow-md">
                            <i class="fa-brands fa-youtube"></i>
                            <span>YouTube Video</span>
                        </div>

                        <!-- Large Play Button Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-amber-500/90 text-slate-950 flex items-center justify-center shadow-2xl group-hover:scale-115 group-hover:bg-amber-400 transition-all duration-300 ring-4 ring-white/20">
                                <i class="fa-solid fa-play text-xl ml-1"></i>
                            </div>
                        </div>

                        <div class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg bg-black/80 text-white text-[10px] font-bold backdrop-blur-xs">
                            <i class="fa-solid fa-expand text-[9px] me-1"></i> Putar Video
                        </div>
                    </div>

                    <!-- Video Meta & Title -->
                    <div class="p-6 flex flex-col justify-between flex-grow">
                        <div>
                            <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider block mb-2">
                                <i class="fa-regular fa-calendar me-1"></i> {{ $v->tanggal ? $v->tanggal->translatedFormat('d F Y') : '-' }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                                {{ $v->judul }}
                            </h3>
                            @if($v->deskripsi)
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $v->deskripsi }}
                                </p>
                            @endif
                        </div>
                        <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-amber-600 dark:text-amber-400">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-play"></i> Tonton Sekarang
                            </span>
                            <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-2 text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 text-slate-500">
                    Belum ada video liputan galeri yang dipublikasikan.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($videos->hasPages())
            <div class="mt-12 w-full">
                {{ $videos->links() }}
            </div>
        @endif

        <!-- Modal Player for YouTube Videos -->
        <div x-show="selectedVideo" 
             x-cloak 
             @click="selectedVideo = null"
             @keydown.escape.window="selectedVideo = null"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md cursor-pointer">
            <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-2xl cursor-default" 
                 @click.stop>
                <div class="p-4 sm:p-5 flex items-center justify-between border-b border-white/10 bg-slate-950/80">
                    <div class="flex items-center gap-2.5 text-white font-bold text-sm truncate pr-4">
                        <i class="fa-brands fa-youtube text-amber-400 text-lg"></i>
                        <span x-text="selectedVideo ? selectedVideo.title : 'Video Liputan'"></span>
                    </div>
                    <button type="button" @click="selectedVideo = null" class="w-8 h-8 rounded-full bg-white/10 text-white hover:bg-white/20 flex items-center justify-center cursor-pointer transition-colors shrink-0" title="Tutup Video">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="aspect-video w-full bg-black">
                    <template x-if="selectedVideo">
                        <iframe :src="'https://www.youtube-nocookie.com/embed/' + selectedVideo.id + '?autoplay=1&rel=0'" 
                                class="w-full h-full border-0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen></iframe>
                    </template>
                </div>

                <div class="p-5 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="text-xs text-amber-400 font-semibold" x-text="selectedVideo ? selectedVideo.date : ''"></div>
                        <h4 class="text-sm font-bold text-white mt-0.5" x-text="selectedVideo ? selectedVideo.title : ''"></h4>
                        <p class="text-xs text-slate-300 mt-1 line-clamp-2" x-text="selectedVideo ? selectedVideo.desc : ''"></p>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <a :href="selectedVideo ? selectedVideo.url : '#'" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-colors">
                            <i class="fa-brands fa-youtube"></i>
                            <span>Buka di YouTube</span>
                        </a>
                        <button type="button" @click="selectedVideo = null" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition-colors cursor-pointer">
                            Tutup Video
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
