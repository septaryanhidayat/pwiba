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
        Schema::create('video_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('youtube_url');
            $table->string('youtube_id');
            $table->string('thumbnail_url')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert initial 2 YouTube videos directly with titles fetched from YouTube oEmbed
        DB::table('video_galleries')->insert([
            [
                'judul' => 'TVRI - Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin Mengadakan Perlombaan Mini Soccer',
                'youtube_url' => 'https://www.youtube.com/watch?v=ayWoKoy-rDM',
                'youtube_id' => 'ayWoKoy-rDM',
                'thumbnail_url' => 'https://i.ytimg.com/vi/ayWoKoy-rDM/hqdefault.jpg',
                'deskripsi' => 'Liputan TVRI Sumatera Selatan: Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin Mengadakan Perlombaan Mini Soccer.',
                'tanggal' => '2026-09-03',
                'urutan' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'PalTV - ARAEY FC Juarai Open Turnamen Mini Soccer PWI Banyuasin',
                'youtube_url' => 'https://www.youtube.com/watch?v=lQDMxy9gtkQ',
                'youtube_id' => 'lQDMxy9gtkQ',
                'thumbnail_url' => 'https://i.ytimg.com/vi/lQDMxy9gtkQ/hqdefault.jpg',
                'deskripsi' => 'Liputan PalTV: ARAEY FC berhasil menjuarai Open Turnamen Mini Soccer yang diselenggarakan oleh PWI Kabupaten Banyuasin.',
                'tanggal' => '2026-09-03',
                'urutan' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_galleries');
    }
};
