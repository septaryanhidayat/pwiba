@extends('layouts.admin')

@section('title', 'Ketua PWI Banyuasin Dari Masa ke Masa')
@section('page_title', 'Ketua Dari Masa ke Masa')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, editData: null }">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Ketua PWI Banyuasin Dari Masa ke Masa</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Kelola foto pimpinan resmi, nama, jabatan, periode tahun kepengurusan, dan status kepemimpinan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('leaders.public') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 shadow-sm transition-all">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Halaman Publik</span>
            </a>
            <button @click="modalTambah = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-sm transition-all cursor-pointer">
                <i class="fa-solid fa-plus"></i>
                <span>+ Tambah Ketua</span>
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Search & Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="text-xs font-bold text-slate-700 dark:text-slate-300">
                Total: <span class="text-blue-600 dark:text-amber-400 font-extrabold">{{ $leaders->total() }}</span> Pemimpin Terdata
            </div>

            <form action="{{ route('admin.leaders.index') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / periode..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">URUTAN</th>
                        <th class="py-3.5 px-6 w-24 text-center font-bold">FOTO</th>
                        <th class="py-3.5 px-6 font-bold">NAMA LENGKAP</th>
                        <th class="py-3.5 px-6 font-bold">JABATAN</th>
                        <th class="py-3.5 px-6 font-bold">PERIODE</th>
                        <th class="py-3.5 px-6 font-bold text-center">STATUS</th>
                        <th class="py-3.5 px-6 text-center w-36 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($leaders as $l)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3.5 px-6 text-center font-extrabold text-blue-600 dark:text-amber-400 text-sm">
                                #{{ $l->urutan }}
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="w-14 h-18 rounded-xl bg-slate-100 dark:bg-slate-800 ring-1 ring-slate-300 dark:ring-slate-700 overflow-hidden mx-auto shadow-sm">
                                    <img src="{{ $l->foto_url }}" alt="{{ $l->nama }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="font-extrabold text-slate-900 dark:text-white text-sm">{{ $l->nama }}</div>
                                @if($l->keterangan)
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-1">{{ $l->keterangan }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 font-semibold text-slate-700 dark:text-slate-300">
                                {{ $l->jabatan }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                    {{ $l->periode }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                @if($l->status_aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Petahana / Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        Demisioner
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="editData = {{ json_encode($l) }}" class="px-2.5 py-1.5 rounded-lg text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:text-amber-300 dark:hover:bg-amber-900/60 transition-colors cursor-pointer border border-amber-200 dark:border-amber-800">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.leaders.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Ketua {{ $l->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-300 dark:hover:bg-rose-900/60 transition-colors cursor-pointer border border-rose-200 dark:border-rose-800">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 dark:text-slate-400">
                                Belum ada data Ketua dari masa ke masa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leaders->hasPages())
            <div class="p-6 border-t border-slate-200 dark:border-slate-800">
                {{ $leaders->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah Ketua -->
    <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="modalTambah = false" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-blue-600 dark:text-amber-400"></i>
                    <span>Tambah Data Ketua Dari Masa ke Masa</span>
                </h3>
                <button @click="modalTambah = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.leaders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" required placeholder="Contoh: Wardoyo, S.I.Kom" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 font-medium text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Jabatan *</label>
                        <input type="text" name="jabatan" value="Ketua PWI Banyuasin" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 font-medium text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Periode *</label>
                        <input type="text" name="periode" required placeholder="Contoh: 2025 - 2028" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 font-medium text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" placeholder="2025" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" placeholder="2028" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Urutan</label>
                        <input type="number" name="urutan" placeholder="5" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Foto Resmi Ketua (Otomatis Konversi WebP)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-[11px] text-slate-500 mt-1">Disarankan foto potret berlatar belakang merah/resmi. Format WebP, JPG, PNG.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Keterangan / Catatan Sejarah</label>
                    <textarea name="keterangan" rows="2" placeholder="Catatan singkat mengenai periode ini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="status_aktif" id="status_aktif_tambah" value="1" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <label for="status_aktif_tambah" class="font-bold text-slate-800 dark:text-slate-200">Tandai sebagai Ketua Petahana / Aktif Saat Ini</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold shadow-sm">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Ketua -->
    <div x-show="editData" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="editData = null" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Data Ketua</span>
                </h3>
                <button @click="editData = null" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/leaders') }}/' + editData?.id" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" :value="editData?.nama" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 font-medium text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Jabatan *</label>
                        <input type="text" name="jabatan" :value="editData?.jabatan" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 font-medium text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Periode *</label>
                        <input type="text" name="periode" :value="editData?.periode" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 font-medium text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" :value="editData?.tahun_mulai" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" :value="editData?.tahun_selesai" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Urutan *</label>
                        <input type="number" name="urutan" :value="editData?.urutan" required class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Ganti Foto Resmi (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-[11px] text-slate-500 mt-1">Foto baru otomatis dikonversi ke format WebP proporsional.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Keterangan / Catatan Sejarah</label>
                    <textarea name="keterangan" x-text="editData?.keterangan" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="status_aktif" id="status_aktif_edit" value="1" :checked="editData?.status_aktif" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <label for="status_aktif_edit" class="font-bold text-slate-800 dark:text-slate-200">Tandai sebagai Ketua Petahana / Aktif Saat Ini</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" @click="editData = null" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
