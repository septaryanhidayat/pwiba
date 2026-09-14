@extends('layouts.admin')

@section('title', 'Edit Surat Keluar')
@section('page_title', 'Surat Keluar')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white tracking-tight">Edit Surat Keluar</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-mono">{{ $letter->nomor_surat }} — <span class="uppercase font-semibold text-blue-600 dark:text-blue-400">{{ $letter->jenis_surat }}</span></p>
        </div>
        <a href="{{ route('admin.letters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Register</span>
        </a>
    </div>

    <form action="{{ route('admin.letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6"
          x-data="{ jenis: '{{ old('jenis_surat', $letter->jenis_surat) }}' }">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-xs space-y-1">
                <div class="font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    <span>Terdapat beberapa kesalahan pengisian formulir:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 pl-2 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            
            <!-- 1. Kategori, Nomor, Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kategori / Jenis Surat *
                    </label>
                    <select name="jenis_surat" x-model="jenis" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                        <option value="SURAT BIASA" {{ $letter->jenis_surat === 'SURAT BIASA' ? 'selected' : '' }}>SURAT BIASA (Kerjasama, Dinas, Undangan)</option>
                        <option value="PROPOSAL" {{ $letter->jenis_surat === 'PROPOSAL' ? 'selected' : '' }}>PROPOSAL (Permohonan Dana, RAB, Sinergi)</option>
                        <option value="SURAT KHUSUS" {{ $letter->jenis_surat === 'SURAT KHUSUS' ? 'selected' : '' }}>SURAT KHUSUS (Tanda Tangan Ketua Saja)</option>
                        <option value="SURAT TUGAS" {{ $letter->jenis_surat === 'SURAT TUGAS' ? 'selected' : '' }}>SURAT TUGAS (Surat Perintah Anggota Wartawan)</option>
                        <option value="SURAT AUDENSI" {{ $letter->jenis_surat === 'SURAT AUDENSI' ? 'selected' : '' }}>SURAT AUDENSI (Permohonan Audiensi Pemkab)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Nomor Surat *
                    </label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $letter->nomor_surat) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-mono font-bold text-blue-700 dark:text-blue-400 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Tanggal Surat *
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $letter->tanggal ? $letter->tanggal->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>
            </div>

            <!-- Banner Khusus: SURAT KHUSUS -->
            <div x-show="jenis === 'SURAT KHUSUS'" x-cloak class="p-4 rounded-xl bg-purple-50 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800/60 text-xs text-purple-900 dark:text-purple-300 flex items-start gap-3">
                <i class="fa-solid fa-stamp text-purple-600 text-base mt-0.5 shrink-0"></i>
                <div class="leading-relaxed">
                    <span class="font-bold">Ketentuan Surat Khusus:</span> Dokumen ini hanya ditandatangani oleh Ketua PWI Kabupaten Banyuasin. Kolom tanda tangan Sekretaris ditiadakan secara otomatis.
                </div>
            </div>

            <!-- Panel Khusus: SURAT TUGAS -->
            <div x-show="jenis === 'SURAT TUGAS'" x-cloak class="p-5 rounded-2xl bg-cyan-50/70 dark:bg-cyan-950/30 border border-cyan-200 dark:border-cyan-800/60 space-y-4">
                <div class="flex items-center gap-2 text-cyan-800 dark:text-cyan-300 font-bold text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-user-tag text-cyan-600"></i>
                    <span>Rincian Penugasan Anggota Wartawan</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Pilih Anggota yang Ditugaskan
                        </label>
                        <select name="member_id" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm">
                            <option value="">-- Pilih Anggota Wartawan --</option>
                            @foreach($members as $m)
                                <option value="{{ $m->id }}" {{ old('member_id', $letter->member_id) == $m->id ? 'selected' : '' }}>{{ $m->nama }} ({{ $m->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Lokasi / Tempat Pelaksanaan
                        </label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $letter->lokasi) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm" placeholder="Contoh: Gedung Banyuasin Convention Center">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                                Tgl Mulai
                            </label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $letter->tanggal_mulai ? $letter->tanggal_mulai->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                                Sampai Dengan
                            </label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $letter->tanggal_selesai ? $letter->tanggal_selesai->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Penerima / Tujuan Surat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Tujuan / Jabatan / Instansi *
                    </label>
                    <textarea name="tujuan" rows="2" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">{{ old('tujuan', $letter->tujuan) }}</textarea>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Nama Penerima / Pejabat (Opsional)
                        </label>
                        <input type="text" name="nama_pejabat" value="{{ old('nama_pejabat', $letter->nama_pejabat) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Dr. H. Askolani, SH., MH">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jabatan Pejabat (Opsional)
                        </label>
                        <input type="text" name="jabatan_pejabat" value="{{ old('jabatan_pejabat', $letter->jabatan_pejabat) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Kepala Dinas / Pimpinan Cabang">
                    </div>
                </div>
            </div>

            <!-- 3. Lokasi & Lampiran -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Tempat / Kota Tujuan
                    </label>
                    <input type="text" name="tempat_tujuan" value="{{ old('tempat_tujuan', $letter->tempat_tujuan ?? 'Di Tempat') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Alamat Surat (Opsional)
                    </label>
                    <input type="text" name="alamat_tujuan" value="{{ old('alamat_tujuan', $letter->alamat_tujuan) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Lampiran
                    </label>
                    <input type="text" name="lampiran" value="{{ old('lampiran', $letter->lampiran ?? '-') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>
            </div>

            <!-- 4. Perihal & Keperluan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Perihal / Hal
                    </label>
                    <input type="text" name="perihal" value="{{ old('perihal', $letter->perihal) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Keperluan / Ringkasan Agenda
                    </label>
                    <input type="text" name="keperluan" value="{{ old('keperluan', $letter->keperluan) }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>
            </div>

            <!-- 5. Editor Visual Lengkap: Isi Dokumen / Surat -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                        Isi Lengkap Redaksi Surat
                    </label>
                    <span class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold">
                        <i class="fa-solid fa-pen-nib me-1"></i> Editor WYSIWYG Modern PWI
                    </span>
                </div>
                <textarea name="isi_surat" id="isi_surat" rows="12" class="rich-editor w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">{{ old('isi_surat', $letter->isi_surat) }}</textarea>
            </div>

            <!-- 6. File Lampiran Berkas Eksternal -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                    Ganti Berkas / Lampiran Tambahan (Opsional)
                </label>
                @if($letter->file_dokumen)
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300">
                            <i class="fa-solid fa-paperclip text-blue-600"></i>
                            <span>Berkas terlampir saat ini: <strong>{{ basename($letter->file_dokumen) }}</strong></span>
                        </div>
                        <a href="{{ asset('storage/' . $letter->file_dokumen) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-bold hover:underline">
                            Lihat / Unduh Berkas
                        </a>
                    </div>
                @endif
                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
            </div>

            <!-- 7. Penandatangan Resmi -->
            <div class="pt-5 border-t border-slate-200 dark:border-slate-800 space-y-4">
                <div class="flex items-center gap-2 text-slate-800 dark:text-white font-bold text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-signature text-blue-600"></i>
                    <span>Penandatangan Dokumen Resmi</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Penandatangan (Ketua) *
                        </label>
                        <input type="text" name="penandatangan_nama" value="{{ old('penandatangan_nama', $letter->penandatangan_nama ?? 'Wardoyo, S.I.Kom') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>

                    <div x-show="jenis !== 'SURAT KHUSUS'" x-cloak>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Penandatangan (Sekretaris)
                        </label>
                        <input type="text" name="penandatangan_sekretaris" value="{{ old('penandatangan_sekretaris', $letter->penandatangan_sekretaris ?? 'Deni Arianto') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    </div>
                </div>
            </div>

            <!-- 8. Tombol Aksi Dokumen -->
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
                    <button type="submit" name="status" value="draft" class="px-5 py-2.5 rounded-xl text-xs font-bold text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-800 hover:bg-amber-100 dark:hover:bg-amber-900/50 shadow-sm transition-all flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-file-pen"></i>
                        <span>Simpan sebagai Draft</span>
                    </button>
                    <button type="submit" name="status" value="published" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2 cursor-pointer">
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
