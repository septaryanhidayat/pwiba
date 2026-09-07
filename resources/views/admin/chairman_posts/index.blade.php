@extends('layouts.admin')

@section('title', 'Kelola Arsip Karya Tulisan Ketua')
@section('page_title', 'Arsip Karya Ketua')

@section('content')
<div class="space-y-6">
    
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/10 border border-amber-400/20 text-amber-600 dark:text-amber-400 text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-solid fa-feather-pointed"></i>
                <span>Arsip Karya &amp; Pemikiran Ketua</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-[#0B132B] dark:text-white">Kelola Karya Tulis & Arsip Pemikiran Ketua</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">
                Manajemen seluruh tulisan, esai teori komunikasi, dan karya jurnalistik Wardoyo, S.I.Kom. yang terhubung ke portofolio publik <a href="{{ route('chairman.archive.index') }}" target="_blank" class="text-blue-600 dark:text-amber-400 font-bold hover:underline">/wardoyo</a>
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('chairman.archive.index') }}" target="_blank" class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-xs transition-all whitespace-nowrap">
                <i class="fa-solid fa-arrow-up-right-from-square text-amber-500 text-xs"></i>
                <span>Lihat Web</span>
            </a>
            <a href="{{ route('admin.chairman_posts.create') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-sm transition-all whitespace-nowrap">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>+ Tulis Artikel</span>
            </a>
        </div>
    </div>

    <!-- Quick Nav Switcher (Arsip Tulisan vs Profil Ketua) -->
    <div class="flex items-center gap-1.5 sm:gap-2 border-b border-slate-200 dark:border-slate-800 pb-2 overflow-x-auto no-scrollbar">
        <a href="{{ route('admin.chairman_posts.index') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl text-xs font-bold bg-[#0B132B] text-white dark:bg-amber-400 dark:text-slate-950 shadow-xs shrink-0 whitespace-nowrap">
            <i class="fa-solid fa-newspaper text-amber-400 dark:text-slate-950 text-xs"></i>
            <span>Katalog Karya</span>
        </a>
        <a href="{{ route('admin.chairman_profile.edit') }}" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shrink-0 whitespace-nowrap">
            <i class="fa-solid fa-id-card-clip text-emerald-500 text-xs"></i>
            <span>Profil Ketua</span>
        </a>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/80 text-emerald-900 dark:text-emerald-200 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Mini Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Arsip -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Tulisan</span>
                    <div class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalPosts) }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
            </div>
            <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 mt-2 block">Koleksi karya terarsip</span>
        </div>

        <!-- Card 2: Kategori Aktif -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Kategori</span>
                    <div class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $categories->count() }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-tags"></i>
                </div>
            </div>
            <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 mt-2 block">Bidang keilmuan & topik</span>
        </div>

        <!-- Card 3: Total Dibaca -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Pembaca</span>
                    <div class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalViews) }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 mt-2 block">Akumulasi tayangan artikel</span>
        </div>

        <!-- Card 4: Status Sinkronisasi -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status Portofolio</span>
                    <div class="text-sm font-black text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5 mt-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Aktif & Terproteksi</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-shield-check"></i>
                </div>
            </div>
            <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 mt-2 block">Akses direct URL /wardoyo</span>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Filter and Search Toolbar -->
        <div class="p-5 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-900/60">
            <form action="{{ route('admin.chairman_posts.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                
                <!-- Left: Filter Dropdowns -->
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Kategori -->
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Kategori:</span>
                        <select name="category" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-xs">
                            <option value="Semua" {{ request('category', 'Semua') === 'Semua' ? 'selected' : '' }}>Semua Kategori ({{ $totalPosts }})</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tahun -->
                    @if($years->isNotEmpty())
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Tahun:</span>
                            <select name="year" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-xs">
                                <option value="Semua" {{ request('year', 'Semua') === 'Semua' ? 'selected' : '' }}>Semua Tahun</option>
                                @foreach($years as $yr)
                                    <option value="{{ $yr }}" {{ (string) request('year') === (string) $yr ? 'selected' : '' }}>{{ $yr }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Per Halaman -->
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Baris:</span>
                        <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-xs">
                            <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('entries', 15) == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    @if(request()->filled('search') || (request()->filled('category') && request('category') !== 'Semua') || (request()->filled('year') && request('year') !== 'Semua'))
                        <a href="{{ route('admin.chairman_posts.index') }}" class="px-3 py-1.5 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 text-xs font-bold hover:bg-rose-100 transition-colors">
                            <i class="fa-solid fa-rotate-left me-1"></i> Reset Filter
                        </a>
                    @endif
                </div>

                <!-- Right: Search Bar -->
                <div class="w-full sm:w-80 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi tulisan..." class="w-full pl-9 pr-8 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.chairman_posts.index', request()->except('search')) }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-4 text-center w-12 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">JUDUL TULISAN & INFORMASI ARSIP</th>
                        <th class="py-3.5 px-6 font-bold hidden md:table-cell w-1/3">CUPLIKAN KONTEN</th>
                        <th class="py-3.5 px-4 text-center font-bold hidden sm:table-cell w-28">SUMBER ASLI</th>
                        <th class="py-3.5 px-6 text-center w-36 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($posts as $index => $p)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-500 dark:text-slate-400">
                                {{ $posts->firstItem() + $index }}
                            </td>

                            <!-- Judul & Info -->
                            <td class="py-4 px-6">
                                <a href="{{ route('chairman.archive.show', $p->slug) }}" target="_blank" class="font-bold text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-amber-400 transition-colors text-sm line-clamp-1">
                                    {{ $p->title }}
                                </a>
                                <div class="text-[11px] text-slate-600 dark:text-slate-400 mt-1.5 flex items-center gap-2 flex-wrap">
                                    <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800/80 font-bold">
                                        {{ $p->category }}
                                    </span>
                                    <span>•</span>
                                    <span title="Waktu Rilis"><i class="fa-regular fa-calendar text-slate-400 me-1"></i>{{ $p->published_at ? $p->published_at->translatedFormat('d M Y') : '-' }}</span>
                                    <span>•</span>
                                    <span title="Waktu Baca"><i class="fa-regular fa-clock text-amber-500 me-1"></i>{{ $p->reading_time ?? 3 }} mnt baca</span>
                                    <span>•</span>
                                    <span title="Jumlah Dilihat"><i class="fa-regular fa-eye text-blue-500 me-1"></i>{{ number_format($p->views_count) }}x</span>
                                </div>
                            </td>

                            <!-- Cuplikan -->
                            <td class="py-4 px-6 hidden md:table-cell text-slate-600 dark:text-slate-400 leading-relaxed">
                                <p class="line-clamp-2 text-xs">
                                    {{ $p->excerpt ?: Str::limit(strip_tags($p->content), 120) }}
                                </p>
                            </td>

                            <!-- Sumber Asli -->
                            <td class="py-4 px-4 text-center hidden sm:table-cell">
                                @if($p->original_url)
                                    <a href="{{ $p->original_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 hover:bg-blue-100 text-[10px] font-bold transition-all" title="{{ $p->original_url }}">
                                        <i class="fa-brands fa-wordpress text-xs"></i>
                                        <span>WordPress</span>
                                    </a>
                                @else
                                    <span class="text-[10px] font-semibold text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Tinjau Halaman Publik -->
                                    <a href="{{ route('chairman.archive.show', $p->slug) }}" target="_blank" class="p-2 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 hover:bg-blue-600 hover:text-white border border-blue-200 dark:border-blue-800 transition-all font-bold shadow-xs" title="Tinjau di Halaman Publik /wardoyo">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.chairman_posts.edit', $p->id) }}" class="p-2 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 hover:bg-amber-500 hover:text-slate-950 border border-amber-200 dark:border-amber-800 transition-all font-bold shadow-xs" title="Edit Karya Tulis Ini">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Hapus -->
                                    <form action="{{ route('admin.chairman_posts.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel \'{{ addslashes($p->title) }}\' dari arsip?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 hover:bg-rose-600 hover:text-white border border-rose-200 dark:border-rose-800 transition-all font-bold shadow-xs cursor-pointer" title="Hapus Karya Tulis Ini">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center text-slate-500 dark:text-slate-400">
                                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center text-2xl mb-3">
                                    <i class="fa-solid fa-feather-pointed"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Tidak ada artikel karya tulis yang cocok</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                                    Coba ubah kata kunci pencarian atau sesuaikan filter kategori Anda.
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('admin.chairman_posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Tulis Artikel Baru</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="p-5 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-600 dark:text-slate-400 font-medium">
                    Menampilkan <span class="font-bold text-slate-900 dark:text-white">{{ $posts->firstItem() }}</span> sampai <span class="font-bold text-slate-900 dark:text-white">{{ $posts->lastItem() }}</span> dari <span class="font-bold text-slate-900 dark:text-white">{{ $posts->total() }}</span> arsip karya tulis
                </div>
                <div>
                    {{ $posts->links() }}
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
