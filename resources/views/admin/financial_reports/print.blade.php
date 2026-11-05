<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - {{ $report->judul_kegiatan }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style id="dynamic-paper-style">
        @page {
            size: A4 landscape;
            margin: 0.5cm 0 12mm 0;
            margin-top: 0.5cm;
            margin-bottom: 12mm;
            margin-left: 0;
            margin-right: 0;
        }
    </style>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #f1f5f9;
            margin: 0;
            padding: 15px 0 40px 0;
            font-size: 10pt;
            line-height: 1.4;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .paper-toolbar {
            max-width: 297mm;
            margin: 0 auto 16px auto;
            padding: 10px 18px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            font-family: system-ui, -apple-system, sans-serif;
        }
        .page-sheet {
            width: 297mm;
            min-height: 210mm;
            max-width: 100%;
            margin: 0 auto;
            background: #ffffff;
            padding: 0.5cm 18mm 16mm 18mm;
            box-shadow: 0 4px 25px rgba(0,0,0,0.12);
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            position: relative;
            transition: width 0.2s, min-height 0.2s;
        }
        .kop-header {
            margin: -0.5cm -18mm 16px -18mm;
        }
        .kop-box {
            background-color: #0B4DA2 !important;
            color: #ffffff !important;
            border-radius: 0;
            padding: 10px 24px 8px 24px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            box-sizing: border-box;
        }
        .kop-logo {
            width: 2.8cm;
            height: 2.5cm;
            object-fit: contain;
            flex-shrink: 0;
        }
        .kop-titles {
            text-align: right;
            width: 100%;
            margin-left: 20px;
            min-width: 0;
        }
        .kop-title-1 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 20pt;
            font-weight: 700;
            letter-spacing: -0.2px;
            margin: 0;
            line-height: 1.1;
            text-transform: uppercase;
            color: #ffffff !important;
            white-space: nowrap;
        }
        .kop-title-2 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13pt;
            font-weight: 700;
            letter-spacing: 0.2px;
            margin: 2px 0 0 0;
            line-height: 1.15;
            text-transform: uppercase;
            color: #ffffff !important;
            white-space: nowrap;
        }
        .kop-title-3 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11.5pt;
            font-weight: 400;
            margin: 2px 0 0 0;
            letter-spacing: 0.1px;
            line-height: 1.15;
            color: #ffffff !important;
            white-space: nowrap;
        }
        .kop-title-4 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11.5pt;
            font-weight: 700;
            letter-spacing: 0.2px;
            margin: 1px 0 0 0;
            text-transform: uppercase;
            line-height: 1.15;
            color: #ffffff !important;
            white-space: nowrap;
        }
        .kop-address {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5pt;
            text-align: center;
            font-weight: 700;
            line-height: 1.25;
            margin-top: 3px;
            padding: 0 15px;
            color: #000;
            letter-spacing: -0.15px;
            white-space: nowrap;
        }
        .kop-divider {
            border-top: 2.5px solid #000;
            border-bottom: 1px solid #000;
            height: 3.5px;
            margin-top: 4px;
            margin-bottom: 14px;
        }
        .report-body {
            padding: 0;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 12px;
            font-size: 10.5pt;
        }
        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
        }
        .finance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-bottom: 12px;
        }
        .finance-table th, .finance-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }
        .finance-table thead th {
            text-align: center;
            font-weight: bold;
            background-color: #f1f5f9;
        }
        .signature-block {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            margin-top: 15px;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .paper-toolbar {
                display: none !important;
            }
            .page-sheet {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }
            .kop-header {
                margin: 0 0 12px 0 !important;
                width: 100% !important;
                display: block !important;
            }
            .kop-box {
                background-color: #0B4DA2 !important;
                color: #ffffff !important;
                padding: 8px 20px 6px 20px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                box-sizing: border-box !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .kop-logo {
                width: 2.6cm !important;
                height: 2.3cm !important;
                object-fit: contain !important;
                flex-shrink: 0 !important;
                display: block !important;
            }
            .kop-titles {
                text-align: right !important;
                width: 100% !important;
                margin-left: 16px !important;
                min-width: 0 !important;
                display: block !important;
            }
            .kop-title-1 {
                font-family: 'Times New Roman', Times, serif !important;
                font-size: 19pt !important;
                font-weight: 700 !important;
                margin: 0 !important;
                line-height: 1.1 !important;
                color: #ffffff !important;
                white-space: nowrap !important;
            }
            .kop-title-2 {
                font-family: Arial, Helvetica, sans-serif !important;
                font-size: 12.5pt !important;
                font-weight: 700 !important;
                margin: 2px 0 0 0 !important;
                line-height: 1.15 !important;
                color: #ffffff !important;
                white-space: nowrap !important;
            }
            .kop-title-3, .kop-title-4 {
                font-family: Arial, Helvetica, sans-serif !important;
                font-size: 11pt !important;
                margin: 1px 0 0 0 !important;
                line-height: 1.15 !important;
                color: #ffffff !important;
                white-space: nowrap !important;
            }
            .kop-address {
                font-family: Arial, Helvetica, sans-serif !important;
                font-size: 8.5pt !important;
                text-align: center !important;
                font-weight: 700 !important;
                line-height: 1.25 !important;
                margin-top: 3px !important;
                padding: 0 15px !important;
                color: #000000 !important;
                letter-spacing: -0.15px !important;
                white-space: nowrap !important;
                display: block !important;
            }
            .kop-divider {
                border-top: 2.5px solid #000 !important;
                border-bottom: 1px solid #000 !important;
                height: 3.5px !important;
                margin-top: 3px !important;
                margin-bottom: 12px !important;
                display: block !important;
            }
            .report-body {
                padding: 0 16mm !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Toolbar Atas (Hidden saat Cetak) -->
<div class="no-print paper-toolbar">
    <div class="d-flex align-items-center gap-2">
        <strong class="text-dark">Laporan Keuangan:</strong> 
        <span class="text-secondary small">{{ $report->judul_kegiatan }}</span>
    </div>
    <div class="d-flex align-items-center gap-2">
        <div class="d-flex align-items-center gap-1 bg-light px-2 py-1 rounded border">
            <span class="text-muted fw-bold" style="font-size: 11px; text-transform: uppercase;">Kertas (Landscape):</span>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" id="btn-paper-a4" onclick="setPaperSize('a4')" class="btn btn-primary btn-sm px-2.5 py-0 fw-bold" style="font-size: 11px;">
                    A4 Landscape
                </button>
                <button type="button" id="btn-paper-legal" onclick="setPaperSize('legal')" class="btn btn-outline-secondary btn-sm px-2.5 py-0 fw-bold" style="font-size: 11px;">
                    Legal (F4) Landscape
                </button>
            </div>
        </div>

        <button onclick="window.print()" class="btn btn-primary btn-sm px-3 shadow-sm fw-bold">
            <i class="fa-solid fa-print me-1"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary btn-sm px-3">
            Tutup
        </button>
    </div>
</div>

<div class="page-sheet" id="printSheet">
    
    <!-- Kop Surat Resmi PWI Banyuasin (Sama Persis seperti Template Surat & Notulen) -->
    <div class="kop-header kop-surat">
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
            {{ str_replace([', Kecamatan', ', Kabupaten'], [' Kecamatan', ' Kabupaten'], $settings['alamat_kantor'] ?? 'Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung Kecamatan Banyuasin III Kabupaten Banyuasin - Sumatera Selatan (30914)') }}
        </div>
        <div class="kop-divider"></div>
    </div>

    <!-- Body Laporan Keuangan -->
    <div class="report-body">

        <!-- Detail Informasi Kegiatan (Sesuai Lampiran Pengguna) -->
        <table class="meta-table">
            <tr>
                <td style="width: 190px; font-weight: bold;">Judul kegiatan</td>
                <td style="width: 15px; text-align: center;">:</td>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $report->judul_kegiatan }}</td>
            </tr>
            @if($report->lanjutan_nama_kegiatan)
            <tr>
                <td style="font-weight: bold;">Lanjutan Nama Kegiatan</td>
                <td style="text-align: center;">:</td>
                <td style="font-weight: bold;">{{ $report->lanjutan_nama_kegiatan }}</td>
            </tr>
            @endif
            @if($report->hari_tanggal)
            <tr>
                <td style="font-weight: bold;">Hari / Tgl / Bulan</td>
                <td style="text-align: center;">:</td>
                <td>{{ $report->hari_tanggal }}</td>
            </tr>
            @endif
            @if($report->tempat)
            <tr>
                <td style="font-weight: bold;">Tempat Kegiatan</td>
                <td style="text-align: center;">:</td>
                <td>{{ $report->tempat }}</td>
            </tr>
            @endif
        </table>

        <!-- Tabel Bersebelahan: PENERIMAAN (Kiri) & PENGELUARAN (Kanan) -->
        <table class="finance-table">
            <thead>
                <tr>
                    <th colspan="3" style="width: 50%; background-color: #e2e8f0; font-size: 10.5pt; letter-spacing: 0.5px;">PENERIMAAN</th>
                    <th colspan="3" style="width: 50%; background-color: #e2e8f0; font-size: 10.5pt; letter-spacing: 0.5px;">PENGELUARAN</th>
                </tr>
                <tr>
                    <th style="width: 12%;">TANGGAL</th>
                    <th style="width: 26%;">URAIAN</th>
                    <th style="width: 12%;">JUMLAH</th>
                    <th style="width: 12%;">TANGGAL</th>
                    <th style="width: 26%;">URAIAN</th>
                    <th style="width: 12%;">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < $maxRows; $i++)
                    @php
                        $itemP = $penerimaan[$i] ?? null;
                        $itemK = $pengeluaran[$i] ?? null;
                    @endphp
                    <tr>
                        <!-- Penerimaan Cell -->
                        <td class="text-center" style="height: 25px;">{{ $itemP?->tanggal ?? '' }}</td>
                        <td>{{ $itemP?->uraian ?? '' }}</td>
                        <td class="text-end">
                            {{ $itemP ? number_format($itemP->jumlah, 0, ',', '.') : '' }}
                        </td>

                        <!-- Pengeluaran Cell -->
                        <td class="text-center">{{ $itemK?->tanggal ?? '' }}</td>
                        <td>{{ $itemK?->uraian ?? '' }}</td>
                        <td class="text-end">
                            {{ $itemK ? number_format($itemK->jumlah, 0, ',', '.') : '' }}
                        </td>
                    </tr>
                @endfor

                <!-- Baris TOTAL / JUMLAH -->
                <tr style="font-weight: bold; background-color: #f8fafc;">
                    <td colspan="2" class="text-center">JUMLAH</td>
                    <td class="text-end">{{ number_format($report->total_penerimaan, 0, ',', '.') }}</td>
                    <td colspan="2" class="text-center">JUMLAH</td>
                    <td class="text-end">{{ number_format($report->total_pengeluaran, 0, ',', '.') }}</td>
                </tr>

                <!-- Baris SALDO (Diletakkan di Bawah Sisi Pengeluaran) -->
                <tr>
                    <td colspan="3" style="border: none; background: transparent;"></td>
                    <td colspan="2" class="text-center fw-bold" style="background-color: #f1f5f9;">SALDO</td>
                    <td class="text-end fw-bold" style="background-color: #f1f5f9;">
                        {{ number_format($report->saldo, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        @if($report->keterangan)
            <div style="font-size: 8.5pt; font-style: italic; margin-top: 4px; color: #475569;">
                <strong>Catatan:</strong> {{ $report->keterangan }}
            </div>
        @endif

        <!-- Lembar Pengesahan Tanda Tangan -->
        <div class="signature-block">
            <div class="row">
                <!-- Kolom Kiri: Mengetahui Ketua -->
                <div class="col-6 text-center">
                    <div>Mengetahui,</div>
                    <div style="font-weight: 500;">{{ $report->jabatan_mengetahui }}</div>
                    <div style="height: 60px;"></div>
                    <div class="fw-bold text-decoration-underline" style="font-size: 11pt;">{{ $report->nama_mengetahui }}</div>
                    <div style="font-size: 9.5pt;">Ketua</div>
                </div>

                <!-- Kolom Kanan: Bendahara -->
                <div class="col-6 text-center">
                    <div>{{ $report->tempat_tanggal_ttd ?: 'Pangkalan Balai, ' . now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: 500;">{{ $report->jabatan_bendahara }}</div>
                    <div style="height: 60px;"></div>
                    <div class="fw-bold text-decoration-underline" style="font-size: 11pt;">{{ $report->nama_bendahara }}</div>
                    <div style="font-size: 9.5pt;">Bendahara</div>
                </div>
            </div>
        </div>

    </div> <!-- end report-body -->

</div>

<script>
    function setPaperSize(size) {
        const sheet = document.getElementById('printSheet');
        const btnA4 = document.getElementById('btn-paper-a4');
        const btnLegal = document.getElementById('btn-paper-legal');
        const dynamicStyle = document.getElementById('dynamic-paper-style');

        if (size === 'legal') {
            sheet.style.width = '356mm';
            sheet.style.minHeight = '216mm';
            dynamicStyle.innerHTML = '@page { size: 356mm 216mm landscape; margin: 0.5cm 0 12mm 0; margin-top: 0.5cm; margin-bottom: 12mm; margin-left: 0; margin-right: 0; }';
            btnLegal.className = 'btn btn-primary btn-sm px-2.5 py-0 fw-bold';
            btnA4.className = 'btn btn-outline-secondary btn-sm px-2.5 py-0 fw-bold';
        } else {
            sheet.style.width = '297mm';
            sheet.style.minHeight = '210mm';
            dynamicStyle.innerHTML = '@page { size: A4 landscape; margin: 0.5cm 0 12mm 0; margin-top: 0.5cm; margin-bottom: 12mm; margin-left: 0; margin-right: 0; }';
            btnA4.className = 'btn btn-primary btn-sm px-2.5 py-0 fw-bold';
            btnLegal.className = 'btn btn-outline-secondary btn-sm px-2.5 py-0 fw-bold';
        }
    }
</script>
</body>
</html>

