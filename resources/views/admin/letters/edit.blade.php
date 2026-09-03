@extends('layouts.admin')

@section('title', 'Edit Surat Keluar')
@section('page_title', 'Edit Surat Keluar')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-white">Edit Surat Keluar</h2>
            <p class="text-xs text-slate-400 mt-1 font-mono">{{ $letter->nomor_surat }} ({{ $letter->jenis_surat }})</p>
        </div>
        <a href="{{ route('admin.letters.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-900 border border-slate-800 hover:text-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Nomor Surat *</label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $letter->nomor_surat) }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs font-mono text-amber-400 focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $letter->tanggal ? $letter->tanggal->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Jenis Surat *</label>
                    <select name="jenis_surat" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        <option value="SURAT TUGAS" {{ $letter->jenis_surat === 'SURAT TUGAS' ? 'selected' : '' }}>SURAT TUGAS</option>
                        <option value="SURAT AUDENSI" {{ $letter->jenis_surat === 'SURAT AUDENSI' ? 'selected' : '' }}>SURAT AUDENSI</option>
                        <option value="SURAT BIASA" {{ $letter->jenis_surat === 'SURAT BIASA' ? 'selected' : '' }}>SURAT BIASA</option>
                        <option value="PROPOSAL" {{ $letter->jenis_surat === 'PROPOSAL' ? 'selected' : '' }}>PROPOSAL</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Anggota yang Ditugaskan (Jika Surat Tugas)</label>
                    <select name="member_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ $letter->member_id == $m->id ? 'selected' : '' }}>{{ $m->nama }} ({{ $m->jabatan }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Tujuan / Penerima *</label>
                    <input type="text" name="tujuan" value="{{ old('tujuan', $letter->tujuan) }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Perihal / Prihal</label>
                    <input type="text" name="perihal" value="{{ old('perihal', $letter->perihal) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Keperluan / Keterangan</label>
                    <textarea name="keperluan" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">{{ old('keperluan', $letter->keperluan) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Isi Lengkap Surat</label>
                    <textarea name="isi_surat" rows="5" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:ring-2 focus:ring-amber-500 outline-none">{{ old('isi_surat', $letter->isi_surat) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Ganti File Lampiran (Opsional)</label>
                    <input type="file" name="file_surat" class="w-full px-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-950">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-800">
                <a href="{{ route('admin.letters.index') }}" class="px-6 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-950">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Perubahan Surat</span>
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
