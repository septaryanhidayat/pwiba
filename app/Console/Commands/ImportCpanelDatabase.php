<?php

namespace App\Console\Commands;

use Database\Seeders\ProposalSeminarSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportCpanelDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import-cpanel {file=database/berandad_db_pwiba.sql : Path ke berkas SQL dump cPanel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import dan sinkronisasi seluruh data dari berkas dump SQL cPanel (berandad_db_pwiba.sql) ke database lokal';

    /**
     * Tables to import in dependency order.
     *
     * @var array<string>
     */
    protected array $tables = [
        'users',
        'settings',
        'members',
        'media',
        'organization_structures',
        'leaders',
        'galleries',
        'video_galleries',
        'posts',
        'post_views',
        'chairman_posts',
        'incoming_letters',
        'letters',
        'meeting_minutes',
        'meeting_attendances',
        'inboxes',
        'visitor_logs',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = base_path($this->argument('file'));

        if (! file_exists($filePath)) {
            $this->error("Berkas SQL tidak ditemukan pada: {$filePath}");

            return 1;
        }

        $this->info("Membaca berkas dump cPanel: {$filePath} (".round(filesize($filePath) / 1024 / 1024, 2).' MB)...');

        $driver = DB::getDriverName();
        $isSqlite = $driver === 'sqlite';

        // Disable foreign keys during mass import
        if ($isSqlite) {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        }

        $fp = fopen($filePath, 'r');
        if (! $fp) {
            $this->error('Gagal membuka berkas SQL.');

            return 1;
        }

        $statementsByTable = [];
        $buffer = '';

        while (($line = fgets($fp)) !== false) {
            $trimmed = trim($line);
            if (empty($trimmed) || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '/*')) {
                continue;
            }

            $buffer .= $line;
            if (str_ends_with(rtrim($trimmed), ';')) {
                if (preg_match('/^INSERT INTO `([^`]+)`/i', trim($buffer), $m)) {
                    $tbl = $m[1];
                    if (in_array($tbl, $this->tables)) {
                        $statementsByTable[$tbl][] = $buffer;
                    }
                }
                $buffer = '';
            }
        }
        fclose($fp);

        $this->info('Mengosongkan dan mengimpor tabel...');

        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            // Clear table before inserting dump data
            DB::table($table)->delete();

            if (! isset($statementsByTable[$table])) {
                continue;
            }

            foreach ($statementsByTable[$table] as $rawSql) {
                $execSql = $isSqlite ? $this->convertMysqlToSqlite($rawSql) : $rawSql;
                try {
                    DB::unprepared($execSql);
                } catch (\Throwable $e) {
                    $this->warn("Peringatan pada tabel `{$table}`: ".$e->getMessage());
                }
            }
        }

        // Re-enable foreign keys
        if ($isSqlite) {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        $this->info('Sinkronisasi berkas dump selesai. Memastikan dokumen Surat & Proposal Seminar AI tetap terdaftar...');

        // Run ProposalSeminarSeeder to guarantee the 2 new documents are recorded
        $this->call(ProposalSeminarSeeder::class);

        // Also append the 2 documents to berandad_db_pwiba.sql if not yet present
        $this->appendNewDocumentsToSqlFile($filePath);

        $this->newLine();
        $this->info('=== REKAPITULASI HASIL SINKRONISASI DATABASE ===');

        $rows = [];
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                $rows[] = [$table, $count];
            }
        }

        $this->table(['Nama Tabel', 'Total Baris Data Aktif'], $rows);
        $this->info('Database berhasil diperbarui sepenuhnya dari database cPanel terakhir!');

        return 0;
    }

    /**
     * Convert MySQL dump escape format into standard SQLite format.
     */
    protected function convertMysqlToSqlite(string $sql): string
    {
        // Replace MySQL escaped quotes and backslashes for SQLite
        $sql = str_replace(['\\\\', "\\'"], ['\\', "''"], $sql);
        $sql = str_replace('\\"', '"', $sql);

        return $sql;
    }

    /**
     * Append the new Letter and Proposal to berandad_db_pwiba.sql if not present.
     */
    protected function appendNewDocumentsToSqlFile(string $filePath): void
    {
        $content = file_get_contents($filePath);
        if (str_contains($content, '095/PWI-PROP/IX/2026')) {
            return;
        }

        $appendSql = "\n\n-- --------------------------------------------------------\n"
            ."-- Tambahan Data Terbaru: Surat Pengantar Sponsorship Pegadaian & Proposal Seminar AI\n"
            ."-- --------------------------------------------------------\n"
            ."INSERT INTO `letters` (`id`, `nomor_surat`, `tanggal`, `jenis_surat`, `status`, `member_id`, `tujuan`, `keperluan`, `perihal`, `tempat_tujuan`, `nama_pejabat`, `jabatan_pejabat`, `alamat_tujuan`, `lokasi`, `tanggal_mulai`, `tanggal_selesai`, `lampiran`, `isi_surat`, `file_dokumen`, `penandatangan_nama`, `penandatangan_sekretaris`, `created_at`, `updated_at`, `uuid`, `status_verifikasi`, `hash_keabsahan`) VALUES\n"
            ."(93, '095/PWI-PROP/IX/2026', '2026-09-10', 'PROPOSAL', 'published', NULL, 'Pimpinan Wilayah Kanwil Sumbagsel PT Pegadaian (Persero)', 'Permohonan Sponsorship Seminar Sehari Jurnalisme Cerdas di Era AI', 'Permohonan Dukungan Kerjasama / Sponsorship Seminar Sehari \\\"Jurnalisme Cerdas di Era AI\\\"', 'Palembang', 'Pimpinan Wilayah Kanwil Sumbagsel', 'Pimpinan Wilayah', 'Jl. Merdeka No. 11, Kota Palembang, Sumatera Selatan', NULL, NULL, NULL, '1 (Satu) Berkas Proposal', 'Seiring berkembangnya pemanfaatan kecerdasan buatan (Artificial Intelligence) dalam berbagai sektor, insan pers dituntut untuk terus beradaptasi dan meningkatkan kapasitas diri. Sehubungan dengan hal tersebut, Pengurus Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin bermaksud menyelenggarakan kegiatan Seminar Sehari dengan tema:\\r\\n\\r\\n\\\"Jurnalisme Cerdas di Era AI: Optimalisasi Teknologi Digital untuk Produktivitas Wartawan PWI Banyuasin\\\"\\r\\n\\r\\nKegiatan ini bertujuan untuk memberikan pemahaman teknis serta optimalisasi pemanfaatan teknologi digital dalam proses produksi jurnalistik yang profesional, etis, dan produktif bagi wartawan di Kabupaten Banyuasin.\\r\\n\\r\\nAdapun kegiatan ini rencananya akan dilaksanakan pada:\\r\\n• Hari / Tanggal : (Disesuaikan/tentatif)\\r\\n• Waktu : 08.00 WIB s.d. 14.00 Selesai\\r\\n• Tempat : Gedung Serbaguna Pangkalan Balai, Banyuasin\\r\\n• Peserta : 50 Orang (Wartawan & Anggota PWI Banyuasin)\\r\\n\\r\\nMengingat pentingnya acara ini, kami bermaksud mengajukan permohonan dukungan kerjasama / sponsorship kepada PT Pegadaian (Persero) Kanwil Sumbagsel guna terselenggaranya kegiatan tersebut. Sebagai bentuk kemitraan, kami siap menyediakan ruang publikasi, pencantuman logo perusahaan pada media promosi acara (spanduk, backdrop, sertifikat), serta sesi pengenalan produk/layanan PT Pegadaian kepada seluruh peserta.\\r\\n\\r\\nSebagai bahan pertimbangan Bapak/Ibu, bersama surat ini kami lampirkan 1 (satu) berkas proposal yang memuat rincian acara dan rencana anggaran biaya.\\r\\n\\r\\nDemikian surat pengajuan ini kami sampaikan. Atas perhatian, dukungan, dan kerjasama yang baik dari PT Pegadaian (Persero) Kanwil Sumbagsel, kami ucapkan terima kasih.', 'letters/095_PWI-PROP_IX_2026_Surat_Sponsorship_Pegadaian.docx', 'Wardoyo, S.I.Kom', 'Deni Arianto', '2026-09-10 11:48:29', '2026-09-10 11:48:29', 'e5192bc1-1f92-4d7a-8fbb-7c30e2f5b001', 'TERVERIFIKASI & SAH', 'b58941783457a419c8f000b0c6a5bb1d7bbf11c21da819586fe0478ef99d7a22'),\n"
            ."(94, '096/PWI-PROP/IX/2026', '2026-09-10', 'PROPOSAL', 'published', NULL, 'PT Pegadaian (Persero) & Mitra Sponsorship PWI Banyuasin', 'Proposal Kegiatan Seminar Sehari Jurnalisme Cerdas di Era AI', 'Proposal Seminar Sehari: Jurnalisme Cerdas di Era AI (RAB Rp 20.350.000)', 'Pangkalan Balai', 'Pimpinan Lembaga / Perusahaan Mitra', 'Pimpinan Mitra', 'Pangkalan Balai / Palembang', NULL, NULL, NULL, 'RAB & Susunan Panitia Lengkap', 'SEMINAR SEHARI\\r\\n\\\"Jurnalisme Cerdas di Era AI : Optimalisasi Teknologi Digital untuk Produktivitas Wartawan PWI Banyuasin\\\"\\r\\n\\r\\nA. Latar Belakang\\r\\nPesatnya perkembangan kecerdasan buatan (Artificial Intelligence) dan teknologi digital telah mengubah lanskap industri media secara fundamental. Wartawan dituntut untuk bekerja lebih cepat, akurat, dan adaptif tanpa mengesampingkan etika serta kaidah jurnalistik.\\r\\n\\r\\nMelalui seminar sehari ini, Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin berinisiatif membekali para anggotanya dengan pemahaman dan keterampilan praktis penggunaan perangkat AI untuk meriset data, pemrosesan berita, hingga verifikasi fakta untuk meningkatkan produktivitas dan kualitas karya jurnalistik di daerah.\\r\\n\\r\\nB. Tujuan Kegiatan\\r\\n• Memberikan pemahaman komprehensif mengenai pemanfaatan teknologi AI dalam ruang redaksi (newsroom).\\r\\n• Meningkatkan produktivitas kerja wartawan PWI Banyuasin melalui efisiensi riset dan pengolahan data digital.\\r\\n• Menjaga integritas dan etika jurnalistik di tengah maraknya konten buatan mesin dan disinformasi.\\r\\n\\r\\nC. Pelaksanaan Kegiatan\\r\\n• Bentuk Kegiatan: Seminar Sehari (Diskusi Panel, Pemaparan Materi, dan Tanya Jawab)\\r\\n• Tanggal / Waktu: [Tentatif] | 08.00 – 16.00 WIB\\r\\n• Tempat: Auditorium / Gedung Serbaguna Pemkab Banyuasin - Pangkalan Balai\\r\\n• Target Peserta: 50 Orang (Anggota PWI Banyuasin dan Perwakilan Media Lokal)\\r\\n\\r\\nD. Rencana Anggaran Biaya (RAB)\\r\\n1. Kesekretariatan & Perlengkapan:\\r\\n   • Spanduk / Backdrop (1 unit) = Rp 300.000\\r\\n   • Sertifikat Peserta & Panitia (60 lembar @ Rp 10.000) = Rp 600.000\\r\\n   • Seminar Kit (Blocknote, Pena, Map @ Rp 25.000 x 50) = Rp 1.250.000\\r\\n   • Subtotal: Rp 2.150.000\\r\\n\\r\\n2. Sewa Tempat & Fasilitas:\\r\\n   • Sewa Gedung & Sound System (1 hari) = Rp 3.000.000\\r\\n   • Subtotal: Rp 3.000.000\\r\\n\\r\\n3. Honorarium:\\r\\n   • Narasumber Ahli AI / Jurnalistik Digital (2 Orang @ Rp 2.500.000) = Rp 5.000.000\\r\\n   • Transport & Akomodasi Narasumber = Rp 1.500.000\\r\\n   • Honor Panitia Pelaksana (10 Orang @ Rp 300.000) = Rp 3.000.000\\r\\n   • Subtotal: Rp 9.500.000\\r\\n\\r\\n4. Konsumsi:\\r\\n   • Snack Pagi & Sore (60 Orang x 2 @ Rp 15.000) = Rp 1.800.000\\r\\n   • Makan Siang PR/Buffet (60 Orang @ Rp 40.000) = Rp 2.400.000\\r\\n   • Air Mineral & Coffee Break = Rp 500.000\\r\\n   • Subtotal: Rp 4.700.000\\r\\n\\r\\n5. Biaya Tak Terduga / Lain-lain:\\r\\n   • Alokasi Biaya Tak Terduga (5%) = Rp 1.000.000\\r\\n\\r\\nREKAPITULASI ANGGARAN:\\r\\n1. Sekretariat & Perlengkapan: Rp 2.150.000\\r\\n2. Sewa Gedung & Fasilitas: Rp 3.000.000\\r\\n3. Honorarium & Akomodasi: Rp 9.500.000\\r\\n4. Konsumsi: Rp 4.700.000\\r\\n5. Biaya Tak Terduga: Rp 1.000.000\\r\\nTOTAL ESTIMASI ANGGARAN: Rp 20.350.000\\r\\n\\r\\nE. Susunan Panitia Pelaksana\\r\\n• Penanggung Jawab : Wardoyo, S.I.Kom - Ketua PWI Banyuasin\\r\\n• Ketua Pelaksana: Quata Akda\\r\\n• Sekretaris: Deni Arianto\\r\\n• Bendahara: Ridho Andi Sucipto, M.Pd\\r\\n• Seksi Acara & Narasumber: Wardoyo - Septa Ryan Hidayat – Pakar AI\\r\\n• Seksi Perlengkapan & Tempat: Herwanto\\r\\n• Seksi Konsumsi & Humas: Frans Iskandar\\r\\n\\r\\nF. Penutup\\r\\nDemikian proposal kegiatan Seminar Sehari ini disusun sebagai acuan pelaksanaan kegiatan. Dukungan dan partisipasi dari berbagai pihak sangat kami harapkan demi suksesnya acara ini.', 'letters/096_PWI-PROP_IX_2026_Proposal_Seminar_AI_PWI_Banyuasin.docx', 'Wardoyo, S.I.Kom', 'Deni Arianto', '2026-09-10 11:48:29', '2026-09-10 11:48:29', 'f6283cd2-2a83-5e8b-9ecc-8d41f3e6c002', 'TERVERIFIKASI & SAH', 'd873429188204620f4bba756b1076f7c9e01869e06c359d955c48b2611a14c2b');\n";

        file_put_contents($filePath, $appendSql, FILE_APPEND);
        $this->info("Berkas {$filePath} telah diperbarui dengan data Surat & Proposal terbaru.");
    }
}
