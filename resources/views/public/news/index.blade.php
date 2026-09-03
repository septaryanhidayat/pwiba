@extends('layouts.public')

@section('title', 'Berita & Publikasi Terkini')

@section('content')
<!-- Header Banner -->
<div class="gradient-mesh text-white py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-400 bg-white/10 px-3.5 py-1 rounded-full border border-white/15">
                Kanal Berita & Rilis Pers
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-3">
                Informasi & Warta PWI Kabupaten Banyuasin
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-2">
                Menyajikan kabar terpercaya seputar kegiatan jurnalistik, kemitraan strategis Forkopimda, dan dinamika kemerdekaan pers.
            </p>
        </div>
    </div>
</div>

<!-- News Grid & Filter Section -->
<div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filters & Search Bar -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10">
            <!-- Category Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ !request('kategori') ? 'bg-slate-900 dark:bg-amber-400 text-white dark:text-slate-950 shadow-md' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('news.index', ['kategori' => $cat]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request('kategori') == $cat ? 'bg-slate-900 dark:bg-amber-400 text-white dark:text-slate-950 shadow-md' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <!-- Search Input -->
            <form action="{{ route('news.index') }}" method="GET" class="w-full md:w-72">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $p)
                <article class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group hover:-translate-y-1">
                    <a href="{{ route('news.show', $p->slug) }}" class="relative block overflow-hidden aspect-[16/10] bg-slate-100 dark:bg-slate-800">
                        <img src="{{ $p->gambar_url }}" alt="{{ $p->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-900/80 text-amber-300 backdrop-blur-md shadow-sm border border-white/10">
                                {{ $p->kategori }}
                            </span>
                        </div>
                    </a>

                    <div class="p-6 flex flex-col flex-grow justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                                <span><i class="fa-regular fa-calendar me-1"></i> {{ $p->published_at ? $p->published_at->translatedFormat('d M Y') : '-' }}</span>
                                <span>•</span>
                                <span><i class="fa-regular fa-eye me-1"></i> {{ $p->views_count }} views</span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ route('news.show', $p->slug) }}">
                                    {{ $p->judul }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-2.5 line-clamp-3 leading-relaxed">
                                {{ $p->ringkasan ?? Str::limit(strip_tags($p->konten), 120) }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                            <span class="text-slate-700 dark:text-slate-300 font-semibold flex items-center gap-1.5">
                                <i class="fa-solid fa-pen-nib text-amber-500"></i> {{ $p->penulis }}
                            </span>
                            <a href="{{ route('news.show', $p->slug) }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">
                                Baca <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 text-slate-500">
                    <i class="fa-regular fa-newspaper text-3xl mb-2 text-slate-300"></i>
                    <p>Tidak ditemukan artikel berita yang sesuai kriteria pencarian.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $posts->withQueryString()->links() }}
        </div>

    </div>
</div>
@endsection
