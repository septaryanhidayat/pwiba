@extends('layouts.admin')

@section('title', 'Edit Surat Keluar')
@section('page_title', 'Edit Surat Keluar')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Edit Surat Keluar</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-mono">{{ $letter->nomor_surat }} ({{ $letter->jenis_surat }})</p>
        </div>
        <a href="{{ route('admin.letters.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nomor Surat *</label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $letter->nomor_surat) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-mono font-bold text-blue-700 dark:text-amber-400 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $letter->tanggal ? $letter->tanggal->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Jenis Surat *</label>
                    <select name="jenis_surat" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                        <option value="SURAT TUGAS" {{ $letter->jenis_surat === 'SURAT TUGAS' ? 'selected' : '' }}>SURAT TUGAS</option>
                        <option value="SURAT AUDENSI" {{ $letter->jenis_surat === 'SURAT AUDENSI' ? 'selected' : '' }}>SURAT AUDENSI</option>
                        <option value="SURAT BIASA" {{ $letter->jenis_surat === 'SURAT BIASA' ? 'selected' : '' }}>SURAT BIASA</option>
                        <option value="PROPOSAL" {{ $letter->jenis_surat === 'PROPOSAL' ? 'selected' : '' }}>PROPOSAL</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Anggota yang Ditugaskan (Jika Surat Tugas)</label>
                    <select name="member_id" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ $letter->member_id == $m->id ? 'selected' : '' }}>{{ $m->nama }} ({{ $m->jabatan }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tujuan / Jabatan / Instansi *</label>
                    <input type="text" name="tujuan" value="{{ old('tujuan', $letter->tujuan) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Bupati Banyuasin / Kapolres Banyuasin">
                    <span class="text-[11px] text-slate-500 mt-1 block">Nama lembaga, instansi, atau jabatan tujuan.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nama Penerima / Pejabat (Opsional)</label>
                    <input type="text" name="nama_pejabat" value="{{ old('nama_pejabat', $letter->nama_pejabat) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: H. Lamosin / Drs. H. Erwin Ibrahim, S.T., M.M., M.B.A.">
                    <span class="text-[11px] text-slate-500 mt-1 block">Nama orang/pejabat penerima (u.p.).</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tempat / Kota Tujuan</label>
                    <input type="text" name="tempat_tujuan" value="{{ old('tempat_tujuan', $letter->tempat_tujuan ?? 'Di Tempat') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Di Tempat / Pangkalan Balai / Palembang">
                    <span class="text-[11px] text-slate-500 mt-1 block">Akan tercetak pada format 'di - [Tempat Tujuan]'.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Perihal / Prihal</label>
                    <input type="text" name="perihal" value="{{ old('perihal', $letter->perihal) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Keperluan / Keterangan</label>
                    <textarea name="keperluan" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">{{ old('keperluan', $letter->keperluan) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Isi Lengkap Surat</label>
                    <textarea name="isi_surat" id="isi_surat" rows="8" class="rich-editor w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">{{ old('isi_surat', $letter->isi_surat) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Ganti File Lampiran (Opsional)</label>
                    <input type="file" name="file_dokumen" class="w-full px-4 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white">
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 pt-6 border-t border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Dokumen:</span>
                    @if($letter->status === 'draft')
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-file-pen"></i> DRAFT (Belum Terbit)
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check"></i> TERBIT (Published)
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-2.5">
                    <a href="{{ route('admin.letters.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" name="status" value="draft" class="px-5 py-2.5 rounded-xl text-xs font-bold text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-800 hover:bg-amber-100 dark:hover:bg-amber-900/50 shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-file-pen"></i>
                        <span>Simpan sebagai Draft</span>
                    </button>
                    <button type="submit" name="status" value="published" class="px-7 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Publish / Perbarui Surat</span>
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection

@push('scripts')
    @include('partials.rich-editor')
@endpush
