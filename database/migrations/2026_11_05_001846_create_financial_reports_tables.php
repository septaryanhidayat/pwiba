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
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan');
            $table->string('lanjutan_nama_kegiatan')->nullable();
            $table->string('hari_tanggal')->nullable();
            $table->string('tempat')->nullable();
            $table->string('tempat_tanggal_ttd')->nullable();
            $table->string('nama_mengetahui')->default('Wardoyo, S.I.Kom');
            $table->string('jabatan_mengetahui')->default('Ketua PWI Banyuasin');
            $table->string('nama_bendahara')->default('Ridho Andi Sucipto, M.Pd');
            $table->string('jabatan_bendahara')->default('Bendahara PWI Banyuasin');
            $table->decimal('total_penerimaan', 15, 2)->default(0);
            $table->decimal('total_pengeluaran', 15, 2)->default(0);
            $table->decimal('saldo', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('financial_report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_report_id')->constrained('financial_reports')->cascadeOnDelete();
            $table->enum('jenis', ['penerimaan', 'pengeluaran']);
            $table->string('tanggal', 100)->nullable();
            $table->string('uraian');
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_report_items');
        Schema::dropIfExists('financial_reports');
    }
};
