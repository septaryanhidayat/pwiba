<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('session_id', 100)->nullable();
            $table->timestamps();

            $table->index(['post_id', 'created_at']);
            $table->index(['post_id', 'ip_address']);
        });

        // Reset nilai fake counter lama agar total views dimulai dari angka riil autentik
        if (Schema::hasTable('posts')) {
            DB::table('posts')
                ->whereIn('views_count', [669, 238, 750, 743, 789, 922])
                ->update(['views_count' => 0]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};
