<?php

namespace Database\Seeders;

use App\Models\Letter;
use App\Services\DocumentConverterService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProposalSeminarSeeder extends Seeder
{
    public function run(): void
    {
        $converter = app(DocumentConverterService::class);

        // 1. SURAT KELUAR: Permohonan Sponsorship PT Pegadaian (Persero) Kanwil Sumbagsel
        $nomorSuratPegadaian = '095/PWI-PROP/IX/2026';
        $isiSuratPegadaian = 'Seiring berkembangnya pemanfaatan kecerdasan buatan (Artificial Intelligence) dalam berbagai sektor, insan pers dituntut untuk terus beradaptasi dan meningkatkan kapasitas diri. Sehubungan dengan hal tersebut, Pengurus Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin bermaksud menyelenggarakan kegiatan Seminar Sehari dengan tema:

"Jurnalisme Cerdas di Era AI: Optimalisasi Teknologi Digital untuk Produktivitas Wartawan PWI Banyuasin"

Kegiatan ini bertujuan untuk memberikan pemahaman teknis serta optimalisasi pemanfaatan teknologi digital dalam proses produksi jurnalistik yang profesional, etis, dan produktif bagi wartawan di Kabupaten Banyuasin.

Adapun kegiatan ini rencananya akan dilaksanakan pada:
• Hari / Tanggal : (Disesuaikan/tentatif)
• Waktu : 08.00 WIB s.d. 14.00 Selesai
• Tempat : Gedung Serbaguna Pangkalan Balai, Banyuasin
• Peserta : 50 Orang (Wartawan & Anggota PWI Banyuasin)

Mengingat pentingnya acara ini, kami bermaksud mengajukan permohonan dukungan kerjasama / sponsorship kepada PT Pegadaian (Persero) Kanwil Sumbagsel guna terselenggaranya kegiatan tersebut. Sebagai bentuk kemitraan, kami siap menyediakan ruang publikasi, pencantuman logo perusahaan pada media promosi acara (spanduk, backdrop, sertifikat), serta sesi pengenalan produk/layanan PT Pegadaian kepada seluruh peserta.

Sebagai bahan pertimbangan Bapak/Ibu, bersama surat ini kami lampirkan 1 (satu) berkas proposal yang memuat rincian acara dan rencana anggaran biaya.

Demikian surat pengajuan ini kami sampaikan. Atas perhatian, dukungan, dan kerjasama yang baik dari PT Pegadaian (Persero) Kanwil Sumbagsel, kami ucapkan terima kasih.';

        $suratPegadaian = Letter::updateOrCreate(
            ['nomor_surat' => $nomorSuratPegadaian],
            [
                'uuid' => (string) Str::uuid(),
                'tanggal' => '2026-09-10',
                'jenis_surat' => 'PROPOSAL',
                'status' => 'published',
                'tujuan' => 'Pimpinan Wilayah Kanwil Sumbagsel PT Pegadaian (Persero)',
                'nama_pejabat' => 'Pimpinan Wilayah Kanwil Sumbagsel',
                'jabatan_pejabat' => 'Pimpinan Wilayah',
                'alamat_tujuan' => 'Jl. Merdeka No. 11, Kota Palembang, Sumatera Selatan',
                'tempat_tujuan' => 'Palembang',
                'perihal' => 'Permohonan Dukungan Kerjasama / Sponsorship Seminar Sehari "Jurnalisme Cerdas di Era AI"',
                'keperluan' => 'Permohonan Sponsorship Seminar Sehari Jurnalisme Cerdas di Era AI',
                'lampiran' => '1 (Satu) Berkas Proposal',
                'isi_surat' => $isiSuratPegadaian,
                'penandatangan_nama' => 'Wardoyo, S.I.Kom',
                'penandatangan_sekretaris' => 'Deni Arianto',
                'hash_keabsahan' => hash('sha256', $nomorSuratPegadaian.'|2026-09-10|PWI-BANYUASIN-PEGADAIAN'),
            ]
        );

        // Generate and attach .docx for Surat Pengantar
        try {
            $docxBinary1 = $converter->generateDocx($suratPegadaian);
            $fileName1 = 'letters/095_PWI-PROP_IX_2026_Surat_Sponsorship_Pegadaian.docx';
            Storage::disk('public')->put($fileName1, $docxBinary1);
            $suratPegadaian->file_dokumen = $fileName1;
            $suratPegadaian->save();
        } catch (\Throwable $e) {
            // Ignore if in restricted environment
        }

        // 2. PROPOSAL RESMI: Proposal Seminar Sehari "Jurnalisme Cerdas di Era AI"
        $nomorProposal = '096/PWI-PROP/IX/2026';
        $isiProposal = 'SEMINAR SEHARI
"Jurnalisme Cerdas di Era AI : Optimalisasi Teknologi Digital untuk Produktivitas Wartawan PWI Banyuasin"

A. Latar Belakang
Pesatnya perkembangan kecerdasan buatan (Artificial Intelligence) dan teknologi digital telah mengubah lanskap industri media secara fundamental. Wartawan dituntut untuk bekerja lebih cepat, akurat, dan adaptif tanpa mengesampingkan etika serta kaidah jurnalistik.

Melalui seminar sehari ini, Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin berinisiatif membekali para anggotanya dengan pemahaman dan keterampilan praktis penggunaan perangkat AI untuk meriset data, pemrosesan berita, hingga verifikasi fakta untuk meningkatkan produktivitas dan kualitas karya jurnalistik di daerah.

B. Tujuan Kegiatan
• Memberikan pemahaman komprehensif mengenai pemanfaatan teknologi AI dalam ruang redaksi (newsroom).
• Meningkatkan produktivitas kerja wartawan PWI Banyuasin melalui efisiensi riset dan pengolahan data digital.
• Menjaga integritas dan etika jurnalistik di tengah maraknya konten buatan mesin dan disinformasi.

C. Pelaksanaan Kegiatan
• Bentuk Kegiatan: Seminar Sehari (Diskusi Panel, Pemaparan Materi, dan Tanya Jawab)
• Tanggal / Waktu: [Tentatif] | 08.00 – 16.00 WIB
• Tempat: Auditorium / Gedung Serbaguna Pemkab Banyuasin - Pangkalan Balai
• Target Peserta: 50 Orang (Anggota PWI Banyuasin dan Perwakilan Media Lokal)

D. Rencana Anggaran Biaya (RAB)
1. Kesekretariatan & Perlengkapan:
   • Spanduk / Backdrop (1 unit) = Rp 300.000
   • Sertifikat Peserta & Panitia (60 lembar @ Rp 10.000) = Rp 600.000
   • Seminar Kit (Blocknote, Pena, Map @ Rp 25.000 x 50) = Rp 1.250.000
   • Subtotal: Rp 2.150.000

2. Sewa Tempat & Fasilitas:
   • Sewa Gedung & Sound System (1 hari) = Rp 3.000.000
   • Subtotal: Rp 3.000.000

3. Honorarium:
   • Narasumber Ahli AI / Jurnalistik Digital (2 Orang @ Rp 2.500.000) = Rp 5.000.000
   • Transport & Akomodasi Narasumber = Rp 1.500.000
   • Honor Panitia Pelaksana (10 Orang @ Rp 300.000) = Rp 3.000.000
   • Subtotal: Rp 9.500.000

4. Konsumsi:
   • Snack Pagi & Sore (60 Orang x 2 @ Rp 15.000) = Rp 1.800.000
   • Makan Siang PR/Buffet (60 Orang @ Rp 40.000) = Rp 2.400.000
   • Air Mineral & Coffee Break = Rp 500.000
   • Subtotal: Rp 4.700.000

5. Biaya Tak Terduga / Lain-lain:
   • Alokasi Biaya Tak Terduga (5%) = Rp 1.000.000

REKAPITULASI ANGGARAN:
1. Sekretariat & Perlengkapan: Rp 2.150.000
2. Sewa Gedung & Fasilitas: Rp 3.000.000
3. Honorarium & Akomodasi: Rp 9.500.000
4. Konsumsi: Rp 4.700.000
5. Biaya Tak Terduga: Rp 1.000.000
TOTAL ESTIMASI ANGGARAN: Rp 20.350.000

E. Susunan Panitia Pelaksana
• Penanggung Jawab : Wardoyo, S.I.Kom - Ketua PWI Banyuasin
• Ketua Pelaksana: Quata Akda
• Sekretaris: Deni Arianto
• Bendahara: Ridho Andi Sucipto, M.Pd
• Seksi Acara & Narasumber: Wardoyo - Septa Ryan Hidayat – Pakar AI
• Seksi Perlengkapan & Tempat: Herwanto
• Seksi Konsumsi & Humas: Frans Iskandar

F. Penutup
Demikian proposal kegiatan Seminar Sehari ini disusun sebagai acuan pelaksanaan kegiatan. Dukungan dan partisipasi dari berbagai pihak sangat kami harapkan demi suksesnya acara ini.';

        $proposal = Letter::updateOrCreate(
            ['nomor_surat' => $nomorProposal],
            [
                'uuid' => (string) Str::uuid(),
                'tanggal' => '2026-09-10',
                'jenis_surat' => 'PROPOSAL',
                'status' => 'published',
                'tujuan' => 'PT Pegadaian (Persero) & Mitra Sponsorship PWI Banyuasin',
                'nama_pejabat' => 'Pimpinan Lembaga / Perusahaan Mitra',
                'jabatan_pejabat' => 'Pimpinan Mitra',
                'alamat_tujuan' => 'Pangkalan Balai / Palembang',
                'tempat_tujuan' => 'Pangkalan Balai',
                'perihal' => 'Proposal Seminar Sehari: Jurnalisme Cerdas di Era AI (RAB Rp 20.350.000)',
                'keperluan' => 'Proposal Kegiatan Seminar Sehari Jurnalisme Cerdas di Era AI',
                'lampiran' => 'RAB & Susunan Panitia Lengkap',
                'isi_surat' => $isiProposal,
                'penandatangan_nama' => 'Wardoyo, S.I.Kom',
                'penandatangan_sekretaris' => 'Deni Arianto',
                'hash_keabsahan' => hash('sha256', $nomorProposal.'|2026-09-10|PWI-BANYUASIN-PROPOSAL-AI'),
            ]
        );

        // Generate and attach .docx for Proposal
        try {
            $docxBinary2 = $converter->generateDocx($proposal);
            $fileName2 = 'letters/096_PWI-PROP_IX_2026_Proposal_Seminar_AI_PWI_Banyuasin.docx';
            Storage::disk('public')->put($fileName2, $docxBinary2);
            $proposal->file_dokumen = $fileName2;
            $proposal->save();
        } catch (\Throwable $e) {
            // Ignore if in restricted environment
        }
    }
}
