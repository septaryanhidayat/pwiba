@extends('layouts.public')

@section('title', 'Galeri Foto & Dokumentasi Kegiatan PWI Kabupaten Banyuasin')

@section('content')
<!-- Header Banner -->
<div class="gradient-mesh text-white py-16 relative overflow-hidden text-center sm:text-left">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl mx-auto sm:mx-0 flex flex-col items-center sm:items-start">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-white/10 px-3.5 py-1 rounded-full border border-white/15">
                Dokumentasi Visual & Liputan Multimedia
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-3">
                Galeri Foto & Dokumentasi Kegiatan PWI
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-2">
                Dokumentasi ragam aktivitas jurnalistik, peringatan Hari Pers Nasional, audiensi pemerintah daerah, dan tayangan liputan video resmi PWI Banyuasin.
            </p>
        </div>
    </div>
</div>

<div class="py-16 bg-slate-50 dark:bg-slate-950 transition-colors duration-200" 
     x-data="{ 
         currentTab: 'semua',
         selectedPhoto: null, 
         selectedTitle: '', 
         selectedDate: '', 
         selectedDesc: '',
         selectedVideo: null
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter Tabs (Semua, Video YouTube, Foto Kegiatan) -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-10 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-2 p-1.5 bg-slate-200/60 dark:bg-slate-900 rounded-2xl border border-slate-300/60 dark:border-slate-800">
                <button @click="currentTab = 'semua'" 
                        :class="currentTab === 'semua' ? 'bg-white dark:bg-blue-600 text-slate-900 dark:text-white shadow-sm font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-amber-500"></i>
                    <span>Semua Koleksi</span>
                </button>

                <button @click="currentTab = 'video'" 
                        :class="currentTab === 'video' ? 'bg-white dark:bg-red-600 text-slate-900 dark:text-white shadow-sm font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer flex items-center gap-2">
                    <i class="fa-brands fa-youtube text-red-500" :class="currentTab === 'video' ? 'text-red-500 dark:text-white' : ''"></i>
                    <span>Galeri Video ({{ $videos->count() }})</span>
                </button>

                <button @click="currentTab = 'foto'" 
                        :class="currentTab === 'foto' ? 'bg-white dark:bg-blue-600 text-slate-900 dark:text-white shadow-sm font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-images text-sky-500"></i>
                    <span>Galeri Foto ({{ $galleries->total() }})</span>
                </button>
            </div>

            <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                Menampilkan dokumentasi resmi & liputan media
            </div>
        </div>

        <!-- Section 1: Galeri Video YouTube (Tampil jika tab 'semua' atau 'video') -->
        <div x-show="currentTab === 'semua' || currentTab === 'video'" x-cloak class="mb-14">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-red-600/10 dark:bg-red-600/20 text-red-600 flex items-center justify-center font-bold">
                        <i class="fa-brands fa-youtube text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">
                            Galeri Video & Liputan Media
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Liputan berita televisi dan dokumentasi video kegiatan PWI Banyuasin</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
                @forelse($videos as $v)
                    <div @click="selectedVideo = { id: '{{ $v->youtube_id }}', title: '{{ addslashes($v->judul) }}', date: '{{ $v->tanggal ? $v->tanggal->translatedFormat('d F Y') : '-' }}', desc: '{{ addslashes($v->deskripsi) }}', url: '{{ $v->youtube_url }}' }" 
                         class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all duration-300 group cursor-pointer hover:-translate-y-1 flex flex-col">
                        
                        <!-- Video Thumbnail with Play Button -->
                        <div class="relative aspect-video bg-slate-950 overflow-hidden">
                            <img src="{{ $v->thumbnail_url }}" alt="{{ $v->judul }}" width="640" height="360" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-slate-950/30 group-hover:bg-slate-950/50 transition-colors"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-600 text-white text-[10px] font-black uppercase tracking-wider shadow-md">
                                <i class="fa-brands fa-youtube"></i>
                                <span>YouTube Video</span>
                            </div>

                            <!-- Large Play Button Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-14 h-14 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-xl group-hover:scale-115 group-hover:bg-red-600 transition-all duration-300">
                                    <i class="fa-solid fa-play text-lg ml-1"></i>
                                </div>
                            </div>

                            <div class="absolute bottom-3 right-3 px-2.5 py-0.5 rounded-md bg-black/70 text-white text-[10px] font-bold">
                                Tonton Video
                            </div>
                        </div>

                        <!-- Video Meta & Title -->
                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                                <span class="text-[11px] font-bold text-red-600 dark:text-red-400 uppercase tracking-wider block mb-2">
                                    <i class="fa-regular fa-calendar me-1"></i> {{ $v->tanggal ? $v->tanggal->translatedFormat('d F Y') : '-' }}
                                </span>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                                    {{ $v->judul }}
                                </h3>
                                @if($v->deskripsi)
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                                        {{ $v->deskripsi }}
                                    </p>
                                @endif
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs font-bold text-red-600 dark:text-red-400">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-play"></i> Putar Video
                                </span>
                                <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 text-slate-500">
                        Belum ada video galeri yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section 2: Galeri Foto Kegiatan (Tampil jika tab 'semua' atau 'foto') -->
        <div x-show="currentTab === 'semua' || currentTab === 'foto'" x-cloak>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-600/10 dark:bg-blue-600/20 text-blue-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-images text-base"></i>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">
                            Galeri Foto Kegiatan PWI
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Dokumentasi momen kegiatan dan agenda jurnalistik PWI Banyuasin</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Photos Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">
                @forelse($galleries as $g)
                    <div @click="selectedPhoto = '{{ $g->foto_url }}'; selectedTitle = '{{ addslashes($g->judul) }}'; selectedDate = '{{ $g->tanggal_kegiatan ? $g->tanggal_kegiatan->translatedFormat('d F Y') : '-' }}'; selectedDesc = '{{ addslashes($g->deskripsi) }}'" 
                         class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1 flex flex-col">
                        
                        <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden">
                            <img src="{{ $g->foto_url }}" alt="{{ $g->judul }}" width="400" height="300" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-slate-950/20 group-hover:bg-slate-950/40 transition-colors"></div>
                            <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-black/60 text-white flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fa-solid fa-expand"></i>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col justify-between flex-grow">
                            <div>
                                <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider block mb-1.5">
                                    <i class="fa-regular fa-calendar me-1"></i> {{ $g->tanggal_kegiatan ? $g->tanggal_kegiatan->translatedFormat('d F Y') : '-' }}
                                </span>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $g->judul }}
                                </h3>
                                @if($g->deskripsi)
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                                        {{ $g->deskripsi }}
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 text-slate-500">
                        Belum ada data dokumentasi foto galeri.
                    </div>
                @endforelse
            </div>

            <!-- Pagination (for photos) -->
            <div class="mt-12 w-full">
                {{ $galleries->links() }}
            </div>
        </div>

        <!-- Lightbox Modal for Photos -->
        <div x-show="selectedPhoto" 
             x-cloak 
             @click="selectedPhoto = null"
             @keydown.escape.window="selectedPhoto = null"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md cursor-pointer">
            <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-2xl cursor-default" 
                 @click.stop>
                <button type="button" @click="selectedPhoto = null" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/60 text-white hover:bg-black flex items-center justify-center cursor-pointer transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <img :src="selectedPhoto" :alt="selectedTitle" class="w-full max-h-[65vh] object-contain bg-black">
                <div class="p-6 bg-slate-900 text-white">
                    <div class="text-xs text-amber-400 font-semibold" x-text="selectedDate"></div>
                    <h3 class="text-lg font-bold text-white mt-1" x-text="selectedTitle"></h3>
                    <p class="text-xs text-slate-300 mt-2" x-text="selectedDesc"></p>
                </div>
            </div>
        </div>

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
                        <i class="fa-brands fa-youtube text-red-500 text-lg"></i>
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
                        <a :href="selectedVideo ? selectedVideo.url : '#'" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-colors">
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
