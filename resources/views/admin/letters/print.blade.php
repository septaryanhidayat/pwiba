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
            margin: 0.5cm 15mm 12mm 15mm;
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
            padding: 0.5cm 18mm 14mm 18mm;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            transition: width 0.2s, min-height 0.2s;
        }
        .kop-box {
            background-color: #0B2B68 !important;
            color: #ffffff !important;
            border-radius: 4px;
            padding: 10px 18px 8px 18px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .kop-logo {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 66px;
            height: 66px;
            object-fit: contain;
        }
        .kop-titles {
            margin: 0 76px;
            text-align: center;
            width: 100%;
        }
        .kop-title-1 {
            font-size: 17pt;
            font-weight: 900;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.1;
            text-transform: uppercase;
        }
        .kop-title-2 {
            font-size: 13pt;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin: 3px 0 0 0;
            line-height: 1.15;
            text-transform: uppercase;
        }
        .kop-title-3 {
            font-size: 9pt;
            font-style: italic;
            margin: 2px 0 0 0;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }
        .kop-title-4 {
            font-size: 9pt;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 1px 0 0 0;
            text-transform: uppercase;
        }
        .kop-address {
            font-size: 8pt;
            text-align: center;
            font-weight: 600;
            line-height: 1.25;
            margin-top: 5px;
            color: #000;
            letter-spacing: -0.1px;
        }
        .kop-divider {
            border-top: 2.5px solid #000;
            border-bottom: 1px solid #000;
            height: 4px;
            margin-top: 5px;
            margin-bottom: 18px;
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
            line-height: 1.55;
            margin-top: 14px;
        }
        .letter-content p {
            margin-bottom: 12px;
            text-indent: 0;
        }
        .signature-section {
            margin-top: 22px;
            float: right;
            width: 340px;
            text-align: center;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            margin-top: 10px;
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

        /* Toolbar Top Style */
        .control-toolbar {
            max-width: 1060px;
            width: calc(100% - 32px);
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 10px 18px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            font-family: system-ui, -apple-system, sans-serif;
            flex-wrap: wrap;
            gap: 12px;
        }
        .control-doc-info {
            font-size: 13px;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: nowrap;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .control-doc-label {
            font-weight: 700;
            color: #475569;
        }
        .control-doc-number {
            color: #1d4ed8;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 700;
            white-space: nowrap;
            letter-spacing: -0.2px;
        }
        .badge-status {
            font-size: 10.5px;
            font-weight: 700;
            white-space: nowrap;
        }
        .control-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .control-paper-group {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            padding: 4px 8px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
        }
        .control-paper-label {
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .page-sheet {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
        }
        @media (max-width: 768px) {
            body {
                padding: 8px 6px 30px 6px;
            }
            .page-sheet {
                width: 100% !important;
                min-height: auto !important;
                padding: 12px 10px !important;
                box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            }
            .control-toolbar {
                width: 100% !important;
                padding: 10px !important;
                gap: 10px !important;
            }
            .control-doc-info {
                flex-wrap: wrap !important;
                white-space: normal !important;
                gap: 6px !important;
            }
            .control-actions {
                width: 100% !important;
                flex-wrap: wrap !important;
                gap: 6px !important;
            }
            .kop-title-1 {
                font-size: 11pt !important;
            }
            .kop-title-2 {
                font-size: 8.5pt !important;
            }
            .kop-title-3, .kop-title-4 {
                font-size: 6.5pt !important;
            }
            .kop-logo {
                width: 42px !important;
                height: 42px !important;
                left: 8px !important;
            }
            .kop-titles {
                margin: 0 46px !important;
            }
            .kop-address {
                white-space: normal !important;
                font-size: 6.5pt !important;
                line-height: 1.15;
            }
            .signature-section {
                float: none !important;
                width: 100% !important;
                margin-top: 20px !important;
            }
        }
    </style>
</head>
<body>

<!-- Control Bar (Hidden when printed) -->
<div class="no-print control-toolbar">
    <div class="control-doc-info">
        <span class="control-doc-label">Dokumen:</span> 
        <span class="control-doc-number">{{ $letter->nomor_surat }}</span>
        @if($letter->status === 'draft')
            <span class="badge bg-warning text-dark px-2.5 py-1 badge-status">
                <i class="fa-solid fa-file-pen me-1"></i> DRAFT (Belum Dipublish)
            </span>
        @else
            <span class="badge bg-success text-white px-2.5 py-1 badge-status">
                <i class="fa-solid fa-circle-check me-1"></i> RESMI / PUBLISHED
            </span>
        @endif
    </div>
    
    <div class="control-actions">
        <div class="control-paper-group">
            <span class="control-paper-label">Kertas:</span>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" id="btn-paper-a4" onclick="setPaperSize('a4')" class="btn btn-primary btn-sm px-2.5 py-1 fw-bold" style="font-size: 11px;">
                    A4
                </button>
                <button type="button" id="btn-paper-legal" onclick="setPaperSize('legal')" class="btn btn-outline-secondary btn-sm px-2.5 py-1 fw-bold" style="font-size: 11px;">
                    Legal (F4)
                </button>
            </div>
        </div>

        <a href="{{ route('admin.letters.export_docx', $letter->id) }}" class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 12px; white-space: nowrap;">
            <i class="fa-solid fa-file-word text-primary"></i> Unduh Word (.docx)
        </a>

        <button onclick="window.print()" class="btn btn-primary btn-sm px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="font-size: 12px; white-space: nowrap;">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary btn-sm px-3 py-1.5" style="font-size: 12px;">
            Tutup
        </button>
    </div>
</div>

<!-- Lembar Kertas Resmi -->
<div class="page-sheet" id="printSheet">

    @if($letter->status === 'draft')
        <div class="no-print alert alert-warning text-center py-2 px-3 mb-3 border border-warning" style="font-size: 11px; font-weight: 700; border-radius: 8px;">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> PERHATIAN: Surat ini masih berstatus DRAFT dan belum diterbitkan secara resmi.
        </div>
    @endif

    <!-- Kop Surat Resmi PWI Banyuasin -->
    <div class="kop-header">
        <div class="kop-box">
            <img src="{{ $settings['logo_url'] ?? asset('assets/images/pwi-logo.webp') }}" alt="Logo PWI" class="kop-logo" onerror="this.onerror=null; this.src='{{ asset('assets/images/pwi-logo.png') }}';">
            <div class="kop-titles">
                <div class="kop-title-1">PERSATUAN WARTAWAN INDONESIA</div>
                <div class="kop-title-2">PENGURUS KABUPATEN BANYUASIN</div>
                <div class="kop-title-3">Central Executive Board</div>
                <div class="kop-title-4">INDONESIAN JOURNALIST'S ASSOCIATION</div>
            </div>
        </div>
        <div class="kop-address">
            {{ $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung, Kecamatan Banyuasin III, Kabupaten Banyuasin - Sumatera Selatan (30914)' }}
        </div>
        <div class="kop-divider"></div>
    </div>

    @if($letter->jenis_surat === 'SURAT TUGAS')
        <!-- Format Khusus Surat Perintah Tugas -->
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 14pt; font-weight: bold; text-decoration: underline;">SURAT PERINTAH TUGAS</div>
            <div style="font-size: 11pt;">Nomor: {{ $letter->nomor_surat }}</div>
        </div>

        <div class="letter-content">
            <p>Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dengan ini memberikan tugas kepada:</p>
            
            <table style="width: 92%; margin-left: 24px; margin-bottom: 14px;" class="letter-table">
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
            <table style="width: 92%; margin-left: 24px; margin-bottom: 14px;" class="letter-table">
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

    @elseif($letter->jenis_surat === 'PROPOSAL')
        <!-- Format Khusus Berkas Proposal Resmi -->
        <div style="text-align: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #0B2B68;">
            <div style="font-size: 15pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; color: #0B2B68;">PROPOSAL KEGIATAN</div>
            <div style="font-size: 12pt; font-weight: bold; margin-top: 6px; color: #1e293b;">{{ $letter->perihal }}</div>
            <div style="font-size: 9.5pt; color: #64748b; margin-top: 4px;">Nomor Register Dokumen: <span style="font-family: monospace; font-weight: bold; color: #0B2B68;">{{ $letter->nomor_surat }}</span></div>
        </div>

        <div class="letter-content" style="text-align: justify; line-height: 1.6; font-size: 11pt;">
            {!! \Illuminate\Support\Str::contains($letter->isi_surat, '<') ? $letter->isi_surat : nl2br(e($letter->isi_surat)) !!}
        </div>

    @else
        <!-- Header Informasi Surat & Tanggal -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            
            <!-- Kolom Kiri: Nomor, Lampiran, Perihal -->
            <div style="flex: 1; max-width: 68%;">
                <table class="letter-table" style="width: 100%;">
                    <tr>
                        <td style="width: 80px; white-space: nowrap;">Nomor</td>
                        <td style="width: 14px; text-align: center;">:</td>
                        <td style="font-weight: bold; white-space: nowrap;">{{ $letter->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td style="white-space: nowrap;">Lampiran</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ $letter->lampiran ?? '1 (Satu) Berkas' }}</td>
                    </tr>
                    <tr>
                        <td style="white-space: nowrap; vertical-align: top;">Perihal</td>
                        <td style="text-align: center; vertical-align: top;">:</td>
                        <td style="font-weight: bold; line-height: 1.35;">{{ $letter->perihal ?? $letter->keperluan }}</td>
                    </tr>
                </table>
            </div>

            <!-- Kolom Kanan: Tanggal Surat -->
            <div style="text-align: right; white-space: nowrap; font-size: 11pt; padding-top: 2px;">
                Pangkalan Balai, {{ $letter->tanggal ? $letter->tanggal->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
            </div>

        </div>

        <!-- Kolom Penerima / Tujuan Surat -->
        <div style="margin-bottom: 18px; line-height: 1.45;">
            <div>Kepada Yth.</div>
            <div style="font-weight: bold;">{{ $letter->tujuan }}</div>
            @if($letter->nama_pejabat && !str_contains(strtolower($letter->tujuan), strtolower($letter->nama_pejabat)))
                <div style="font-weight: bold;">{{ $letter->nama_pejabat }}</div>
            @endif
            @if($letter->alamat_tujuan && !str_contains(strtolower($letter->tujuan), strtolower($letter->alamat_tujuan)))
                <div>{{ $letter->alamat_tujuan }}</div>
            @endif
            <div>di -</div>
            @php
                $cleanLocation = ltrim(preg_replace('/^di\s*[-–:]*\s*/i', '', $letter->tempat_tujuan ?? ($letter->alamat_tujuan ? '' : 'Tempat')));
            @endphp
            <div style="margin-left: 24px;">{{ $cleanLocation ?: 'Tempat' }}</div>
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

    <!-- Blok Tanda Tangan Resmi & QR Code Digital (Rata Kanan Sesuai Dokumen Resmi) -->
    <div class="clearfix" style="margin-top: 22px; page-break-inside: avoid;">
        <div class="signature-section">
            <div>Hormat kami,</div>
            <div style="font-weight: bold; margin-bottom: 4px;">Pengurus PWI Banyuasin</div>

            <!-- QR Code Digital Verification -->
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 4px 0;">
                {!! \App\Helpers\QrCodeHelper::image(route('letter.verify', $letter->uuid ?? $letter->id), 84, 'QR Code Verifikasi Keabsahan Surat') !!}
                <div style="font-size: 7pt; color: #475569; margin-top: 2px; font-style: italic;">
                    Pindai untuk validasi keabsahan dokumen digital
                </div>
            </div>

            <!-- Nama & Jabatan Penandatangan -->
            <table class="signature-table">
                <tr>
                    <td style="width: 50%; text-align: center; vertical-align: top; padding: 0 4px;">
                        <div class="official-name">{{ $letter->penandatangan_nama ?? 'Wardoyo, S.I.Kom' }}</div>
                        <div class="official-role">Ketua</div>
                    </td>
                    <td style="width: 50%; text-align: center; vertical-align: top; padding: 0 4px;">
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
            dynamicStyle.innerHTML = '@page { size: 216mm 356mm portrait; margin: 10mm 15mm 12mm 15mm; }';
            btnLegal.className = 'btn btn-primary btn-sm px-2.5 py-1 fw-bold';
            btnA4.className = 'btn btn-outline-secondary btn-sm px-2.5 py-1 fw-bold';
        } else {
            sheet.style.width = '210mm';
            sheet.style.minHeight = '297mm';
            dynamicStyle.innerHTML = '@page { size: A4 portrait; margin: 10mm 15mm 12mm 15mm; }';
            btnA4.className = 'btn btn-primary btn-sm px-2.5 py-1 fw-bold';
            btnLegal.className = 'btn btn-outline-secondary btn-sm px-2.5 py-1 fw-bold';
        }
    }
</script>
</body>
</html>
