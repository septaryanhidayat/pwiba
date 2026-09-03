@extends('layouts.admin')

@section('title', 'Data Media Pers Mitra')
@section('page_title', 'Data Media')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, editData: null }">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Direktori Media Pers Mitra</h2>
            <p class="text-xs text-slate-400 mt-1">Daftar media massa, portal berita online, cetak, dan elektronik yang terafiliasi dengan PWI Banyuasin</p>
        </div>
        <button @click="modalTambah = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>+ Tambah Media</span>
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400">Tampilkan</span>
                <form action="{{ route('admin.media.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 outline-none">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-xs text-slate-400">media</span>
            </div>

            <form action="{{ route('admin.media.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama media / website..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">NAMA MEDIA</th>
                        <th class="py-3.5 px-6">WEBSITE / PORTAL</th>
                        <th class="py-3.5 px-6">ALAMAT KANTOR REDAKSI</th>
                        <th class="py-3.5 px-6 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($media as $index => $m)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-bold text-slate-500">{{ $media->firstItem() + $index }}</td>
                            <td class="py-3.5 px-6 font-bold text-white">{{ $m->nama_media }}</td>
                            <td class="py-3.5 px-6">
                                @if($m->website)
                                    <a href="{{ Str::startsWith($m->website, 'http') ? $m->website : 'https://' . $m->website }}" target="_blank" class="text-blue-400 hover:underline flex items-center gap-1">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        <span>{{ $m->website }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-slate-400">{{ $m->alamat ?? '-' }}</td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" @click="editData = {{ json_encode($m) }}" class="p-1.5 rounded-lg bg-blue-500/10 hover:bg-blue-500 text-blue-400 hover:text-white border border-blue-500/20 transition-all" title="Edit Media">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.media.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus media {{ $m->nama_media }}?')" class="inline">
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
                            <td colspan="5" class="py-12 text-center text-slate-500">
                                Tidak ada data media terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
            <div>
                Menampilkan {{ $media->firstItem() ?? 0 }} s/d {{ $media->lastItem() ?? 0 }} dari {{ $media->total() }} media
            </div>
            <div>
                {{ $media->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <!-- Modal Tambah Media -->
    <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalTambah = false">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-newspaper text-amber-400"></i> Tambah Media Mitra Baru
                </h3>
                <button @click="modalTambah = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.media.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nama Perusahaan Pers / Media *</label>
                    <input type="text" name="nama_media" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Harian Banyuasin">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Alamat Website / Portal Online</label>
                    <input type="text" name="website" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="https://harianbanyuasin.disway.id">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Alamat Kantor Redaksi</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Jl. Palembang - Betung Kel. Kayuara Kuning..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300">Simpan Media</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Media -->
    <div x-show="editData" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="editData = null">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen text-blue-400"></i> Edit Media Mitra
                </h3>
                <button @click="editData = null" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/media') }}/' + (editData ? editData.id : '')" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nama Perusahaan Pers / Media *</label>
                    <input type="text" name="nama_media" :value="editData ? editData.nama_media : ''" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Alamat Website / Portal Online</label>
                    <input type="text" name="website" :value="editData ? editData.website : ''" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Alamat Kantor Redaksi</label>
                    <textarea name="alamat" rows="3" :value="editData ? editData.alamat : ''" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="editData = null" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
