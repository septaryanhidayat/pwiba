@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-3 px-2 py-3">
        
        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 text-center sm:text-left">
            Halaman <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->currentPage() }}</span>
        </div>

        <div class="inline-flex items-center gap-1.5 p-1 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-300 dark:text-slate-600 cursor-not-allowed text-xs" aria-disabled="true">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   rel="prev" 
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-800 dark:hover:text-amber-400 transition-all text-xs font-bold" 
                   title="Halaman Sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            <span class="px-2.5 text-xs font-extrabold text-blue-600 dark:text-amber-400">
                {{ $paginator->currentPage() }}
            </span>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   rel="next" 
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-800 dark:hover:text-amber-400 transition-all text-xs font-bold" 
                   title="Halaman Selanjutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-slate-300 dark:text-slate-600 cursor-not-allowed text-xs" aria-disabled="true">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </div>

    </nav>
@endif
