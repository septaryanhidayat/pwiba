@extends('layouts.admin')

@section('title', 'Surat Masuk & Pengarsipan')
@section('page_title', 'Surat Masuk')

@section('content')
<div class="space-y-6" x-data="{ showModalTambah: false, editModalData: null }">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Buku Arsip Surat Masuk</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Pencatatan surat dinas dari instansi pemerintah, Forkopimda, dan organisasi luar</p>
        </div>
        <button @click="showModalTambah = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 dark:text-slate-950 shadow-sm transition-all cursor-pointer">
            <i class="fa-solid fa-plus"></i>
            <span>+ Catat Surat Masuk</span>
        </button>
    </div>

    <!-- Table Container (Clean White Background Card) -->
    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        
        <!-- Table Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tampilkan</span>
                <form action="{{ route('admin.incoming-letters.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-slate-200 outline-none shadow-sm">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">surat</span>
            </div>

            <form action="{{ route('admin.incoming-letters.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor / pengirim / perihal..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800 dark:text-slate-200">
                <thead class="bg-[#0B132B] dark:bg-[#070D1E] text-white uppercase tracking-wider text-[11px] border-b border-blue-950">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16 font-bold">NO</th>
                        <th class="py-3.5 px-6 font-bold">NOMOR & TGL SURAT</th>
                        <th class="py-3.5 px-6 font-bold">PENGIRIM / INSTANSI</th>
                        <th class="py-3.5 px-6 font-bold">PERIHAL & RINGKASAN</th>
                        <th class="py-3.5 px-6 text-center font-bold">STATUS DISPOSISI</th>
                        <th class="py-3.5 px-6 text-center w-36 font-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($letters as $index => $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500 dark:text-slate-400">{{ $letters->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white font-mono">{{ $item->nomor_surat }}</div>
                                <div class="text-[11px] text-slate-600 dark:text-slate-400">Tgl: {{ $item->tanggal_surat ? $item->tanggal_surat->format('d/m/Y') : '-' }}</div>
                                <div class="text-[10px] text-emerald-700 dark:text-emerald-400 font-semibold">Diterima: {{ $item->tanggal_diterima ? $item->tanggal_diterima->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $item->pengirim }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white leading-snug">{{ $item->perihal }}</div>
                                @if($item->isi_ringkas)
                                    <div class="text-[11px] text-slate-600 dark:text-slate-400 mt-1 line-clamp-2">{{ $item->isi_ringkas }}</div>
                                @endif
                                @if($item->file_lampiran)
                                    <a href="{{ asset('storage/' . $item->file_lampiran) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-blue-600 dark:text-blue-400 hover:underline mt-1 font-semibold">
                                        <i class="fa-solid fa-paperclip"></i> Lihat File Dokumen
                                    </a>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-700">
                                    {{ $item->status_disposisi ?? 'Diterima' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('admin.incoming-letters.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus surat masuk ini?')" class="inline">
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
                            <td colspan="6" class="py-12 text-center text-slate-500 dark:text-slate-400 font-medium">
                                Belum ada data surat masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 dark:text-slate-400 gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div>
                Menampilkan {{ $letters->firstItem() ?? 0 }} s/d {{ $letters->lastItem() ?? 0 }} dari {{ $letters->total() }} surat
            </div>
            <div>
                {{ $letters->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <!-- Modal Tambah Surat Masuk -->
    <div x-show="showModalTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 text-slate-900 dark:text-white" @click.away="showModalTambah = false">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-[#0B132B] dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open-text text-blue-600 dark:text-amber-400"></i> Catat Surat Masuk Baru
                </h3>
                <button @click="showModalTambah = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form action="{{ route('admin.incoming-letters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nomor Surat Masuk *</label>
                    <input type="text" name="nomor_surat" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: 005/124/Diskominfo/2026">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tanggal Surat *</label>
                        <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tanggal Diterima *</label>
                        <input type="date" name="tanggal_diterima" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Pengirim / Asal Instansi *</label>
                    <input type="text" name="pengirim" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Dinas Kominfo Kabupaten Banyuasin">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Perihal Surat *</label>
                    <input type="text" name="perihal" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Undangan Rapat Koordinasi Forum Pers">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Ringkasan / Catatan Isi</label>
                    <textarea name="isi_ringkas" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Ringkasan poin isi surat..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Status Disposisi</label>
                    <input type="text" name="status_disposisi" value="Diterima" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Disposisi Ketua / Arsip">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Upload File Lampiran PDF/Foto (Opsional)</label>
                    <input type="file" name="file_lampiran" class="w-full px-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" @click="showModalTambah = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
