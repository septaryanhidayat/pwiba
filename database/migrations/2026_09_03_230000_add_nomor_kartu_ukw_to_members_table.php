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
        if (Schema::hasTable('members') && ! Schema::hasColumn('members', 'nomor_kartu_ukw')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('nomor_kartu_ukw')->nullable()->after('tingkat_ukw');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('members') && Schema::hasColumn('members', 'nomor_kartu_ukw')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('nomor_kartu_ukw');
            });
        }
    }
};
