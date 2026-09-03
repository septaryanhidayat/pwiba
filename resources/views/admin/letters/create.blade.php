@extends('layouts.admin')

@section('title', 'Buat ' . $jenis)

@section('content')
<div class="page-header-row">
    <div>
        <h2 class="page-title">Buat {{ $jenis }}</h2>
        <small class="text-secondary">Penerbitan surat keluar resmi PWI Kabupaten Banyuasin</small>
    </div>
    <a href="{{ route('admin.letters.index') }}" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="admin-box mt-3">
    <div class="admin-box-body p-4">
        <form action="{{ route('admin.letters.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jenis_surat" value="{{ $jenis }}">
            <input type="hidden" name="nama_pengirim" value="PWI BA">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nomor Surat Resmi *</label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $generatedNumber) }}" class="form-control" required>
                    <small class="text-muted">Nomor surat otomatis sesuai format baku organisasi.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold">Tanggal Surat *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold">Tujuan Surat / Nama Penerima *</label>
                    <input type="text" name="tujuan" value="{{ old('tujuan') }}" class="form-control" required placeholder="Contoh: Kapolres Banyuasin / Kepala Dinas Kominfo">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold">Tempat Tujuan</label>
                    <input type="text" name="tempat_tujuan" value="{{ old('tempat_tujuan', 'Di Tempat') }}" class="form-control" placeholder="Di Tempat / Pangkalan Balai / Palembang">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold">Perihal / Hal *</label>
                    <input type="text" name="perihal" value="{{ old('perihal', $jenis === 'SURAT TUGAS' ? 'Surat Tugas Peliputan' : ($jenis === 'SURAT AUDIENSI' ? 'Permohonan Audiensi' : 'Permohonan Sinergi')) }}" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold">Lampiran</label>
                    <input type="text" name="lampiran" value="{{ old('lampiran', $jenis === 'PROPOSAL' ? '1 (Satu) Berkas' : '-') }}" class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold">Keperluan / Ringkasan Agenda *</label>
                    <input type="text" name="keperluan" value="{{ old('keperluan') }}" class="form-control" required placeholder="Contoh: Bantuan Pengamanan Turnamen Mini Soccer 2026">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold">Isi Lengkap Surat</label>
                    <textarea name="isi_surat" class="form-control" rows="6" placeholder="Tuliskan redaksi isi surat secara lengkap di sini...">{{ old('isi_surat', 'Sehubungan dengan program kerja Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dalam meningkatkan sinergitas dan profesionalisme pers, dengan ini kami sampaikan...') }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold">Penandatangan (Ketua) *</label>
                    <input type="text" name="penandatangan_nama" value="{{ old('penandatangan_nama', $defaultKetua) }}" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold">Jabatan Penandatangan *</label>
                    <input type="text" name="penandatangan_jabatan" value="{{ old('penandatangan_jabatan', 'Ketua PWI Kabupaten Banyuasin') }}" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold">Sekretaris (Tembusan/Co-Sign)</label>
                    <input type="text" name="penandatangan_sekretaris" value="{{ old('penandatangan_sekretaris', 'Deni Arianto') }}" class="form-control">
                </div>

                <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.letters.index') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fa-solid fa-save me-1"></i> Simpan Surat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
