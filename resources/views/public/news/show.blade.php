@extends('layouts.public')

@section('title', $post->judul)

@section('content')
<div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Beranda</a>
            <span>/</span>
            <a href="{{ route('news.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Berita</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-slate-200 font-semibold truncate max-w-xs">{{ $post->judul }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Main Content (8 cols) -->
            <div class="lg:col-span-8">
                <article class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-10 shadow-sm">
                    
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg text-xs font-bold bg-amber-50 dark:bg-amber-400/10 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-400/30 mb-4">
                        <i class="fa-solid fa-tag"></i>
                        <span>{{ $post->kategori }}</span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight mb-6">
                        {{ $post->judul }}
                    </h1>

                    <div class="flex flex-wrap items-center justify-between gap-4 py-4 border-y border-slate-100 dark:border-slate-800 text-xs text-slate-500 dark:text-slate-400 mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center font-bold">
                                <i class="fa-solid fa-user-pen text-xs text-amber-400"></i>
                            </div>
                            <div>
                                <span class="block font-bold text-slate-800 dark:text-slate-200">{{ $post->penulis }}</span>
                                <span>Jurnalis PWI Banyuasin</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span><i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at ? $post->published_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                            <span><i class="fa-regular fa-eye me-1"></i> {{ $post->views_count }} views</span>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="rounded-2xl overflow-hidden aspect-[16/9] bg-slate-100 dark:bg-slate-800 mb-8 shadow-md">
                        <img src="{{ $post->gambar_url }}" alt="{{ $post->judul }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Article Body -->
                    <div class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed space-y-4">
                        {!! $post->konten !!}
                    </div>

                    <!-- Share Section -->
                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Bagikan Berita Ini:</span>
                        <div class="flex items-center gap-2">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->judul . ' ' . url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 transition-colors flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/60 transition-colors flex items-center gap-1.5">
                                <i class="fa-brands fa-facebook text-sm"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 hover:bg-sky-100 dark:hover:bg-sky-900/60 transition-colors flex items-center gap-1.5">
                                <i class="fa-brands fa-x-twitter text-sm"></i> Twitter
                            </a>
                        </div>
                    </div>

                </article>
            </div>

            <!-- Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-8">
                
                <!-- Related News -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-fire text-amber-500"></i>
                        <span>Berita Terkait</span>
                    </h3>

                    <div class="space-y-4">
                        @foreach($relatedPosts as $rp)
                            <a href="{{ route('news.show', $rp->slug) }}" class="flex gap-3 group">
                                <div class="w-20 h-16 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 flex-shrink-0">
                                    <img src="{{ $rp->gambar_url }}" alt="{{ $rp->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                </div>
                                <div class="min-w-0 flex-grow">
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2 leading-snug">
                                        {{ $rp->judul }}
                                    </h4>
                                    <span class="text-[10px] text-slate-400 mt-1 block">
                                        {{ $rp->published_at ? $rp->published_at->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Secretariat Box -->
                <div class="bg-gradient-to-br from-slate-900 to-[#1C2541] rounded-3xl p-6 text-white shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 p-2 ring-1 ring-white/20 flex items-center justify-center">
                            <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Sekretariat PWI Banyuasin</h4>
                            <p class="text-[10px] text-amber-400">Sumatera Selatan</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        Bagi instansi atau perorangan yang membutuhkan konfirmasi berita atau layanan pers resmi, silakan hubungi kami.
                    </p>
                    <a href="{{ route('home') }}#bukutamu" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 text-center block transition-colors">
                        Isi Buku Tamu / Hubungi Kami
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
