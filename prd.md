# Product Requirement Document (PRD)
## Sistem Informasi & Website Resmi PWI Kabupaten Banyuasin

### 1. Ringkasan Eksekutif
Sistem Informasi dan Website Resmi Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin adalah platform web terpadu yang menggabungkan:
1. **Website Publik (Portal Informasi Resmi)**: Media informasi publik, profil organisasi, visi & misi, struktur kepengurusan, portal berita jurnalistik, galeri kegiatan, serta formulir kontak/inbox publik.
2. **Sistem Informasi Manajemen & Administrasi (Admin Panel)**: Sistem manajemen internal organisasi untuk pengelolaan data wartawan (berdasarkan tingkatan Uji Kompetensi Wartawan / UKW), direktori media pers mitra, struktur kepengurusan, persuratan & administrasi (Surat Tugas, Audiensi, Surat Biasa, Proposal), publikasi berita, galeri, serta pengaturan identitas PWI Banyuasin.

---

### 2. Sasaran Pengguna
- **Masyarakat & Stakeholder**: Mengakses berita resmi, informasi kepengurusan, profil wartawan terdaftar di Banyuasin, dan mengirimkan pesan/undangan melalui portal kontak.
- **Pengurus & Admin PWI Banyuasin**: Mengelola data wartawan, menerbitkan surat resmi berformat standar dengan kop surat PWI, mempublikasikan berita dan dokumentasi kegiatan, serta mengelola direktori media mitra.

---

### 3. Modul & Fitur Sistem

#### A. Website Publik (Frontend)
1. **Header & Navigasi**: Logo resmi PWI Kab. Banyuasin, menu navigasi (Home, Visi & Misi, Tentang, Galeri, Tim Pengurus, Berita, Kontak), dan tombol Login Admin.
2. **Hero Banner**: Foto gedung/perkantoran Banyuasin dengan identitas PWI Kab. Banyuasin, Sumatera Selatan.
3. **Visi & Misi**:
   - Visi: *"Memperkuat peran PWI Banyuasin dalam peningkatan profesionalisme wartawan melalui pelatihan, Uji Kompetensi dan kolaborasi dengan berbagai pihak."*
   - 4 Poin Misi resmi organisasi.
4. **Sambutan Ketua PWI**: Foto Ketua (Wardoyo, S.I.Kom), teks sambutan resmi, dan opsi unduh PDF sambutan.
5. **Galeri Kegiatan**: Slider interaktif foto-foto agenda kegiatan (Turnamen, Rapat, Sinergi instansi) lengkap dengan tanggal dan keterangan.
6. **Struktur Pengurus**: Kartu profil jajaran pengurus lengkap dengan foto, nama, nomor anggota, dan jabatan.
7. **Portal Berita**: Tampilan berita terbaru dengan thumbnail, tanggal terbit, penulis, dan halaman detail berita penuh.
8. **Form Kontak & Inbox Publik**: Form pengiriman pesan/tamu (Nama, Tanggal, Tujuan, Keperluan) yang otomatis tersinkronisasi ke Dashboard Admin.
9. **Footer**: Informasi alamat kantor, kota, telepon/fax, dan copyright resmi.

#### B. Sistem Informasi Admin (Backend Dashboard)
1. **Autentikasi & Keamanan**:
   - Login administrator dengan proteksi sesi.
   - Manajemen Ganti Sandi Admin.
2. **Dashboard Statistik**:
   - Counter wartawan berdasarkan jenjang UKW: **Belum UKW**, **Wartawan Muda**, **Wartawan Madya**, **Wartawan Utama**.
   - Tombol Cetak rekapitulasi data anggota per kategori.
   - Tabel ringkasan data anggota lengkap dengan pencarian & filter.
3. **Manajemen Anggota & Media**:
   - **Daftar Anggota Aktif**: CRUD data wartawan (Foto, Nama, Nomor Kartu KTA, Tingkat UKW, Masa Berlaku KTA, Jabatan, Aksi Detail/Edit/Hapus).
   - **Daftar Anggota Tidak Aktif / Belum Aktif**: Pemisahan data anggota yang non-aktif / kadaluarsa dengan opsi re-aktivasi.
   - **Daftar Media**: Direktori media massa (Nama Media, URL Website, Alamat Kantor, Aksi Edit/Hapus).
4. **Manajemen Struktur Organisasi**:
   - Penempatan jabatan fungsional & struktural pengurus PWI Banyuasin.
5. **Administrasi & Persuratan**:
   - **Inbox (Buku Tamu / Pesan Masuk)**: Monitoring pesan dari publik.
   - **Surat Keluar**: Pencatatan & pembuatan surat keluar dengan auto-numbering format resmi (contoh: `093/PWI-BA/VIII/2026`).
   - **Generator Surat & Cetak Kop Resmi**:
     - Buat Surat Tugas
     - Buat Surat Audiensi
     - Buat Surat Biasa
     - Buat Surat Proposal
     - Template cetak siap pakai (Kop Surat resmi PWI Banyuasin, isi otomatis, tanda tangan).
   - **Surat Masuk**: Pencatatan arsip surat masuk dan lampiran.
6. **Manajemen Berita (CMS)**:
   - **Draf Berita**: Pembuatan dan penyuntingan artikel (WYSIWYG editor, gambar banner, kategori).
   - **Publish Berita**: Manajemen artikel tayang dengan fitur Tinjau, Edit, dan Hapus.
7. **Manajemen Galeri**:
   - Upload dokumentasi foto kegiatan, judul kegiatan, deskripsi, dan tanggal.
8. **Pengaturan Identitas Organisasi**:
   - Data Kantor PWI (Nama Organisasi, Alamat Lengkap, Kota, No. Telp / Fax, Logo).

---

### 4. Arsitektur Teknologi
- **Backend Framework**: Laravel 11 / 12 (PHP 8.4)
- **Database**: SQLite / MySQL (Database migration & seeder dengan data awal sesuai acuan referensi)
- **Frontend & Admin UI**: Blade Templates + Modern Responsive CSS (TailwindCSS / AdminLTE style yang modern, elegan, clean, dan profesional) + Alpine.js / DataTables untuk interaktivitas data.
- **Media Storage**: Laravel Storage untuk foto anggota, galeri, thumbnail berita, dan dokumen.
- **Fitur Cetak**: Template Cetak Web & PDF terintegrasi untuk surat dan laporan keanggotaan.