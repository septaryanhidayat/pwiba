-- =====================================================================
-- PETUNJUK UPDATE DATABASE MYSQL: SURAT KELUAR & PROPOSAL SEMINAR AI
-- Website Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin
-- =====================================================================
-- File SQL ini dapat diimpor langsung melalui phpMyAdmin atau MySQL CLI
-- jika server hosting/produksi Anda belum mencatat kedua berkas ini.
--
-- CARA MENJALANKAN DI PHPMYADMIN:
-- 1. Buka phpMyAdmin, pilih database (misal: 'pwiba' atau database hosting Anda).
-- 2. Klik tab 'SQL'.
-- 3. Salin seluruh query di bawah ini, tempelkan ke form SQL, lalu klik 'Kirim' (Go).
-- =====================================================================

-- 1. Pastikan kolom 'status' sudah ada pada tabel 'letters'
ALTER TABLE `letters` 
ADD COLUMN IF NOT EXISTS `status` VARCHAR(20) NOT NULL DEFAULT 'published' AFTER `jenis_surat`;

-- 2. INSERT DOKUMEN 1: Surat Keluar Pengantar Permohonan Sponsorship PT Pegadaian
INSERT INTO `letters` (
    `uuid`,
    `nomor_surat`,
    `tanggal`,
    `jenis_surat`,
    `status`,
    `tujuan`,
    `nama_pejabat`,
    `jabatan_pejabat`,
    `alamat_tujuan`,
    `tempat_tujuan`,
    `perihal`,
    `keperluan`,
    `lampiran`,
    `isi_surat`,
    `file_dokumen`,
    `penandatangan_nama`,
    `penandatangan_sekretaris`,
    `status_verifikasi`,
    `hash_keabsahan`,
    `created_at`,
    `updated_at`
) 
SELECT 
    'e5192bc1-1f92-4d7a-8fbb-7c30e2f5b001',
    '095/PWI-PROP/IX/2026',
    '2026-09-10',
    'PROPOSAL',
    'published',
    'Pimpinan Wilayah Kanwil Sumbagsel PT Pegadaian (Persero)',
    'Pimpinan Wilayah Kanwil Sumbagsel',
    'Pimpinan Wilayah',
    'Jl. Merdeka No. 11, Kota Palembang, Sumatera Selatan',
    'Palembang',
    'Permohonan Dukungan Kerjasama / Sponsorship Seminar Sehari \"Jurnalisme Cerdas di Era AI\"',
    'Permohonan Sponsorship Seminar Sehari Jurnalisme Cerdas di Era AI',
    '1 (Satu) Berkas Proposal',
    'Seiring berkembangnya pemanfaatan kecerdasan buatan (Artificial Intelligence) dalam berbagai sektor, insan pers dituntut untuk terus beradaptasi dan meningkatkan kapasitas diri. Sehubungan dengan hal tersebut, Pengurus Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin bermaksud menyelenggarakan kegiatan Seminar Sehari dengan tema:\n\n\"Jurnalisme Cerdas di Era AI: Optimalisasi Teknologi Digital untuk Produktivitas Wartawan PWI Banyuasin\"\n\nKegiatan ini bertujuan untuk memberikan pemahaman teknis serta optimalisasi pemanfaatan teknologi digital dalam proses produksi jurnalistik yang profesional, etis, dan produktif bagi wartawan di Kabupaten Banyuasin.\n\nAdapun kegiatan ini rencananya akan dilaksanakan pada:\n• Hari / Tanggal : (Disesuaikan/tentatif)\n• Waktu : 08.00 WIB s.d. 14.00 Selesai\n• Tempat : Gedung Serbaguna Pangkalan Balai, Banyuasin\n• Peserta : 50 Orang (Wartawan & Anggota PWI Banyuasin)\n\nMengingat pentingnya acara ini, kami bermaksud mengajukan permohonan dukungan kerjasama / sponsorship kepada PT Pegadaian (Persero) Kanwil Sumbagsel guna terselenggaranya kegiatan tersebut. Sebagai bentuk kemitraan, kami siap menyediakan ruang publikasi, pencantuman logo perusahaan pada media promosi acara (spanduk, backdrop, sertifikat), serta sesi pengenalan produk/layanan PT Pegadaian kepada seluruh peserta.\n\nSebagai bahan pertimbangan Bapak/Ibu, bersama surat ini kami lampirkan 1 (satu) berkas proposal yang memuat rincian acara dan rencana anggaran biaya.\n\nDemikian surat pengajuan ini kami sampaikan. Atas perhatian, dukungan, dan kerjasama yang baik dari PT Pegadaian (Persero) Kanwil Sumbagsel, kami ucapkan terima kasih.',
    'letters/095_PWI-PROP_IX_2026_Surat_Sponsorship_Pegadaian.docx',
    'Wardoyo, S.I.Kom',
    'Deni Arianto',
    'valid',
    SHA2('095/PWI-PROP/IX/2026|2026-09-10|PWI-BANYUASIN-PEGADAIAN', 256),
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM `letters` WHERE `nomor_surat` = '095/PWI-PROP/IX/2026'
);

