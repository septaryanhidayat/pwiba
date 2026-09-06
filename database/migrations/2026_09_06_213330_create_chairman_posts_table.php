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
        Schema::create('chairman_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_id')->nullable()->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Jurnalistik & Pers')->index();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->unsignedSmallInteger('reading_time')->default(3);
            $table->dateTime('published_at')->index();
            $table->string('original_url')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chairman_posts');
    }
};
