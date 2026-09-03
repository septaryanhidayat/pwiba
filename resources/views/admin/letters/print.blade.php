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
    <!-- Kop Surat PWI Banyuasin Resmi (Sesuai Format Lampiran PDF Asli) -->
    <div class="kop-surat">
        <div style="background: #0B2B68; color: #fff; border-radius: 4px; padding: 12px 15px 10px 15px; position: relative; text-align: center;">
            <div style="position: absolute; left: 16px; top: 8px;">
                <img src="{{ asset('assets/images/pwi-logo.svg') }}" alt="Logo PWI" width="76" height="76" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
            </div>
            <div style="margin-left: 70px; margin-right: 20px;">
                <h1 style="font-size: 19pt; font-weight: 900; letter-spacing: 1px; margin: 0; line-height: 1.1; text-transform: uppercase;">
                    PERSATUAN WARTAWAN INDONESIA
                </h1>
                <h2 style="font-size: 14pt; font-weight: 800; letter-spacing: 0.5px; margin: 2px 0 0 0; line-height: 1.2; text-transform: uppercase;">
                    PENGURUS KABUPATEN BANYUASIN
                </h2>
                <div style="font-size: 10pt; font-weight: 600; font-style: italic; margin-top: 3px; letter-spacing: 0.5px; opacity: 0.95;">
                    Central Executive Board
                </div>
                <div style="font-size: 10pt; font-weight: 800; letter-spacing: 1.2px; margin-top: 1px; text-transform: uppercase;">
                    INDONESIAN JOURNALIST'S ASSOCIATION
                </div>
            </div>
        </div>
        <div style="font-size: 8.5pt; text-align: center; font-weight: 600; padding: 5px 0 3px 0; border-bottom: 2.5px solid #000; margin-bottom: 18px; color: #000;">
            {{ $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung Kecamatan Banyuasin III Kabupaten Banyuasin - Sumatera Selatan (30914)' }}
        </div>
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
        <!-- Format Surat Resmi Sesuai Lampiran PDF -->
        <div class="row mb-4">
            <div class="col-7">
                <table style="width: 100%;">
                    <tr>
                        <td width="85" style="vertical-align: top;">Nomor</td>
                        <td width="15" style="vertical-align: top;">:</td>
                        <td class="fw-bold" style="vertical-align: top;">{{ $letter->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Lampiran</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">{{ $letter->lampiran ?? '1 (Satu) Berkas' }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Perihal</td>
                        <td style="vertical-align: top;">:</td>
                        <td class="fw-bold" style="vertical-align: top;">{{ $letter->perihal ?? $letter->keperluan }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-5">
                <div>Pangkalan Balai, {{ $letter->tanggal ? $letter->tanggal->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</div>
                <div class="mt-2">Kepada Yth.</div>
                <div class="fw-bold">{{ $letter->jabatan_pejabat ?? ($letter->tujuan ?? 'Ketua PWI Provinsi Sumatera Selatan') }}</div>
                @if($letter->nama_pejabat && $letter->nama_pejabat !== $letter->tujuan)
                    <div class="fw-bold">{{ $letter->nama_pejabat }}</div>
                @endif
                <div>di -</div>
                <div>{{ $letter->tempat_tujuan ?? ($letter->alamat_tujuan ?? 'Palembang') }}</div>
            </div>
        </div>

        <div class="letter-content" style="font-size: 11pt; line-height: 1.6;">
            <p>Dengan hormat,</p>
            
            @if($letter->isi_surat)
                {!! nl2br(e($letter->isi_surat)) !!}
            @else
                <p>
                    Menindaklanjuti upaya penertiban dan penyelamatan aset organisasi, bersama surat ini kami sampaikan dengan hormat permasalahan internal terkait permintaan penyerahan aset PWI Kabupaten Banyuasin pembeliaannya bersumber dari Dana Hibah Tahun 2024. Berdasarkan laporan yang bersangkutan saat konferda, tanggal 20 September 2025, dibeli sebanyak 2 unit Laptop. Namun sampai berakhir masa jabatannya Laptop belum diserahkan ke PWI Banyuasin.
                </p>
                <p>
                    Adapun permohonan penyerahan aset telah kami layangkan secara resmi sebanyak 3 (tiga) kali kepada ASNAINI KHAMSIN, SE, Ketua PWI Kabupaten Banyuasin Periode 2022-2025. Namun tidak diindahkan sama sekali, dengan rincian sebagai berikut:
                </p>
                <ol>
                    <li>Surat Pertama tanggal 14 Januari 2026 dengan Nomor: 013/PWI-BA/I/2026</li>
                    <li>Surat Kedua tanggal 23 Februari 2026 dengan Nomor: 021/PWI-BA/II/2026 dan</li>
                    <li>Surat Ketiga tanggal 20 Juli 2026. (Salinan surat-surat terlampir)</li>
                </ol>
                <p>
                    Mengingat tidak adanya tanggapan atau itikad baik dari yang bersangkutan, maka berdasarkan hasil Rapat Pengurus PWI Kabupaten Banyuasin yang dilaksanakan, Senin 24 Agustus 2026, diputuskan untuk melaporkan secara resmi kepada PWI Provinsi Sumatera Selatan untuk meminta arahan, petunjuk, serta kebijakan lebih lanjut dalam mengambil langkah-langkah organisasi maupun hukum selanjutnya.
                </p>
            @endif

            <p class="mt-4">
                Demikian surat permohonan ini kami sampaikan. Atas perhatian, petunjuk, dan kebijaksanaan Bapak Ketua PWI Provinsi Sumatera Selatan, kami ucapkan terima kasih.
            </p>
        </div>
    @endif

    <!-- Tanda Tangan Resmi & QR Code Digital Sesuai Lampiran PDF -->
    <div class="mt-4" style="page-break-inside: avoid;">
        <div class="text-center" style="margin-left: auto; width: 420px; text-align: center;">
            <div>Hormat kami,</div>
            <div class="fw-bold mb-2">Pengurus PWI Banyuasin</div>
            
            <!-- QR Code Digital Verification -->
            <div class="my-2 d-flex flex-column align-items-center justify-center">
                {!! \App\Helpers\QrCodeHelper::image(route('letter.verify', $letter->uuid ?? $letter->id), 120, 'QR Code Verifikasi Keabsahan Surat') !!}
                <div style="font-size: 7.5pt; color: #475569; margin-top: 4px; font-style: italic;">
                    Pindai untuk validasi keabsahan dokumen digital
                </div>
            </div>

            <div class="d-flex justify-content-between px-2 mt-2">
                <div style="text-align: center; width: 180px;">
                    <div class="fw-bold text-decoration-underline">{{ $letter->penandatangan_nama ?? 'Wardoyo, S.I.Kom' }}</div>
                    <div style="font-size: 10pt;">Ketua</div>
                </div>
                <div style="text-align: center; width: 180px;">
                    <div class="fw-bold text-decoration-underline">{{ $letter->penandatangan_sekretaris ?? 'Deni Arianto' }}</div>
                    <div style="font-size: 10pt;">Sekretaris</div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
