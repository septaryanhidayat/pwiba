<?php

namespace Database\Seeders;

use App\Models\Letter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RabBanyuasin2027Seeder extends Seeder
{
    /**
     * Run the database seeds for Surat Pengantar & RAB Kegiatan TA 2027.
     */
    public function run(): void
    {
        // 1. Surat Pengantar Program Kerja dan RAB TA 2027
        $pengantarText = "Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin merupakan wadah berhimpunnya para jurnalis profesional yang bertugas di wilayah Kabupaten Banyuasin. PWI memiliki peran strategis dalam mendukung pembangunan daerah melalui pemberitaan yang edukatif, konstruktif, serta sebagai pengawal kebijakan pemerintah daerah.\n\nUntuk meningkatkan kapasitas keanggotaan, menjaga marwah profesi jurnalis, serta mempromosikan potensi Kabupaten Banyuasin di tingkat provinsi maupun nasional, PWI Kabupaten Banyuasin menyusun Program Kerja dan Rencana Anggaran Biaya (RAB) Kegiatan untuk Tahun Anggaran 2027.\n\nSehubungan dengan hal tersebut, kami mengajukan usulan Program Kerja dan RAB sebagai bahan pertimbangan Bapak/Ibu dalam penyusunan anggaran kegiatan Pemerintah Kabupaten Banyuasin TA 2027 (rincian program dan rincian biaya terlampir).\n\nDemikian surat pengajuan ini kami sampaikan. Atas perhatian, dukungan, dan kerja sama yang baik dari Pemerintah Kabupaten Banyuasin, kami ucapkan terima kasih.";

        $pengantarRecipients = "1. Bupati Banyuasin – Bapak Dr.H.Askolani, SH, MH\n2. Ketua DPRD Banyuasin - Bapak Abdul Rais, S.E.,\n3. Sekda Banyuasin - Bapak Ir. Erwin Ibrahim, S.T., M.M., M.B.A., IPU., ASEAN Eng\n4. Kepala BPKAD Kabupaten Banyuasin, Dra. Yuni Khairani, M.Si\nc.q. Kepala Dinas Komunikasi dan Informatika Kabupaten Banyuasin";

        Letter::updateOrCreate(
            ['perihal' => 'Program Kerja dan RAB PWI Banyuasin TA 2027'],
            [
                'uuid' => (string) Str::uuid(),
                'nomor_surat' => '097/PWI-BA/IX/2026',
                'tanggal' => '2026-09-14',
                'jenis_surat' => 'SURAT BIASA',
                'tujuan' => $pengantarRecipients,
                'keperluan' => 'Program Kerja dan RAB PWI Banyuasin TA 2027',
                'perihal' => 'Program Kerja dan RAB PWI Banyuasin TA 2027',
                'tempat_tujuan' => 'Pangkalan Balai',
                'nama_pejabat' => 'Bupati Banyuasin & Jajaran',
                'lampiran' => '1 (Satu) Berkas Proposal & RAB',
                'isi_surat' => $pengantarText,
                'penandatangan_nama' => 'Wardoyo, S.I.Kom',
                'penandatangan_sekretaris' => 'Deni Arianto',
                'status' => 'published',
            ]
        );

        // 2. Proposal & Rincian Anggaran Biaya (RAB) TA 2027
        $proposalIsiHtml = <<<'HTML'
<div style="font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.6; text-align: justify;">
    <p style="margin-bottom: 8px;"><strong>I. Latar Belakang</strong></p>
    <p style="margin-bottom: 14px; text-indent: 28px;">
        Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin merupakan wadah berhimpunnya para jurnalis professional yang bertugas di wilayah Kabupaten Banyuasin. PWI memiliki peran strategis dalam mendukung pembangunan daerah melalui pemberitaan yang edukatif, konstruktif, serta sebagai pengawal kebijakan pemerintah daerah. Guna meningkatkan kapasitas keanggotaan, menjaga marwah profesi jurnalis, serta mempromosikan potensi Kabupaten Banyuasin di tingkat provinsi maupun nasional, PWI Kabupaten Banyuasin menyusun Program Kerja dan Rencana Anggaran Biaya (RAB) Kegiatan untuk Tahun Anggaran 2027.
    </p>

    <p style="margin-bottom: 8px;"><strong>II. Maksud dan Tujuan</strong></p>
    <p style="margin-bottom: 14px; text-indent: 28px;">
        Penguatan Sumberdaya manusia (SDM) Organisasi & Keanggotaan PWI Meningkatkan pemahaman kode etik jurnalistik (KEJ), profesionalisme, dan wawasan keorganisasian bagi anggota baru PWI Banyuasin. Partisipasi Porwanas & HPN 2027 di Provinsi Lampung: Mengirimkan kontingen wartawan PWI Banyuasin pada ajang Pekan Olahraga Wartawan Nasional (Porwanas) serta memperingati Hari Pers Nasional (HPN) 2027 di Lampung sebagai bentuk peran aktif dan promosi daerah Banyuasin.
    </p>

    <p style="margin-bottom: 8px;"><strong>III. Rencana Kegiatan & Rincian Anggaran Biaya (RAB) 2027</strong></p>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 10.5pt;" border="1" cellpadding="6">
        <thead>
            <tr style="background-color: #f1f5f9; text-align: center; font-weight: bold;">
                <th style="width: 38px; padding: 6px; border: 1px solid #334155;">NO</th>
                <th style="padding: 6px; border: 1px solid #334155;">RENCANA KEGIATAN</th>
                <th style="width: 50px; padding: 6px; border: 1px solid #334155; text-align: center;">VOL</th>
                <th style="width: 140px; padding: 6px; border: 1px solid #334155; text-align: right;">JUMLAH</th>
                <th style="width: 60px; padding: 6px; border: 1px solid #334155; text-align: center;">KET</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155; font-weight: bold;">1</td>
                <td style="vertical-align: top; border: 1px solid #334155;">
                    <strong>Penguatan SDM Organisasi PWI Banyuasin</strong>
                    <div style="font-size: 9.5pt; color: #334155; margin-top: 4px; line-height: 1.4;">
                        - Honor Narasumber & pemateri organisasi<br>
                        - Sewa Gedung, Konsumsi, Perlengkapan<br>
                        - KIT Peserta, Cetak Modul<br>
                        - Transportasi
                    </div>
                </td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">1</td>
                <td style="text-align: right; vertical-align: top; border: 1px solid #334155; font-weight: bold;">Rp. 60.000.000</td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">-</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155; font-weight: bold;">2</td>
                <td style="vertical-align: top; border: 1px solid #334155;">
                    <strong>Pekan Olahraga Wartawan Nasional (Porwanas) & Hari Pers Nasional (HPN) Tahun 2027 di Provinsi Lampung</strong>
                    <div style="font-size: 9.5pt; color: #334155; margin-top: 4px; line-height: 1.4;">
                        - Penginapan, transportasi kontingen<br>
                        - Seragam dan Perlengkapan Kontingen<br>
                        - Uang saku peserta/Atlet<br>
                        - Promosi potensi Daerah Banyuasin
                    </div>
                </td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">1</td>
                <td style="text-align: right; vertical-align: top; border: 1px solid #334155; font-weight: bold;">Rp. 120.000.000</td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">-</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155; font-weight: bold;">3</td>
                <td style="vertical-align: top; border: 1px solid #334155;">
                    <strong>Dukungan Sekretariat Kantor PWI Banyuasin</strong>
                    <div style="font-size: 9.5pt; color: #334155; margin-top: 4px; line-height: 1.4;">
                        - Alat Tulis Kantor<br>
                        - Konsumsi Rapat<br>
                        - Listrik, Air, Wi-fi, staf sekretariat 1 orang<br>
                        - Pembuatan laporan berkala
                    </div>
                </td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">1</td>
                <td style="text-align: right; vertical-align: top; border: 1px solid #334155; font-weight: bold;">Rp. 70.000.000</td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">-</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155; font-weight: bold;">4</td>
                <td style="vertical-align: top; border: 1px solid #334155;">
                    <strong>Sewa Kantor Tahun 2027</strong>
                </td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">1</td>
                <td style="text-align: right; vertical-align: top; border: 1px solid #334155; font-weight: bold;">Rp. 25.000.000</td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">-</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155; font-weight: bold;">5</td>
                <td style="vertical-align: top; border: 1px solid #334155;">
                    <strong>Turnamen Mini Soccer PWI Banyuasin ke-2</strong>
                    <div style="font-size: 9.5pt; color: #334155; margin-top: 4px; line-height: 1.4;">
                        - Honor Wasit<br>
                        - Sewa Lapangan<br>
                        - Jersey Tim PWI Banyuasin<br>
                        - Kaos Panitia<br>
                        - Honor Panitia<br>
                        - Honor Medis<br>
                        - Pengamanan
                    </div>
                </td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">1</td>
                <td style="text-align: right; vertical-align: top; border: 1px solid #334155; font-weight: bold;">Rp. 70.000.000</td>
                <td style="text-align: center; vertical-align: top; border: 1px solid #334155;">-</td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="background-color: #e2e8f0; font-weight: bold;">
                <td colspan="3" style="text-align: right; padding: 7px; border: 1px solid #334155; text-transform: uppercase;">JUMLAH</td>
                <td style="text-align: right; padding: 7px; border: 1px solid #334155; color: #0B4DA2;">RP. 345.000.000</td>
                <td style="border: 1px solid #334155;"></td>
            </tr>
            <tr style="background-color: #f8fafc; font-style: italic;">
                <td colspan="5" style="padding: 6px 8px; border: 1px solid #334155; font-size: 9.5pt; text-align: center;">
                    <strong>Terbilang:</strong> Tiga Ratus Empat Puluh Lima Juta Rupiah
                </td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-bottom: 8px;"><strong>IV. Indikator Keberhasilan (Output)</strong></p>
    <ul style="margin-top: 0; margin-bottom: 14px; padding-left: 24px; line-height: 1.5;">
        <li>Terciptanya insan pers Banyuasin yang kompeten</li>
        <li>Terwakilinya Kabupaten Banyuasin dalam ajang tingkat nasional (HPN dan Porwanas) di Provinsi Lampung.</li>
        <li>Terkelolanya sekretariat PWI Banyuasin secara profesional dan berkesinambungan.</li>
    </ul>

    <p style="margin-bottom: 8px;"><strong>V. Penutup</strong></p>
    <p style="margin-bottom: 10px; text-indent: 28px;">
        Demikian Rencana Anggaran Kegiatan PWI Kabupaten Banyuasin Tahun 2027 kami susun. Besar harapan kami Bupati Banyuasin, dan Ketua DPRD Banyuasin, Wakil Ketua dan Anggota DPRD Kabupaten Banyuasin berkenan memberikan dukungan serta merealisasikan alokasi anggaran ini demi kemajuan dunia pers dan pembangunan di Kabupaten Banyuasin.
    </p>
    <p style="margin-bottom: 14px;">
        Atas perhatian dan dukungan Bapak Bupati, kami ucapkan terima kasih.
    </p>
</div>
HTML;

        Letter::updateOrCreate(
            ['perihal' => 'RENCANA ANGGARAN BIAYA (RAB) & KEGIATAN PERSATUAN WARTAWAN INDONESIA (PWI) KABUPATEN BANYUASIN TAHUN ANGGARAN 2027'],
            [
                'uuid' => (string) Str::uuid(),
                'nomor_surat' => '098/PWI-PROP/IX/2026',
                'tanggal' => '2026-09-14',
                'jenis_surat' => 'PROPOSAL',
                'tujuan' => "Bupati Banyuasin\nKetua DPRD Banyuasin\nSekda Banyuasin\nKepala BPKAD Banyuasin",
                'keperluan' => 'Usulan Rencana Anggaran Biaya (RAB) & Kegiatan PWI TA 2027',
                'perihal' => 'RENCANA ANGGARAN BIAYA (RAB) & KEGIATAN PERSATUAN WARTAWAN INDONESIA (PWI) KABUPATEN BANYUASIN TAHUN ANGGARAN 2027',
                'tempat_tujuan' => 'Pangkalan Balai',
                'nama_pejabat' => 'Pemerintah Kabupaten Banyuasin',
                'lampiran' => 'Rincian RAB & Program Kerja',
                'isi_surat' => $proposalIsiHtml,
                'penandatangan_nama' => 'Wardoyo, S.I.Kom',
                'penandatangan_sekretaris' => 'Deni Arianto',
                'status' => 'published',
            ]
        );
    }
}
