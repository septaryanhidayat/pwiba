@extends('layouts.admin')

@section('title', 'Data Publish Berita')
@section('page_title', 'CMS Berita')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Data Publish Berita & Publikasi</h2>
            <p class="text-xs text-slate-400 mt-1">Daftar seluruh artikel berita resmi PWI Banyuasin yang sedang tayang di portal publik</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.posts.draft') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-300 bg-slate-900 border border-slate-800 hover:text-white">
                Lihat Draf
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
                <i class="fa-solid fa-plus"></i>
                <span>+ Tulis Berita Baru</span>
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400">Tampilkan</span>
                <form action="{{ route('admin.posts.publish') }}" method="GET">
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 outline-none">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs text-slate-400">berita</span>
            </div>

            <form action="{{ route('admin.posts.publish') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul / penulis..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">JUDUL ARTIKEL BERITA</th>
                        <th class="py-3.5 px-6">PENULIS / JURNALIS</th>
                        <th class="py-3.5 px-6 text-center w-40">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($posts as $index => $p)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500">{{ $posts->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('news.show', $p->slug) }}" target="_blank" class="font-bold text-white hover:text-amber-400 transition-colors text-sm line-clamp-1">
                                    {{ $p->judul }}
                                </a>
                                <div class="text-[11px] text-slate-400 mt-1 flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-md bg-blue-500/10 text-blue-400 border border-blue-500/20 font-bold">{{ $p->kategori }}</span>
                                    <span>•</span>
                                    <span>{{ $p->published_at ? $p->published_at->translatedFormat('d M Y') : '-' }}</span>
                                    <span>•</span>
                                    <span>{{ $p->views_count }} views</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-300">{{ $p->penulis }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('news.show', $p->slug) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-sky-500/10 hover:bg-sky-500 text-sky-400 hover:text-white border border-sky-500/20 text-xs font-bold transition-all" title="Tinjau">
                                        Tinjau
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="p-1.5 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 border border-amber-500/20 transition-all" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500">
                                Belum ada berita yang dipublikasikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex justify-end">
            {{ $posts->withQueryString()->links() }}
        </div>

    </div>

</div>
@endsection
