@extends('layouts.admin')

@section('title', 'Data Publish Berita')
@section('page_title', 'CMS Berita')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Data Publish Berita & Publikasi</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Daftar seluruh artikel berita resmi PWI Banyuasin yang sedang tayang di portal publik</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.posts.draft') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm transition-all">
                Lihat Draf
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-sm transition-all">
                <i class="fa-solid fa-plus"></i>
                <span>+ Tulis Berita Baru</span>
            </a>
        </div>
    </div>

    <!-- Table Container (Deep Navy Header & High Contrast Body) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tampilkan</span>
                <form action="{{ route('admin.posts.publish') }}" method="GET">
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-sm">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">berita</span>
            </div>

            <form action="{{ route('admin.posts.publish') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul / penulis..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">JUDUL ARTIKEL BERITA</th>
                        <th class="py-3.5 px-6 font-bold">PENULIS / JURNALIS</th>
                        <th class="py-3.5 px-6 text-center w-40 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($posts as $index => $p)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $posts->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('news.show', $p->slug) }}" target="_blank" class="font-bold text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-amber-400 transition-colors text-sm line-clamp-1">
                                    {{ $p->judul }}
                                </a>
                                <div class="text-[11px] text-slate-600 dark:text-slate-400 mt-1 flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-700 font-bold">{{ $p->kategori }}</span>
                                    <span>•</span>
                                    <span>{{ $p->published_at ? $p->published_at->translatedFormat('d M Y') : '-' }}</span>
                                    <span>•</span>
                                    <span>{{ number_format($p->views_count) }} kali dibaca</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-slate-200">{{ $p->penulis }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('news.show', $p->slug) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-all" title="Tinjau">
                                        Tinjau
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="p-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold shadow-sm transition-all" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-bold shadow-sm transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500 dark:text-slate-400">
                                Belum ada berita yang dipublikasikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 dark:text-slate-400 gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div>
                Menampilkan {{ $posts->firstItem() ?? 0 }} s/d {{ $posts->lastItem() ?? 0 }} dari {{ $posts->total() }} berita
            </div>
            <div>
                {{ $posts->withQueryString()->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
