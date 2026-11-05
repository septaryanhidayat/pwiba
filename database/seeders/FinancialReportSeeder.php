<?php

namespace Database\Seeders;

use App\Models\FinancialReport;
use App\Models\FinancialReportItem;
use Illuminate\Database\Seeder;

class FinancialReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finReport = FinancialReport::updateOrCreate([
            'judul_kegiatan' => 'LAPORAN PERTANGGUNGJAWABAN KEUANGAN',
            'lanjutan_nama_kegiatan' => 'TURNAMEN MINI SOCCER PIALA PWI KABUPATEN BANYUASIN 2026',
        ], [
            'hari_tanggal' => 'Senin - Sabtu, 10 - 15 Agustus 2026',
            'tempat' => 'Lapangan Sedulang Setudung Pangkalan Balai',
            'tempat_tanggal_ttd' => 'Pangkalan Balai, 16 Agustus 2026',
            'nama_mengetahui' => 'Wardoyo, S.I.Kom',
            'jabatan_mengetahui' => 'Ketua PWI Banyuasin',
            'nama_bendahara' => 'Ridho Andi Sucipto, M.Pd',
            'jabatan_bendahara' => 'Bendahara',
            'total_penerimaan' => 10000000,
            'total_pengeluaran' => 8000000,
            'saldo' => 2000000,
            'keterangan' => 'Seluruh nota belanja, kwitansi, dan bukti pembayaran terlampir pada dokumen LPJ fisik di bagian bendahara.',
        ]);

        FinancialReportItem::where('financial_report_id', $finReport->id)->delete();

        // Penerimaan
        FinancialReportItem::create([
            'financial_report_id' => $finReport->id,
            'jenis' => 'penerimaan',
            'tanggal' => '10/08/2026',
            'uraian' => 'Kas Awal Panitia Pelaksana PWI',
            'jumlah' => 5000000,
            'urutan' => 0,
        ]);
        FinancialReportItem::create([
            'financial_report_id' => $finReport->id,
            'jenis' => 'penerimaan',
            'tanggal' => '11/08/2026',
            'uraian' => 'Bantuan Sponsor Bank Sumsel Babel',
            'jumlah' => 3000000,
            'urutan' => 1,
        ]);
        FinancialReportItem::create([
            'financial_report_id' => $finReport->id,
            'jenis' => 'penerimaan',
            'tanggal' => '12/08/2026',
            'uraian' => 'Sumbangan Partisipasi Mitra Instansi Forkopimda',
            'jumlah' => 2000000,
            'urutan' => 2,
        ]);

        // Pengeluaran
        FinancialReportItem::create([
            'financial_report_id' => $finReport->id,
            'jenis' => 'pengeluaran',
            'tanggal' => '11/08/2026',
            'uraian' => 'Sewa Lapangan & Izin Keramaian Pertandingan',
            'jumlah' => 3500000,
            'urutan' => 0,
        ]);
        FinancialReportItem::create([
            'financial_report_id' => $finReport->id,
            'jenis' => 'pengeluaran',
            'tanggal' => '12/08/2026',
            'uraian' => 'Honorarium Perangkat Pertandingan & Wasit Berlisensi',
            'jumlah' => 2500000,
            'urutan' => 1,
        ]);
        FinancialReportItem::create([
            'financial_report_id' => $finReport->id,
            'jenis' => 'pengeluaran',
            'tanggal' => '14/08/2026',
            'uraian' => 'Konsumsi Panitia, Tim Medis, dan Air Mineral Pemain',
            'jumlah' => 2000000,
            'urutan' => 2,
        ]);

        $finReport->recalculateTotals();
    }
}
