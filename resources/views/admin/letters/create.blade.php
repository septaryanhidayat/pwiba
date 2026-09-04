@extends('layouts.admin')

@section('title', 'Buat ' . $jenis)
@section('page_title', 'Surat Keluar')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#0B132B] dark:text-white">Buat {{ $jenis }}</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">Penerbitan surat keluar resmi PWI Kabupaten Banyuasin</p>
        </div>
        <a href="{{ route('admin.letters.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="jenis_surat" value="{{ $jenis }}">
        <input type="hidden" name="nama_pengirim" value="PWI BA">

        <div class="p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nomor Surat Resmi *</label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $generatedNumber ?? $nomorSurat ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-mono font-bold text-blue-700 dark:text-blue-400 focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                    <span class="text-[11px] text-slate-500 mt-1 block">Nomor surat otomatis sesuai format baku organisasi.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tujuan Surat / Nama Penerima *</label>
                    <input type="text" name="tujuan" value="{{ old('tujuan') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Kapolres Banyuasin / Kepala Dinas Kominfo">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tempat Tujuan</label>
                    <input type="text" name="tempat_tujuan" value="{{ old('tempat_tujuan', 'Di Tempat') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Di Tempat / Pangkalan Balai">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Perihal / Hal *</label>
                    <input type="text" name="perihal" value="{{ old('perihal', $jenis === 'SURAT TUGAS' ? 'Surat Tugas Peliputan' : ($jenis === 'SURAT AUDIENSI' ? 'Permohonan Audiensi' : 'Permohonan Sinergi')) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Lampiran</label>
                    <input type="text" name="lampiran" value="{{ old('lampiran', $jenis === 'PROPOSAL' ? '1 (Satu) Berkas' : '-') }}" class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Keperluan / Ringkasan Agenda *</label>
                    <input type="text" name="keperluan" value="{{ old('keperluan') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Contoh: Bantuan Pengamanan Turnamen Mini Soccer 2026">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Isi Lengkap Surat</label>
                    <textarea name="isi_surat" id="isi_surat" rows="8" class="rich-editor w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-sm leading-relaxed text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm" placeholder="Tuliskan redaksi isi surat secara lengkap di sini...">{{ old('isi_surat', 'Sehubungan dengan program kerja Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dalam meningkatkan sinergitas dan profesionalisme pers, dengan ini kami sampaikan...') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Penandatangan (Ketua) *</label>
                    <input type="text" name="penandatangan_nama" value="{{ old('penandatangan_nama', $defaultKetua ?? 'Wardoyo, S.I.Kom') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Jabatan Penandatangan *</label>
                    <input type="text" name="penandatangan_jabatan" value="{{ old('penandatangan_jabatan', 'Ketua PWI Kabupaten Banyuasin') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none shadow-sm">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-800">
                <a href="{{ route('admin.letters.index') }}" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Surat</span>
                </button>
            </div>

        </div>
    </form>

</div>
@endsection

@push('scripts')
    @include('partials.rich-editor')
@endpush
