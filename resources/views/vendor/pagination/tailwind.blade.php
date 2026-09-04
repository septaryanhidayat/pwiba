@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-3 px-2 py-3">
        
        <!-- Summary Info (Left/Center) -->
        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 text-center sm:text-left">
            Menampilkan 
            <span class="font-extrabold text-slate-900 dark:text-white">{{ $paginator->firstItem() ?? 0 }}</span>
            sampai 
            <span class="font-extrabold text-slate-900 dark:text-white">{{ $paginator->lastItem() ?? 0 }}</span>
            dari 
            <span class="font-extrabold text-slate-900 dark:text-white">{{ $paginator->total() }}</span> 
            data
        </div>

        <!-- Navigation Buttons: Numbers & Icons (No raw text) -->
        <div class="inline-flex items-center gap-1 p-1 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
            
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-300 dark:text-slate-600 cursor-not-allowed text-xs" aria-disabled="true" aria-label="Sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   rel="prev" 
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-800 dark:hover:text-amber-400 transition-all text-xs font-bold" 
                   aria-label="Sebelumnya"
                   title="Halaman Sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements (Page Numbers) --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-6 h-8 sm:w-7 sm:h-9 flex items-center justify-center text-xs font-bold text-slate-400 dark:text-slate-500">
                        &hellip;
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center bg-blue-600 text-white font-black text-xs sm:text-sm shadow-sm" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-white font-bold text-xs sm:text-sm transition-all"
                               title="Ke Halaman {{ $page }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   rel="next" 
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-800 dark:hover:text-amber-400 transition-all text-xs font-bold" 
                   aria-label="Selanjutnya"
                   title="Halaman Selanjutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-300 dark:text-slate-600 cursor-not-allowed text-xs" aria-disabled="true" aria-label="Selanjutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif

        </div>

    </nav>
@endif
