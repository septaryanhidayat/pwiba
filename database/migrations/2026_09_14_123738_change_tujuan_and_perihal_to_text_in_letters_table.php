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
            $table->text('tujuan')->change();
            $table->text('keperluan')->nullable()->change();
            $table->text('perihal')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->string('tujuan', 255)->change();
            $table->string('keperluan', 255)->nullable()->change();
            $table->string('perihal', 255)->nullable()->change();
        });
    }
};
