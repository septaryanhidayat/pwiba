<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notulen Rapat - {{ $meeting->judul_rapat }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            padding: 20px;
            font-size: 11pt;
            line-height: 1.4;
        }
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-title-main {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1.1;
        }
        .kop-title-sub {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }
        .kop-address {
            font-size: 9pt;
            margin: 4px 0 0 0;
            line-height: 1.3;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        .table-custom th, .table-custom td {
            border: 1px solid #000;
            padding: 5px 8px;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

<div class="no-print mb-4 d-flex justify-content-between align-items-center bg-light p-3 border rounded">
    <div>
        <strong>Dokumen Notulen Rapat & Daftar Hadir Resmi:</strong> {{ $meeting->judul_rapat }}
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm">
            Tutup
        </button>
    </div>
</div>

<div class="container-fluid px-0">
    
    <!-- Kop Surat PWI -->
    <div class="kop-surat d-flex align-items-center">
        <div style="width: 80px; text-align: center;">
            <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo PWI" width="75" height="75">
        </div>
        <div class="text-center flex-grow-1 px-2">
            <div class="kop-title-main">PERSATUAN WARTAWAN INDONESIA</div>
            <div class="kop-title-sub">KABUPATEN BANYUASIN</div>
            <div class="kop-address">
                Sekretariat: {{ $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kel. Mulya Agung Kec. Banyuasin III' }}<br>
                Telepon: {{ $settings['no_telp'] ?? '0853-7799-1976' }} | Email: {{ $settings['email'] ?? 'sekretariat@pwibanyuasin.or.id' }}
            </div>
        </div>
        <div style="width: 80px;"></div>
    </div>

    <!-- Title -->
    <div class="text-center mb-3">
        <div class="fw-bold text-decoration-underline" style="font-size: 13pt;">BERITA ACARA & NOTULENSI RAPAT</div>
        <div class="small">Nomor: {{ str_pad($meeting->id, 3, '0', STR_PAD_LEFT) }}/BA-NOTULEN/PWI-BA/{{ date('m/Y', strtotime($meeting->tanggal)) }}</div>
    </div>

    <!-- Detail Rapat Table -->
    <table class="table table-sm table-borderless mb-2" style="font-size: 10.5pt;">
        <tr>
            <td width="150" class="fw-bold">Hari / Tanggal</td>
            <td width="15">:</td>
            <td>{{ $meeting->tanggal ? $meeting->tanggal->translatedFormat('l, d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Waktu Pelaksanaan</td>
            <td>:</td>
            <td>{{ $meeting->waktu_mulai ? substr($meeting->waktu_mulai, 0, 5) : '09:00' }} WIB s/d {{ $meeting->waktu_selesai ? substr($meeting->waktu_selesai, 0, 5) : 'Selesai' }} WIB</td>
        </tr>
        <tr>
            <td class="fw-bold">Tempat Rapat</td>
            <td>:</td>
            <td>{{ $meeting->tempat }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Pemimpin Rapat</td>
            <td>:</td>
            <td>{{ $meeting->pemimpin_rapat }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Notulis</td>
            <td>:</td>
            <td>{{ $meeting->notulis }}</td>
        </tr>
    </table>

    <!-- 1. Agenda -->
    <div class="section-title">I. AGENDA RAPAT</div>
    <div class="ps-2 mb-2 text-justify">
        {!! nl2br(e($meeting->agenda)) !!}
    </div>

    <!-- 2. Pembahasan -->
    <div class="section-title">II. JALANNYA PEMBAHASAN / MUSYAWARAH</div>
    <div class="ps-2 mb-2 text-justify">
        {!! nl2br(e($meeting->pembahasan)) !!}
    </div>

    <!-- 3. Kesimpulan -->
    <div class="section-title">III. KESIMPULAN & HASIL KEPUTUSAN RAPAT</div>
    <div class="ps-2 mb-3 text-justify">
        {!! nl2br(e($meeting->kesimpulan)) !!}
    </div>

    <!-- 4. Daftar Hadir Peserta Rapat -->
    <div class="section-title">IV. DAFTAR HADIR PESERTA RAPAT</div>
    <table class="table-custom mb-4">
        <thead>
            <tr class="text-center" style="background-color: #f2f2f2;">
                <th width="35">NO</th>
                <th>NAMA WARTAWAN / ANGGOTA</th>
                <th width="150">JABATAN</th>
                <th width="100">STATUS</th>
                <th width="120">TANDA TANGAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($meeting->attendances as $idx => $att)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="fw-bold">{{ $att->member->nama ?? '-' }}</td>
                    <td>{{ $att->member->jabatan ?? 'ANGGOTA' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $att->status_kehadiran === 'hadir' ? 'text-success border border-success' : 'text-secondary' }}">
                            {{ strtoupper($att->status_kehadiran) }}
                        </span>
                    </td>
                    <td class="text-center" style="height: 28px;">
                        @if($att->status_kehadiran === 'hadir')
                            <span style="font-size: 8pt; color: #555;">[Terverifikasi]</span>
                        @else
                            <span style="font-size: 8pt; color: #888;">({{ $att->status_kehadiran }})</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada catatan kehadiran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Resmi -->
    <div class="row mt-4">
        <div class="col-12 text-center mb-2">
            Pangkalan Balai, {{ $meeting->tanggal ? $meeting->tanggal->translatedFormat('d F Y') : date('d F Y') }}
        </div>
        
        <div class="col-6 text-center mt-2">
            <div>Pemimpin Rapat,</div>
            <div style="height: 65px;"></div>
            <div class="fw-bold text-decoration-underline">{{ $meeting->pemimpin_rapat }}</div>
            <div>Ketua PWI Banyuasin</div>
        </div>

        <div class="col-6 text-center mt-2">
            <div>Notulis Rapat,</div>
            <div style="height: 65px;"></div>
            <div class="fw-bold text-decoration-underline">{{ $meeting->notulis }}</div>
            <div>Sekretaris PWI Banyuasin</div>
        </div>
    </div>

</div>

</body>
</html>
