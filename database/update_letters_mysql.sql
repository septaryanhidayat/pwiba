-- =====================================================================
-- SCRIPT UPDATE DATABASE MYSQL / CPANEL - TABEL LETTERS (SURAT KELUAR)
-- PWI KABUPATEN BANYUASIN
-- =====================================================================

-- 1. Ubah tipe kolom agar muat teks panjang (bebas error 1406 Data too long)
ALTER TABLE `letters` MODIFY COLUMN `tujuan` TEXT NOT NULL;
ALTER TABLE `letters` MODIFY COLUMN `keperluan` TEXT NULL;
ALTER TABLE `letters` MODIFY COLUMN `perihal` TEXT NULL;
ALTER TABLE `letters` MODIFY COLUMN `penandatangan_sekretaris` VARCHAR(255) NULL;

-- 2. Tambah kolom resmi cq (abaikan/lewati jika sudah pernah ditambahkan)
ALTER TABLE `letters` ADD COLUMN `cq` VARCHAR(255) NULL AFTER `tujuan`;

-- 3. Tambah kolom tembusan (abaikan/lewati jika sudah pernah ditambahkan)
ALTER TABLE `letters` ADD COLUMN `tembusan` TEXT NULL AFTER `penandatangan_sekretaris`;
