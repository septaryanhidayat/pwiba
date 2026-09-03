@extends('layouts.public')

@section('title', 'Galeri Foto Kegiatan PWI Kabupaten Banyuasin')

@section('content')
<!-- Header Banner -->
<div class="gradient-mesh text-white py-16 relative overflow-hidden text-center sm:text-left">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl mx-auto sm:mx-0 flex flex-col items-center sm:items-start">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-white/10 px-3.5 py-1 rounded-full border border-white/15">
                Dokumentasi Visual Lengkap
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-3">
                Galeri Foto & Dokumentasi Kegiatan PWI
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-2">
                Dokumentasi ragam aktivitas jurnalistik, peringatan Hari Pers Nasional, audiensi pemerintah daerah, dan turnamen olahraga PWI Banyuasin.
            </p>
        </div>
    </div>
</div>

<div class="py-16 bg-slate-50 dark:bg-slate-950 transition-colors duration-200" x-data="{ selectedPhoto: null, selectedTitle: '', selectedDate: '', selectedDesc: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">
            @forelse($galleries as $g)
                <div @click="selectedPhoto = '{{ $g->foto_url }}'; selectedTitle = '{{ addslashes($g->judul) }}'; selectedDate = '{{ $g->tanggal_kegiatan ? $g->tanggal_kegiatan->translatedFormat('d F Y') : '-' }}'; selectedDesc = '{{ addslashes($g->deskripsi) }}'" 
                     class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1 flex flex-col">
                    
                    <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden">
                        <img src="{{ $g->foto_url }}" alt="{{ $g->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                    Belum ada data dokumentasi galeri.
                </div>
            @endforelse
        </div>

        <!-- Lightbox Modal -->
        <div x-show="selectedPhoto" x-cloak @click.away="selectedPhoto = null" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md">
            <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                <button @click="selectedPhoto = null" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/60 text-white hover:bg-black flex items-center justify-center cursor-pointer">
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

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $galleries->links() }}
        </div>

    </div>
</div>
@endsection
