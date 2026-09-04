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
                        <img src="{{ $post->gambar_url }}" alt="{{ $post->judul }}" width="800" height="450" fetchpriority="high" class="w-full h-full object-cover">
                    </div>

                    <!-- Article Body -->
                    <div class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed space-y-4">
                        {!! $post->konten !!}
                    </div>

                    <!-- Share Section -->
                    <div class="mt-8 pt-5 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-center sm:text-left">Bagikan Berita Ini:</span>
                        
                        <!-- 1 Baris Horizontal Ikon Bulat -->
                        <div class="flex items-center justify-center sm:justify-end gap-2 overflow-x-auto py-0.5 no-scrollbar max-w-full">
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->judul . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full flex items-center justify-center bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white dark:bg-emerald-950/60 dark:text-emerald-400 dark:hover:bg-emerald-500 dark:hover:text-white transition-all duration-200 shadow-sm hover:scale-105" title="Bagikan ke WhatsApp" aria-label="Bagikan ke WhatsApp">
                                <i class="fa-brands fa-whatsapp text-sm sm:text-base"></i>
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full flex items-center justify-center bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white dark:bg-blue-950/60 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white transition-all duration-200 shadow-sm hover:scale-105" title="Bagikan ke Facebook" aria-label="Bagikan ke Facebook">
                                <i class="fa-brands fa-facebook-f text-xs sm:text-sm"></i>
                            </a>

                            <!-- Instagram -->
                            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" onclick="copyNewsLink(event, 'Tautan disalin! Buka Instagram untuk membagikan.')" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full flex items-center justify-center bg-pink-50 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-rose-500 hover:to-purple-600 text-pink-600 hover:text-white dark:bg-pink-950/60 dark:text-pink-400 dark:hover:text-white transition-all duration-200 shadow-sm hover:scale-105" title="Bagikan ke Instagram" aria-label="Bagikan ke Instagram">
                                <i class="fa-brands fa-instagram text-sm sm:text-base"></i>
                            </a>

                            <!-- X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full flex items-center justify-center bg-slate-100 hover:bg-black text-slate-800 hover:text-white dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-white dark:hover:text-black transition-all duration-200 shadow-sm hover:scale-105" title="Bagikan ke X" aria-label="Bagikan ke X">
                                <i class="fa-brands fa-x-twitter text-xs sm:text-sm"></i>
                            </a>

                            <!-- Telegram -->
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->judul) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full flex items-center justify-center bg-sky-50 hover:bg-sky-500 text-sky-500 hover:text-white dark:bg-sky-950/60 dark:text-sky-400 dark:hover:bg-sky-500 dark:hover:text-white transition-all duration-200 shadow-sm hover:scale-105" title="Bagikan ke Telegram" aria-label="Bagikan ke Telegram">
                                <i class="fa-brands fa-telegram text-sm sm:text-base"></i>
                            </a>

                            <!-- Threads -->
                            <a href="https://www.threads.net/intent/post?text={{ urlencode($post->judul . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full flex items-center justify-center bg-zinc-100 hover:bg-zinc-900 text-zinc-800 hover:text-white dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-100 dark:hover:text-zinc-900 transition-all duration-200 shadow-sm hover:scale-105" title="Bagikan ke Threads" aria-label="Bagikan ke Threads">
                                <i class="fa-brands fa-threads text-sm sm:text-base"></i>
                            </a>

                            <!-- Salin Tautan -->
                            <button type="button" onclick="copyNewsLink(event)" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full flex items-center justify-center bg-slate-100 hover:bg-blue-600 text-slate-700 hover:text-white dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-blue-600 dark:hover:text-white transition-all duration-200 shadow-sm hover:scale-105 cursor-pointer" title="Salin Tautan Berita" aria-label="Salin Tautan Berita">
                                <i class="fa-solid fa-link text-xs sm:text-sm" id="copyShareIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Toast Notifikasi Salin Tautan -->
                    <div id="copyToast" class="fixed bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 bg-slate-900/90 dark:bg-white/90 text-white dark:text-slate-900 text-xs font-semibold rounded-full shadow-lg pointer-events-none transition-all duration-300 opacity-0 translate-y-4 z-50 flex items-center gap-2">
                        <i class="fa-solid fa-check text-emerald-400 dark:text-emerald-600"></i>
                        <span id="copyToastText">Tautan berita berhasil disalin!</span>
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
                                <div class="w-20 h-16 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 flex-shrink-0 aspect-[5/4]">
                                    <img src="{{ $rp->gambar_url }}" alt="{{ $rp->judul }}" width="80" height="64" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
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
                        <div class="w-10 h-10 rounded-xl bg-white/10 p-2 ring-1 ring-white/20 flex items-center justify-center aspect-square">
                            <img src="{{ asset('assets/images/pwi-logo.png') }}" alt="Logo" width="40" height="40" class="w-full h-full object-contain">
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

@push('scripts')
<script>
function copyNewsLink(e, customMsg) {
    const url = window.location.href;
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).catch(function() {
            fallbackCopyText(url);
        });
    } else {
        fallbackCopyText(url);
    }

    const icon = document.getElementById('copyShareIcon');
    if (icon) {
        icon.className = 'fa-solid fa-check text-emerald-500 text-xs sm:text-sm';
        setTimeout(() => {
            icon.className = 'fa-solid fa-link text-xs sm:text-sm';
        }, 2000);
    }

    const toast = document.getElementById('copyToast');
    const toastText = document.getElementById('copyToastText');
    if (toast && toastText) {
        toastText.textContent = customMsg || 'Tautan berita berhasil disalin!';
        toast.classList.remove('opacity-0', 'translate-y-4');
        toast.classList.add('opacity-100', 'translate-y-0');
        setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-4');
        }, 2500);
    }
}

function fallbackCopyText(text) {
    const tempInput = document.createElement('input');
    tempInput.value = text;
    tempInput.style.position = 'fixed';
    tempInput.style.opacity = '0';
    document.body.appendChild(tempInput);
    tempInput.focus();
    tempInput.select();
    try {
        document.execCommand('copy');
    } catch (err) {}
    document.body.removeChild(tempInput);
}
</script>
@endpush
