<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - {{ $letter->nomor_surat }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 20mm 20mm 20mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            padding: 25px;
            font-size: 12pt;
            line-height: 1.5;
        }
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .kop-title-main {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1.1;
        }
        .kop-title-sub {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }
        .kop-address {
            font-size: 9.5pt;
            margin: 6px 0 0 0;
            line-height: 1.3;
        }
        .letter-content {
            text-align: justify;
            min-height: 320px;
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
        <strong>Format Cetak Resmi:</strong> {{ $letter->nomor_surat }} ({{ $letter->jenis_surat }})
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-print"></i> Cetak Surat Resmi (PDF/Print)
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm">
            Tutup
        </button>
    </div>
</div>

<div class="container-fluid px-0">
    <!-- Kop Surat PWI Resmi -->
    <div class="kop-surat d-flex align-items-center">
        <div style="width: 100px; text-align: center;">
            <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo PWI" width="88" height="88">
        </div>
        <div class="text-center flex-grow-1 px-2">
            <div class="kop-title-main">PERSATUAN WARTAWAN INDONESIA</div>
            <div class="kop-title-sub">KABUPATEN BANYUASIN</div>
            <div class="kop-address">
                Sekretariat: {{ $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kel. Mulya Agung Kec. Banyuasin III' }}<br>
                Telepon: {{ $settings['no_telp'] ?? '0853-7799-1976' }} | Email: {{ $settings['email'] ?? 'sekretariat@pwibanyuasin.or.id' }}
            </div>
        </div>
        <div style="width: 100px;"></div>
    </div>

    @if($letter->jenis_surat === 'SURAT TUGAS')
        <!-- Specific Surat Tugas Format -->
        <div class="text-center mb-4">
            <div class="fw-bold text-decoration-underline" style="font-size: 14pt;">SURAT PERINTAH TUGAS</div>
            <div class="small">Nomor: {{ $letter->nomor_surat }}</div>
        </div>

        <div class="letter-content">
            <p>Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dengan ini memberikan tugas kepada:</p>
            
            <table class="table table-sm table-borderless ms-4 mb-3" style="width: 90%;">
                <tr>
                    <td width="150" class="fw-bold">Nama</td>
                    <td width="15">:</td>
                    <td class="fw-bold">{{ $letter->member->nama ?? $letter->penandatangan_nama }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Nomor KTA PWI</td>
                    <td>:</td>
                    <td>{{ $letter->member->nomor_kartu ?? '06.00.17208.14B' }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Jabatan / Media</td>
                    <td>:</td>
                    <td>{{ $letter->member->jabatan ?? 'Pengurus' }} / {{ $letter->member->nama_media ?? 'PWI Banyuasin' }}</td>
                </tr>
            </table>

            <p>Untuk melaksanakan tugas dan menghadiri:</p>
            <table class="table table-sm table-borderless ms-4 mb-3" style="width: 90%;">
                <tr>
                    <td width="150" class="fw-bold">Keperluan Tugas</td>
                    <td width="15">:</td>
                    <td>{{ $letter->keperluan }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Tujuan / Lokasi</td>
                    <td>:</td>
                    <td>{{ $letter->tujuan }} {{ $letter->lokasi ? '('.$letter->lokasi.')' : '' }}</td>
                </tr>
                @if($letter->tanggal_mulai)
                <tr>
                    <td class="fw-bold">Waktu Pelaksanaan</td>
                    <td>:</td>
                    <td>{{ $letter->tanggal_mulai ? $letter->tanggal_mulai->translatedFormat('d F Y') : '' }} s/d {{ $letter->tanggal_selesai ? $letter->tanggal_selesai->translatedFormat('d F Y') : 'Selesai' }}</td>
                </tr>
                @endif
            </table>

            <p class="mt-4">
                Demikian Surat Tugas ini dibuat dan diberikan untuk dapat dipergunakan sebagaimana mestinya dan dilaksanakan dengan penuh rasa tanggung jawab.
            </p>
        </div>

    @else
        <!-- Format Surat Audiensi / Biasa / Proposal -->
        <div class="row mb-4">
            <div class="col-7">
                <table>
                    <tr>
                        <td width="100">Nomor</td>
                        <td width="15">:</td>
                        <td class="fw-bold">{{ $letter->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td>{{ $letter->lampiran ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td class="fw-bold">{{ $letter->perihal ?? $letter->keperluan }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-5 text-end">
                Pangkalan Balai, {{ $letter->tanggal ? $letter->tanggal->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="mb-4">
            <div>Kepada Yth.</div>
            <div class="fw-bold">{{ $letter->tujuan }}</div>
            <div>{{ $letter->tempat_tujuan ?? 'Di Tempat' }}</div>
        </div>

        <div class="letter-content">
            <p>Dengan hormat,</p>
            
            @if($letter->isi_surat)
                {!! nl2br(e($letter->isi_surat)) !!}
            @else
                <p>
                    Sehubungan dengan pelaksanaan program kerja dan kegiatan Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin, bersama ini kami menyampaikan maksud dan permohonan terkait <strong>{{ $letter->keperluan }}</strong>.
                </p>
                <p>
                    Besar harapan kami agar permohonan dan koordinasi ini dapat terjalin dengan baik demi mendukung kemajuan kemitraan, transparansi informasi, serta kondusifitas pers di Kabupaten Banyuasin.
                </p>
            @endif

            <p class="mt-4">
                Demikian surat ini kami sampaikan. Atas perhatian, dukungan, dan kerja sama yang baik, kami ucapkan terima kasih.
            </p>
        </div>
    @endif

    <!-- Tanda Tangan Resmi Pengurus PWI -->
    <div class="row mt-4">
        <div class="col-12 text-center mb-2">
            <strong>PENGURUS PERSATUAN WARTAWAN INDONESIA (PWI)</strong><br>
            <strong>KABUPATEN BANYUASIN</strong>
        </div>
        
        <div class="col-6 text-center mt-3">
            <div>Ketua,</div>
            <div style="height: 70px;"></div>
            <div class="fw-bold text-decoration-underline">{{ $letter->penandatangan_nama }}</div>
            <div>KTA PWI: 06.00.17208.14B</div>
        </div>

        <div class="col-6 text-center mt-3">
            <div>Sekretaris,</div>
            <div style="height: 70px;"></div>
            <div class="fw-bold text-decoration-underline">{{ $letter->penandatangan_sekretaris ?? 'Deni Arianto' }}</div>
            <div>KTA PWI: 06.00.20644.21B</div>
        </div>
    </div>
</div>

</body>
</html>
