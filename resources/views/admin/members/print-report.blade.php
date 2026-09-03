<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Anggota PWI Banyuasin</title>
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
            font-size: 10.5pt;
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
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .table-custom th, .table-custom td {
            border: 1px solid #000;
            padding: 4px 6px;
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
        <strong>Laporan Rekapitulasi Data Anggota Wartawan PWI Banyuasin</strong>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-print"></i> Cetak / PDF
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
            <img src="{{ asset('assets/images/pwi-logo.png') }}" alt="Logo PWI" width="75" height="75">
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
        <div class="fw-bold text-decoration-underline" style="font-size: 12pt;">DAFTAR REKAPITULASI ANGGOTA WARTAWAN AKTIF</div>
        <div class="small">Per Tanggal: {{ date('d F Y') }}</div>
    </div>

    <!-- Table -->
    <table class="table-custom mb-4">
        <thead>
            <tr class="text-center" style="background-color: #f2f2f2;">
                <th width="30">NO</th>
                <th>NAMA WARTAWAN</th>
                <th width="120">NOMOR KARTU</th>
                <th width="110">TINGKAT UKW</th>
                <th width="90">BERLAKU S/D</th>
                <th>JABATAN</th>
                <th>MEDIA PERS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="fw-bold">{{ $m->nama }}</td>
                    <td class="text-center font-monospace">{{ $m->nomor_kartu ?? '-' }}</td>
                    <td class="text-center">{{ $m->tingkat_ukw }}</td>
                    <td class="text-center">{{ $m->masa_berlaku ? $m->masa_berlaku->format('d/m/Y') : '-' }}</td>
                    <td>{{ $m->jabatan }}</td>
                    <td>{{ $m->nama_media }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data anggota.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="row mt-4">
        <div class="col-6"></div>
        <div class="col-6 text-center">
            <div>Pangkalan Balai, {{ date('d F Y') }}</div>
            <div>Ketua PWI Kabupaten Banyuasin,</div>
            <div style="height: 65px;"></div>
            <div class="fw-bold text-decoration-underline">{{ $settings['ketua_nama'] ?? 'Wardoyo, S.I.Kom' }}</div>
            <div>KTA PWI: 06.00.17208.14B</div>
        </div>
    </div>

</div>

</body>
</html>
