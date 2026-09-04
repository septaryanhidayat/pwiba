<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Resmi - {{ $letter->nomor_surat }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style id="dynamic-paper-style">
        @page {
            size: A4 portrait;
            margin: 0.5cm 15mm 15mm 15mm;
        }
    </style>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            color: #000;
            background: #f1f5f9;
            margin: 0;
            padding: 15px 0 40px 0;
            font-size: 11pt;
            line-height: 1.5;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .page-sheet {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #fff;
            padding: 0.5cm 20mm 20mm 20mm;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            transition: width 0.2s, min-height 0.2s;
        }
        .kop-box {
            background-color: #0B2B68 !important;
            color: #ffffff !important;
            border-radius: 4px;
            padding: 10px 15px 8px 15px;
            position: relative;
            text-align: center;
        }
        .kop-logo {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 72px;
            height: 72px;
        }
        .kop-title-1 {
            font-size: 18pt;
            font-weight: 900;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.1;
            text-transform: uppercase;
        }
        .kop-title-2 {
            font-size: 13.5pt;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin: 3px 0 0 0;
            line-height: 1.15;
            text-transform: uppercase;
        }
        .kop-title-3 {
            font-size: 9.5pt;
            font-style: italic;
            margin: 2px 0 0 0;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }
        .kop-title-4 {
            font-size: 9.5pt;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 1px 0 0 0;
            text-transform: uppercase;
        }
        .kop-address {
            font-size: 8pt;
            text-align: center;
            font-weight: 600;
            line-height: 1.2;
            margin-top: 4px;
            color: #000;
            white-space: nowrap;
            letter-spacing: -0.15px;
        }
        .kop-divider {
            border-top: 2.5px solid #000;
            border-bottom: 1px solid #000;
            height: 4px;
            margin-top: 5px;
            margin-bottom: 24px;
        }
        .letter-table td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 11pt;
        }
        .letter-content {
            text-align: justify;
            text-justify: inter-word;
            font-size: 11pt;
            line-height: 1.6;
            margin-top: 15px;
        }
        .letter-content p {
            margin-bottom: 14px;
            text-indent: 0;
        }
        .signature-section {
            margin-top: 35px;
            float: right;
            width: 330px;
            text-align: center;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            margin-top: 14px;
        }
        .signature-table td {
            text-align: center;
            vertical-align: top;
            width: 50%;
            font-size: 10.5pt;
        }
        .official-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .official-role {
            font-size: 10.5pt;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #fff;
                padding: 0;
            }
            .page-sheet {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

<!-- Control Bar (Hidden when printed) -->
<div class="no-print" style="max-width: 210mm; margin: 0 auto 15px auto; display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 10px 18px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); font-family: system-ui, -apple-system, sans-serif;">
    <div style="font-size: 13px; color: #1e293b; display: flex; align-items: center; gap: 8px;">
        <span style="font-weight: 700;">Dokumen Resmi:</span> 
        <span style="color: #2563eb; font-weight: 600;">{{ $letter->nomor_surat }}</span>
    </div>
    
    <div style="display: flex; align-items: center; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 6px; background: #f8fafc; padding: 4px 8px; border-radius: 8px; border: 1px solid #cbd5e1;">
            <span style="font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase;">Kertas:</span>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" id="btn-paper-a4" onclick="setPaperSize('a4')" class="btn btn-primary btn-sm px-2.5 py-1" style="font-size: 11px; font-weight: 700;">
                    A4
                </button>
                <button type="button" id="btn-paper-legal" onclick="setPaperSize('legal')" class="btn btn-outline-secondary btn-sm px-2.5 py-1" style="font-size: 11px; font-weight: 700;">
                    Legal (F4)
                </button>
            </div>
        </div>

        <button onclick="window.print()" class="btn btn-primary btn-sm px-3 py-1.5" style="font-weight: 600; font-size: 12px; display: flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary btn-sm px-3 py-1.5" style="font-size: 12px;">
            Tutup
        </button>
    </div>
</div>

<!-- Lembar Kertas Resmi -->
<div class="page-sheet" id="printSheet">

    <!-- Kop Surat Resmi PWI Banyuasin -->
    <div class="kop-header">
        <div class="kop-box">
            <img src="{{ $settings['logo_url'] ?? asset('assets/images/pwi-logo.png') }}" alt="Logo PWI" class="kop-logo">
            <div style="margin-left: 65px; margin-right: 15px;">
                <div class="kop-title-1">PERSATUAN WARTAWAN INDONESIA</div>
                <div class="kop-title-2">PENGURUS KABUPATEN BANYUASIN</div>
                <div class="kop-title-3">Central Executive Board</div>
                <div class="kop-title-4">INDONESIAN JOURNALIST'S ASSOCIATION</div>
            </div>
        </div>
        <div class="kop-address">
            {{ $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung Kecamatan Banyuasin III Kabupaten Banyuasin - Sumatera Selatan (30914)' }}
        </div>
        <div class="kop-divider"></div>
    </div>

    @if($letter->jenis_surat === 'SURAT TUGAS')
        <!-- Format Khusus Surat Perintah Tugas -->
        <div style="text-align: center; margin-bottom: 22px;">
            <div style="font-size: 14pt; font-weight: bold; text-decoration: underline;">SURAT PERINTAH TUGAS</div>
            <div style="font-size: 11pt;">Nomor: {{ $letter->nomor_surat }}</div>
        </div>

        <div class="letter-content">
            <p>Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dengan ini memberikan tugas kepada:</p>
            
            <table style="width: 90%; margin-left: 30px; margin-bottom: 16px;" class="letter-table">
                <tr>
                    <td style="width: 140px; font-weight: bold;">Nama</td>
                    <td style="width: 15px;">:</td>
                    <td style="font-weight: bold;">{{ $letter->member->nama ?? $letter->penandatangan_nama }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Nomor KTA PWI</td>
                    <td>:</td>
                    <td>{{ $letter->member->nomor_kartu ?? '06.00.17208.14B' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Jabatan / Media</td>
                    <td>:</td>
                    <td>{{ $letter->member->jabatan ?? 'Pengurus' }} / {{ $letter->member->nama_media ?? 'PWI Banyuasin' }}</td>
                </tr>
            </table>

            <p>Untuk melaksanakan tugas dan menghadiri:</p>
            <table style="width: 90%; margin-left: 30px; margin-bottom: 16px;" class="letter-table">
                <tr>
                    <td style="width: 140px; font-weight: bold;">Keperluan Tugas</td>
                    <td style="width: 15px;">:</td>
                    <td>{{ $letter->keperluan }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Tujuan / Lokasi</td>
                    <td>:</td>
                    <td>{{ $letter->tujuan }} {{ $letter->lokasi ? '('.$letter->lokasi.')' : '' }}</td>
                </tr>
                @if($letter->tanggal_mulai)
                <tr>
                    <td style="font-weight: bold;">Waktu Pelaksanaan</td>
                    <td>:</td>
                    <td>{{ $letter->tanggal_mulai ? $letter->tanggal_mulai->translatedFormat('d F Y') : '' }} s/d {{ $letter->tanggal_selesai ? $letter->tanggal_selesai->translatedFormat('d F Y') : 'Selesai' }}</td>
                </tr>
                @endif
            </table>

            <p>
                Demikian Surat Tugas ini dibuat dan diberikan untuk dapat dipergunakan sebagaimana mestinya dan dilaksanakan dengan penuh rasa tanggung jawab.
            </p>
        </div>

    @else
        <!-- Struktur Surat Resmi Sesuai Lampiran Asli PDF -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 18px;">
            
            <!-- Kolom Kiri: Nomor, Lampiran, Perihal -->
            <div style="width: 52%;">
                <table class="letter-table" style="width: 100%;">
                    <tr>
                        <td style="width: 82px;">Nomor</td>
                        <td style="width: 15px;">:</td>
                        <td style="font-weight: bold;">{{ $letter->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td>{{ $letter->lampiran ?? '1 (Satu) Berkas' }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td style="font-weight: bold;">{{ $letter->perihal ?? $letter->keperluan }}</td>
                    </tr>
                </table>
            </div>

            <!-- Kolom Kanan: Tanggal & Penerima (Tepat Sejajar Kolom Kiri Sesuai PDF) -->
            <div style="width: 45%; padding-left: 10px;">
                <div style="margin-bottom: 12px;">
                    Pangkalan Balai, {{ $letter->tanggal ? $letter->tanggal->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                </div>
                <div>Kepada Yth.</div>
                <div style="font-weight: bold;">{{ $letter->tujuan }}</div>
                @if($letter->nama_pejabat && $letter->nama_pejabat !== $letter->tujuan)
                    <div style="font-weight: bold;">{{ $letter->nama_pejabat }}</div>
                @endif
                <div>di -</div>
                <div style="margin-left: 20px;">{{ $letter->tempat_tujuan ?? ($letter->alamat_tujuan ?? 'Di Tempat') }}</div>
            </div>

        </div>

        <!-- Isi Surat -->
        <div class="letter-content">
            <div style="margin-bottom: 12px;">Dengan hormat,</div>
            
            @if($letter->isi_surat)
                {!! \Illuminate\Support\Str::contains($letter->isi_surat, '<') ? $letter->isi_surat : nl2br(e($letter->isi_surat)) !!}
            @else
                <p>
                    Sehubungan dengan agenda PWI Kabupaten Banyuasin, bersama ini kami sampaikan maksud {{ $letter->keperluan }}. Besar harapan kami terjalin koordinasi dan kerja sama yang baik.
                </p>
                <p>
                    Demikian surat permohonan ini kami sampaikan. Atas perhatian, petunjuk, dan kebijaksanaan Bapak Ketua PWI Provinsi Sumatera Selatan, kami ucapkan terima kasih.
                </p>
            @endif
        </div>
    @endif

    <!-- Blok Tanda Tangan Resmi & QR Code Digital (Rata Kanan Sesuai Lampiran PDF) -->
    <div class="clearfix">
        <div class="signature-section">
            <div>Hormat kami,</div>
            <div style="font-weight: bold; margin-bottom: 6px;">Pengurus PWI Banyuasin</div>

            <!-- QR Code Digital Verification -->
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 6px 0;">
                {!! \App\Helpers\QrCodeHelper::image(route('letter.verify', $letter->uuid ?? $letter->id), 108, 'QR Code Verifikasi Keabsahan Surat') !!}
                <div style="font-size: 7pt; color: #475569; margin-top: 3px; font-style: italic;">
                    Pindai untuk validasi keabsahan dokumen digital
                </div>
            </div>

            <!-- Nama & Jabatan Penandatangan -->
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="official-name">{{ $letter->penandatangan_nama ?? 'Wardoyo, S.I.Kom' }}</div>
                        <div class="official-role">Ketua</div>
                    </td>
                    <td>
                        <div class="official-name">{{ $letter->penandatangan_sekretaris ?? 'Deni Arianto' }}</div>
                        <div class="official-role">Sekretaris</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>

<script>
    function setPaperSize(size) {
        const sheet = document.getElementById('printSheet');
        const btnA4 = document.getElementById('btn-paper-a4');
        const btnLegal = document.getElementById('btn-paper-legal');
        const dynamicStyle = document.getElementById('dynamic-paper-style');

        if (size === 'legal') {
            sheet.style.width = '216mm';
            sheet.style.minHeight = '356mm';
            dynamicStyle.innerHTML = '@page { size: 216mm 356mm portrait; margin: 0.5cm 15mm 15mm 15mm; }';
            btnLegal.className = 'btn btn-primary btn-sm px-2.5 py-1';
            btnA4.className = 'btn btn-outline-secondary btn-sm px-2.5 py-1';
        } else {
            sheet.style.width = '210mm';
            sheet.style.minHeight = '297mm';
            dynamicStyle.innerHTML = '@page { size: A4 portrait; margin: 0.5cm 15mm 15mm 15mm; }';
            btnA4.className = 'btn btn-primary btn-sm px-2.5 py-1';
            btnLegal.className = 'btn btn-outline-secondary btn-sm px-2.5 py-1';
        }
    }
</script>
</body>
</html>