-- 3. INSERT DOKUMEN 2: Proposal Lengkap Seminar Sehari AI (RAB Rp 20.350.000 & Susunan Panitia)
INSERT INTO `letters` (
    `uuid`,
    `nomor_surat`,
    `tanggal`,
    `jenis_surat`,
    `status`,
    `tujuan`,
    `nama_pejabat`,
    `jabatan_pejabat`,
    `alamat_tujuan`,
    `tempat_tujuan`,
    `perihal`,
    `keperluan`,
    `lampiran`,
    `isi_surat`,
    `file_dokumen`,
    `penandatangan_nama`,
    `penandatangan_sekretaris`,
    `status_verifikasi`,
    `hash_keabsahan`,
    `created_at`,
    `updated_at`
) 
SELECT 
    'f6283cd2-2a83-5e8b-9ecc-8d41f3e6c002',
    '096/PWI-PROP/IX/2026',
    '2026-09-10',
    'PROPOSAL',
    'published',
    'PT Pegadaian (Persero) & Mitra Sponsorship PWI Banyuasin',
    'Pimpinan Lembaga / Perusahaan Mitra',
    'Pimpinan Mitra',
    'Pangkalan Balai / Palembang',
    'Pangkalan Balai',
    'Proposal Seminar Sehari: Jurnalisme Cerdas di Era AI (RAB Rp 20.350.000)',
    'Proposal Kegiatan Seminar Sehari Jurnalisme Cerdas di Era AI',
    'RAB & Susunan Panitia Lengkap',
    'SEMINAR SEHARI\n\"Jurnalisme Cerdas di Era AI : Optimalisasi Teknologi Digital untuk Produktivitas Wartawan PWI Banyuasin\"\n\nA. Latar Belakang\nPesatnya perkembangan kecerdasan buatan (Artificial Intelligence) dan teknologi digital telah mengubah lanskap industri media secara fundamental. Wartawan dituntut untuk bekerja lebih cepat, akurat, dan adaptif tanpa mengesampingkan etika serta kaidah jurnalistik.\n\nMelalui seminar sehari ini, Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin berinisiatif membekali para anggotanya dengan pemahaman dan keterampilan praktis penggunaan perangkat AI untuk meriset data, pemrosesan berita, hingga verifikasi fakta untuk meningkatkan produktivitas dan kualitas karya jurnalistik di daerah.\n\nB. Tujuan Kegiatan\n• Memberikan pemahaman komprehensif mengenai pemanfaatan teknologi AI dalam ruang redaksi (newsroom).\n• Meningkatkan produktivitas kerja wartawan PWI Banyuasin melalui efisiensi riset dan pengolahan data digital.\n• Menjaga integritas dan etika jurnalistik di tengah maraknya konten buatan mesin dan disinformasi.\n\nC. Pelaksanaan Kegiatan\n• Bentuk Kegiatan: Seminar Sehari (Diskusi Panel, Pemaparan Materi, dan Tanya Jawab)\n• Tanggal / Waktu: [Tentatif] | 08.00 – 16.00 WIB\n• Tempat: Auditorium / Gedung Serbaguna Pemkab Banyuasin - Pangkalan Balai\n• Target Peserta: 50 Orang (Anggota PWI Banyuasin dan Perwakilan Media Lokal)\n\nD. Rencana Anggaran Biaya (RAB)\n1. Kesekretariatan & Perlengkapan:\n   • Spanduk / Backdrop (1 unit) = Rp 300.000\n   • Sertifikat Peserta & Panitia (60 lembar @ Rp 10.000) = Rp 600.000\n   • Seminar Kit (Blocknote, Pena, Map @ Rp 25.000 x 50) = Rp 1.250.000\n   • Subtotal: Rp 2.150.000\n\n2. Sewa Tempat & Fasilitas:\n   • Sewa Gedung & Sound System (1 hari) = Rp 3.000.000\n   • Subtotal: Rp 3.000.000\n\n3. Honorarium:\n   • Narasumber Ahli AI / Jurnalistik Digital (2 Orang @ Rp 2.500.000) = Rp 5.000.000\n   • Transport & Akomodasi Narasumber = Rp 1.500.000\n   • Honor Panitia Pelaksana (10 Orang @ Rp 300.000) = Rp 3.000.000\n   • Subtotal: Rp 9.500.000\n\n4. Konsumsi:\n   • Snack Pagi & Sore (60 Orang x 2 @ Rp 15.000) = Rp 1.800.000\n   • Makan Siang PR/Buffet (60 Orang @ Rp 40.000) = Rp 2.400.000\n   • Air Mineral & Coffee Break = Rp 500.000\n   • Subtotal: Rp 4.700.000\n\n5. Biaya Tak Terduga / Lain-lain:\n   • Alokasi Biaya Tak Terduga (5%) = Rp 1.000.000\n\nREKAPITULASI ANGGARAN:\n1. Sekretariat & Perlengkapan: Rp 2.150.000\n2. Sewa Gedung & Fasilitas: Rp 3.000.000\n3. Honorarium & Akomodasi: Rp 9.500.000\n4. Konsumsi: Rp 4.700.000\n5. Biaya Tak Terduga: Rp 1.000.000\nTOTAL ESTIMASI ANGGARAN: Rp 20.350.000\n\nE. Susunan Panitia Pelaksana\n• Penanggung Jawab : Wardoyo, S.I.Kom - Ketua PWI Banyuasin\n• Ketua Pelaksana: Quata Akda\n• Sekretaris: Deni Arianto\n• Bendahara: Ridho Andi Sucipto, M.Pd\n• Seksi Acara & Narasumber: Wardoyo - Septa Ryan Hidayat – Pakar AI\n• Seksi Perlengkapan & Tempat: Herwanto\n• Seksi Konsumsi & Humas: Frans Iskandar\n\nF. Penutup\nDemikian proposal kegiatan Seminar Sehari ini disusun sebagai acuan pelaksanaan kegiatan. Dukungan dan partisipasi dari berbagai pihak sangat kami harapkan demi suksesnya acara ini.',
    'letters/096_PWI-PROP_IX_2026_Proposal_Seminar_AI_PWI_Banyuasin.docx',
    'Wardoyo, S.I.Kom',
    'Deni Arianto',
    'valid',
    SHA2('096/PWI-PROP/IX/2026|2026-09-10|PWI-BANYUASIN-PROPOSAL-AI', 256),
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM `letters` WHERE `nomor_surat` = '096/PWI-PROP/IX/2026'
);

-- =====================================================================
-- SELESAI. Kedua dokumen surat dan proposal telah berhasil dicatat.
-- =====================================================================
