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
        Schema::table('organization_structures', function (Blueprint $table) {
            $table->string('x_twitter')->nullable()->after('foto');
            $table->string('facebook')->nullable()->after('x_twitter');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('youtube')->nullable()->after('instagram');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_structures', function (Blueprint $table) {
            $table->dropColumn(['x_twitter', 'facebook', 'instagram', 'youtube']);
        });
    }
};
