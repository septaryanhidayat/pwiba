<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VideoGallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoGalleryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function getAdminUser(): User
    {
        return User::first() ?? User::factory()->create([
            'email' => 'admin@pwibanyuasin.or.id',
            'role' => 'admin',
        ]);
    }

    public function test_public_home_renders_youtube_videos_and_titles(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Galeri Kegiatan & Video Liputan PWI', false);
        $response->assertSee('ayWoKoy-rDM', false);
        $response->assertSee('lQDMxy9gtkQ', false);
        $response->assertSee('TVRI - Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin Mengadakan Perlombaan Mini Soccer', false);
        $response->assertSee('PalTV - ARAEY FC Juarai Open Turnamen Mini Soccer PWI Banyuasin', false);
    }

    public function test_public_gallery_page_renders_video_section_and_photos(): void
    {
        $response = $this->get('/galeri');

        $response->assertStatus(200);
        $response->assertSee('Galeri Foto & Dokumentasi Kegiatan PWI', false);
        $response->assertSee('Galeri Video & Liputan Media', false);
        $response->assertSee('ayWoKoy-rDM', false);
        $response->assertSee('lQDMxy9gtkQ', false);
        $response->assertSee('TVRI - Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin Mengadakan Perlombaan Mini Soccer', false);
    }

    public function test_unauthenticated_user_cannot_access_admin_video_gallery(): void
    {
        $response = $this->get('/admin/galeri-video');
        $response->assertRedirect('/login');

        $postResponse = $this->post('/admin/galeri-video', [
            'youtube_url' => 'https://www.youtube.com/watch?v=ayWoKoy-rDM',
        ]);
        $postResponse->assertRedirect('/login');
    }

    public function test_admin_can_view_video_gallery_index(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/galeri-video');
        $response->assertStatus(200);
        $response->assertSee('Galeri Video Kegiatan & Liputan Media', false);
        $response->assertSee('TVRI - Persatuan Wartawan Indonesia', false);
        $response->assertSee('PalTV - ARAEY FC Juarai', false);
    }

    public function test_admin_can_add_new_video_to_gallery(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->post('/admin/galeri-video', [
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'judul' => 'Video Uji Coba Dokumentasi PWI Banyuasin',
            'deskripsi' => 'Deskripsi video uji coba untuk dokumentasi',
            'tanggal' => '2026-09-07',
            'urutan' => 99,
            'is_active' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('video_galleries', [
            'youtube_id' => 'dQw4w9WgXcQ',
            'judul' => 'Video Uji Coba Dokumentasi PWI Banyuasin',
        ]);

        // Clean up
        VideoGallery::where('youtube_id', 'dQw4w9WgXcQ')->delete();
    }

    public function test_admin_can_update_video_in_gallery(): void
    {
        $admin = $this->getAdminUser();

        $video = VideoGallery::create([
            'judul' => 'Judul Sebelum Diedit',
            'youtube_url' => 'https://www.youtube.com/watch?v=ayWoKoy-rDM',
            'youtube_id' => 'ayWoKoy-rDM',
            'deskripsi' => 'Deskripsi lama',
            'tanggal' => '2026-09-01',
            'urutan' => 10,
            'is_active' => true,
        ]);

        $updateResponse = $this->actingAs($admin)->put('/admin/galeri-video/'.$video->id, [
            'judul' => 'Judul Setelah Diperbarui Berhasil',
            'youtube_url' => 'https://www.youtube.com/watch?v=ayWoKoy-rDM',
            'deskripsi' => 'Deskripsi baru',
            'tanggal' => '2026-09-05',
            'urutan' => 5,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect();
        $updateResponse->assertSessionHas('success');

        $this->assertDatabaseHas('video_galleries', [
            'id' => $video->id,
            'judul' => 'Judul Setelah Diperbarui Berhasil',
            'urutan' => 5,
        ]);

        $video->delete();
    }

    public function test_admin_can_delete_video_from_gallery(): void
    {
        $admin = $this->getAdminUser();

        $video = VideoGallery::create([
            'judul' => 'Video Untuk Dihapus',
            'youtube_url' => 'https://www.youtube.com/watch?v=ayWoKoy-rDM',
            'youtube_id' => 'ayWoKoy-rDM',
            'is_active' => true,
        ]);

        $deleteResponse = $this->actingAs($admin)->delete('/admin/galeri-video/'.$video->id);
        $deleteResponse->assertRedirect();
        $deleteResponse->assertSessionHas('success');

        $this->assertDatabaseMissing('video_galleries', [
            'id' => $video->id,
        ]);
    }

    public function test_youtube_id_extractor_and_fetch_info_endpoint(): void
    {
        $admin = $this->getAdminUser();

        // 1. URL extraction test
        $this->assertEquals('ayWoKoy-rDM', VideoGallery::extractYoutubeId('https://www.youtube.com/watch?v=ayWoKoy-rDM'));
        $this->assertEquals('lQDMxy9gtkQ', VideoGallery::extractYoutubeId('https://youtu.be/lQDMxy9gtkQ'));
        $this->assertEquals('ayWoKoy-rDM', VideoGallery::extractYoutubeId('https://www.youtube.com/embed/ayWoKoy-rDM'));

        // 2. Fetch Info AJAX test
        $response = $this->actingAs($admin)->get('/admin/galeri-video/fetch-info?url='.urlencode('https://www.youtube.com/watch?v=ayWoKoy-rDM'));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'youtube_id' => 'ayWoKoy-rDM',
        ]);
    }
}
