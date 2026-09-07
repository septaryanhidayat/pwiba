@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="w-full flex flex-col sm:flex-row items-center justify-between gap-3 px-2 py-2 sm:px-1">
        
        <div class="text-xs font-medium text-slate-500 dark:text-slate-400 text-center sm:text-left order-2 sm:order-1">
            Halaman <span class="font-extrabold text-slate-900 dark:text-white">{{ $paginator->currentPage() }}</span>
        </div>

        <div class="order-1 sm:order-2 flex items-center justify-center">
            <div class="inline-flex items-center gap-1.5 p-1 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-300 dark:text-slate-600 cursor-not-allowed text-xs" aria-disabled="true">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       rel="prev" 
                       class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-800 dark:hover:text-amber-400 transition-all text-xs font-bold" 
                       title="Halaman Sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                <span class="px-3 py-1 rounded-xl bg-blue-50 dark:bg-slate-800/80 border border-blue-100 dark:border-slate-700 text-xs font-bold text-blue-700 dark:text-amber-400">
                    Hal <span class="font-black">{{ $paginator->currentPage() }}</span>
                </span>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       rel="next" 
                       class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-slate-800 dark:hover:text-amber-400 transition-all text-xs font-bold" 
                       title="Halaman Selanjutnya">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-300 dark:text-slate-600 cursor-not-allowed text-xs" aria-disabled="true">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>

    </nav>
@endif
