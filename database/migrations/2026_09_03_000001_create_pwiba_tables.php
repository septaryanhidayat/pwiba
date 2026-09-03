<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Media Partner Table
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('nama_media');
            $table->string('website')->nullable();
            $table->string('alamat')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        // 2. Members Table (Wartawan)
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_kartu')->nullable(); // KTA PWI
            $table->enum('tingkat_ukw', ['Belum UKW', 'Wartawan Muda', 'Wartawan Madya', 'Wartawan Utama'])->default('Belum UKW');
            $table->date('masa_berlaku')->nullable();
            $table->string('jabatan')->default('ANGGOTA');
            $table->foreignId('media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('nama_media_custom')->nullable();
            $table->string('foto')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // 3. Organization Structure Table (Pengurus)
        Schema::create('organization_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('nama');
            $table->string('nomor_kartu')->nullable();
            $table->string('tingkat_ukw')->nullable();
            $table->date('masa_berlaku')->nullable();
            $table->string('jabatan');
            $table->integer('urutan')->default(0);
            $table->string('periode')->default('2024-2027');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // 4. Posts / News Table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->default('Kegiatan');
            $table->string('penulis')->default('Wardoyo, S.I.Kom');
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            $table->string('gambar')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('views_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // 5. Galleries Table
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('foto');
            $table->date('tanggal_kegiatan')->nullable();
            $table->timestamps();
        });

        // 6. Outgoing Letters Table (Surat Keluar)
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal');
            $table->string('jenis_surat'); // SURAT BIASA, PROPOSAL, SURAT AUDENSI, SURAT TUGAS
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete(); // Anggota yang ditugaskan
            $table->string('tujuan');
            $table->string('keperluan');
            $table->string('perihal')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->string('nama_pejabat')->nullable();
            $table->string('jabatan_pejabat')->nullable();
            $table->string('alamat_tujuan')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('lampiran')->nullable();
            $table->text('isi_surat')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->string('penandatangan_nama')->default('Wardoyo, S.I.Kom');
            $table->string('penandatangan_sekretaris')->default('Deni Arianto');
            $table->timestamps();
        });

        // 7. Incoming Letters Table (Surat Masuk)
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('pengirim');
            $table->string('perihal');
            $table->text('isi_ringkas')->nullable();
            $table->string('file_lampiran')->nullable();
            $table->string('status_disposisi')->default('Diterima');
            $table->timestamps();
        });

        // 8. Meeting Minutes Table (Notulen Rapat - FITUR BARU PRD v2.0)
        Schema::create('meeting_minutes', function (Blueprint $table) {
            $table->id();
            $table->string('judul_rapat');
            $table->date('tanggal');
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('tempat');
            $table->string('pemimpin_rapat')->default('Wardoyo, S.I.Kom');
            $table->string('notulis')->default('Deni Arianto');
            $table->text('agenda');
            $table->longText('pembahasan');
            $table->longText('kesimpulan');
            $table->string('file_lampiran')->nullable();
            $table->timestamps();
        });

        // 9. Meeting Attendance Pivot Table (Daftar Hadir Rapat)
        Schema::create('meeting_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_minute_id')->constrained('meeting_minutes')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->enum('status_kehadiran', ['hadir', 'izin', 'alpa'])->default('hadir');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // 10. Inboxes / Guest Book Table (Buku Tamu Publik)
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->string('nama');
            $table->string('instansi')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable(); // nomor_kontak
            $table->string('tujuan')->default('PWI Banyuasin');
            $table->string('keperluan');
            $table->text('pesan')->nullable();
            $table->enum('status', ['baru', 'dibaca', 'dibalas'])->default('baru');
            $table->timestamps();
        });

        // 11. Office & Portal Settings Table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('inboxes');
        Schema::dropIfExists('meeting_attendances');
        Schema::dropIfExists('meeting_minutes');
        Schema::dropIfExists('incoming_letters');
        Schema::dropIfExists('letters');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('organization_structures');
        Schema::dropIfExists('members');
        Schema::dropIfExists('media');
    }
};
