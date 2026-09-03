@extends('layouts.admin')

@section('title', 'Surat Masuk & Pengarsipan')
@section('page_title', 'Surat Masuk')

@section('content')
<div class="space-y-6" x-data="{ showModalTambah: false, editModalData: null }">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white">Buku Arsip Surat Masuk</h2>
            <p class="text-xs text-slate-400 mt-1">Pencatatan surat dinas dari instansi pemerintah, Forkopimda, dan organisasi luar</p>
        </div>
        <button @click="showModalTambah = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>+ Catat Surat Masuk</span>
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Table Filter Bar -->
        <div class="p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400">Tampilkan</span>
                <form action="{{ route('admin.incoming-letters.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="entries" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 outline-none">
                        <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-xs text-slate-400">surat</span>
            </div>

            <form action="{{ route('admin.incoming-letters.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('entries')) <input type="hidden" name="entries" value="{{ request('entries') }}"> @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor / pengirim / perihal..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 text-slate-400 uppercase tracking-wider text-[11px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6 text-center w-16">NO</th>
                        <th class="py-3.5 px-6">NOMOR & TGL SURAT</th>
                        <th class="py-3.5 px-6">PENGIRIM / INSTANSI</th>
                        <th class="py-3.5 px-6">PERIHAL & RINGKASAN</th>
                        <th class="py-3.5 px-6 text-center">STATUS DISPOSISI</th>
                        <th class="py-3.5 px-6 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($letters as $index => $item)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-slate-500">{{ $letters->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white font-mono">{{ $item->nomor_surat }}</div>
                                <div class="text-[11px] text-slate-400">Tgl: {{ $item->tanggal_surat ? $item->tanggal_surat->format('d/m/Y') : '-' }}</div>
                                <div class="text-[10px] text-emerald-400">Diterima: {{ $item->tanggal_diterima ? $item->tanggal_diterima->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $item->pengirim }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-amber-400 leading-snug">{{ $item->perihal }}</div>
                                @if($item->isi_ringkas)
                                    <div class="text-[11px] text-slate-400 mt-1 line-clamp-2">{{ $item->isi_ringkas }}</div>
                                @endif
                                @if($item->file_lampiran)
                                    <a href="{{ asset('storage/' . $item->file_lampiran) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-blue-400 hover:underline mt-1">
                                        <i class="fa-solid fa-paperclip"></i> Lihat File Dokumen
                                    </a>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    {{ $item->status_disposisi ?? 'Diterima' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('admin.incoming-letters.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus surat masuk ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                Belum ada data surat masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
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
        <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6" @click.away="showModalTambah = false">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open-text text-amber-400"></i> Catat Surat Masuk Baru
                </h3>
                <button @click="showModalTambah = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.incoming-letters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Surat Masuk *</label>
                    <input type="text" name="nomor_surat" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: 005/124/Diskominfo/2026">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Surat *</label>
                        <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Diterima *</label>
                        <input type="date" name="tanggal_diterima" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Pengirim / Asal Instansi *</label>
                    <input type="text" name="pengirim" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Dinas Kominfo Kabupaten Banyuasin">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Perihal Surat *</label>
                    <input type="text" name="perihal" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Undangan Rapat Koordinasi Forum Pers">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Ringkasan / Catatan Isi</label>
                    <textarea name="isi_ringkas" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Ringkasan poin isi surat..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Status Disposisi</label>
                    <input type="text" name="status_disposisi" value="Diterima" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Disposisi Ketua / Arsip">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Upload File Lampiran PDF/Foto (Opsional)</label>
                    <input type="file" name="file_lampiran" class="w-full px-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-950">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="showModalTambah = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300">Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
