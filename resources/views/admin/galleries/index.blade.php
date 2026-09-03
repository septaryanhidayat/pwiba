@extends('layouts.admin')

@section('title', 'Galeri Foto Kegiatan PWI')
@section('page_title', 'Galeri Dokumentasi')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, editData: null }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Galeri Foto Kegiatan PWI Banyuasin</h2>
            <p class="text-xs text-slate-400 mt-1">Dokumentasi visual rangkaian kegiatan, turnamen, audiensi, dan safari jurnalistik</p>
        </div>
        <button @click="modalTambah = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>+ Tambah Foto Galeri</span>
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="text-xs text-slate-400">
                Total Dokumentasi: <span class="font-bold text-amber-400">{{ $galleries->total() }} Foto</span>
            </div>

            <form action="{{ route('admin.galleries.index') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul galeri..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6 w-24 text-center">FOTO</th>
                        <th class="py-3.5 px-6">JUDUL KEGIATAN</th>
                        <th class="py-3.5 px-6">DESKRIPSI</th>
                        <th class="py-3.5 px-6">TANGGAL</th>
                        <th class="py-3.5 px-6 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($galleries as $index => $g)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500">{{ $galleries->firstItem() + $index }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="w-16 h-12 rounded-xl overflow-hidden bg-slate-800 mx-auto shadow-sm">
                                    <img src="{{ $g->foto_url }}" alt="{{ $g->judul }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-4 px-6 font-bold text-white text-sm">{{ $g->judul }}</td>
                            <td class="py-4 px-6 text-slate-400 leading-relaxed">{{ Str::limit($g->deskripsi, 60) }}</td>
                            <td class="py-4 px-6 text-slate-400">{{ $g->tanggal_kegiatan ? $g->tanggal_kegiatan->format('d/m/Y') : '-' }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" @click="editData = {{ json_encode($g) }}" class="p-1.5 rounded-lg bg-blue-500/10 hover:bg-blue-500 text-blue-400 hover:text-white border border-blue-500/20 transition-all" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.galleries.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')" class="inline">
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
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                Tidak ada foto galeri tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex justify-end">
            {{ $galleries->withQueryString()->links() }}
        </div>

    </div>

    <!-- Modal Tambah Galeri -->
    <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalTambah = false">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-images text-amber-400"></i> Unggah Foto Galeri
                </h3>
                <button @click="modalTambah = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Judul Kegiatan / Agenda *</label>
                    <input type="text" name="judul" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Turnamen Mini Soccer Piala PWI 2026">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Pilih File Foto *</label>
                    <input type="file" name="foto" required class="w-full px-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-950">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Keterangan singkat mengenai kegiatan..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300">Unggah Foto</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Galeri -->
    <div x-show="editData" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="editData = null">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen text-blue-400"></i> Edit Dokumentasi Galeri
                </h3>
                <button @click="editData = null" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/galeri') }}/' + (editData ? editData.id : '')" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Judul Kegiatan *</label>
                    <input type="text" name="judul" :value="editData ? editData.judul : ''" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan" :value="editData && editData.tanggal_kegiatan ? editData.tanggal_kegiatan.substring(0,10) : ''" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" class="w-full px-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-950">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" :value="editData ? editData.deskripsi : ''" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none"></textarea>
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
