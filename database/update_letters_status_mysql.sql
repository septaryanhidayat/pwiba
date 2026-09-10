-- =====================================================================
-- SCRIPT UPDATE DATABASE MYSQL - SURAT KELUAR PWI KABUPATEN BANYUASIN
-- Fitur: Status Surat (Draft & Published), Pemisahan Nama Penerima, 
--        dan Pengeditan Tempat Tujuan ("di Tempat")
-- =====================================================================
-- Jalankan query SQL ini di phpMyAdmin atau MySQL Server hosting Anda
-- jika sistem hosting tidak menjalankan 'php artisan migrate' otomatis.

-- 1. Tambahkan kolom status pada tabel letters (default: published)
ALTER TABLE `letters` 
ADD COLUMN IF NOT EXISTS `status` VARCHAR(20) NOT NULL DEFAULT 'published' AFTER `jenis_surat`;

-- 2. Pastikan semua data surat lama memiliki status 'published'
UPDATE `letters` 
SET `status` = 'published' 
WHERE `status` IS NULL OR `status` = '';

-- =====================================================================
-- Selesai. Database MySQL telah siap digunakan.
-- =====================================================================
