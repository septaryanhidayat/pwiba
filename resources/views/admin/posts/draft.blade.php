@extends('layouts.admin')

@section('title', 'Data Draf Berita')
@section('page_title', 'CMS Berita')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Data Draf Berita</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Artikel yang belum dipublikasikan dan masih dalam tahap penulisan atau review</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.posts.publish') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm transition-all">
                Lihat Berita Publish
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-sm transition-all">
                <i class="fa-solid fa-plus"></i>
                <span>+ Tulis Berita Baru</span>
            </a>
        </div>
    </div>

    <!-- Table Container (Clean White Background Card) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                Total Draf: <span class="font-bold text-amber-600 dark:text-amber-400">{{ $posts->total() }} Artikel</span>
            </div>

            <form action="{{ route('admin.posts.draft') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari draf berita..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">JUDUL DRAF BERITA</th>
                        <th class="py-3.5 px-6 font-bold">PENULIS / JURNALIS</th>
                        <th class="py-3.5 px-6 text-center w-48 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($posts as $index => $p)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $posts->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-white text-sm">
                                <a href="{{ route('news.show', $p->slug) }}" target="_blank" class="hover:text-blue-600 dark:hover:text-amber-400 transition-colors line-clamp-1" title="Tinjau Draf">
                                    {{ $p->judul }}
                                </a>
                                <div class="text-[11px] text-slate-600 dark:text-slate-400 mt-1 font-medium">
                                    <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-900/40 dark:text-amber-300 dark:border-amber-700 font-bold">Draf</span>
                                    • Diperbarui: {{ $p->updated_at ? $p->updated_at->diffForHumans() : '-' }}
                                </div>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-slate-200">{{ $p->penulis }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('news.show', $p->slug) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-all" title="Tinjau Draf">
                                        Tinjau
                                    </a>
                                    <form action="{{ route('admin.posts.toggle', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all" title="Publish Sekarang">
                                            Publish
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="p-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold shadow-sm transition-all" title="Edit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus draf artikel ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500 dark:text-slate-400 font-medium">
                                Tidak ada draf berita tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex justify-end bg-slate-50/50 dark:bg-slate-900/50">
            {{ $posts->withQueryString()->links() }}
        </div>

    </div>

</div>
@endsection
