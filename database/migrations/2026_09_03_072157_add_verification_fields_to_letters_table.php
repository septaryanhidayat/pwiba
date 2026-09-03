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
        Schema::table('letters', function (Blueprint $table) {
            $table->string('uuid', 64)->nullable()->unique()->after('id');
            $table->string('status_verifikasi', 50)->default('TERVERIFIKASI & SAH')->after('penandatangan_sekretaris');
            $table->string('hash_keabsahan', 64)->nullable()->after('status_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'status_verifikasi', 'hash_keabsahan']);
        });
    }
};
