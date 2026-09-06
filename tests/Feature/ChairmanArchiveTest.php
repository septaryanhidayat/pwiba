<?php

namespace Tests\Feature;

use App\Models\ChairmanPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChairmanArchiveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (ChairmanPost::count() === 0) {
            ChairmanPost::create([
                'title' => 'Catatan Teori Komunikasi Wartawan',
                'slug' => 'catatan-teori-komunikasi-wartawan-test',
                'category' => 'Teori Komunikasi',
                'excerpt' => 'Menjadi wartawan bukan hanya soal bisa menulis cepat tetapi memahami teori komunikasi.',
                'content' => '<p>Teori Agenda Setting oleh Maxwell McCombs sangat penting bagi jurnalis.</p>',
                'reading_time' => 3,
                'published_at' => now(),
                'original_url' => 'https://wardianst.wordpress.com/test',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Public Executive Personal Branding & Archive Tests (/wardoyo)
    |--------------------------------------------------------------------------
    */

    public function test_wardoyo_archive_index_page_is_accessible(): void
    {
        $response = $this->get('/wardoyo');

        $response->assertStatus(200);
        $response->assertSee('Wardoyo, S.I.Kom.');
        $response->assertSee('Katalog Tulisan');
        $response->assertDontSee('Magister Komunikasi Politik');
        $response->assertDontSee('Alumni SJI');
    }

    public function test_wardoyo_archive_search_and_filter_works(): void
    {
        $response = $this->get('/wardoyo?q=Komunikasi');
        $response->assertStatus(200);

        $responseCategory = $this->get('/wardoyo?kategori=Teori+Komunikasi');
        $responseCategory->assertStatus(200);
    }

    public function test_wardoyo_archive_detail_page_is_accessible(): void
    {
        $post = ChairmanPost::first();
        $this->assertNotNull($post);

        $response = $this->get('/wardoyo/'.$post->slug);

        $response->assertStatus(200);
        $response->assertSee(e($post->title), false);
        $response->assertDontSee('Lihat Postingan Asli');
        $response->assertDontSee('wardianst.wordpress.com');
        $response->assertDontSee('Magister Komunikasi Politik');
        $response->assertDontSee('Alumni SJI');
        $response->assertSee('pengurus_inti_1_wardoyo.webp');
    }

    public function test_wardoyo_archive_detail_returns_404_for_invalid_slug(): void
    {
        $response = $this->get('/wardoyo/slug-yang-sama-sekali-tidak-ada-999');

        $response->assertStatus(404);
    }

    public function test_wardoyo_archive_link_is_accessible_from_navbar_and_homepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('chairman.archive.index'), false);
        $response->assertSee('Profil Ketua PWI');

        // On homepage, the social media preview is the official PWI logo, NOT Wardoyo's personal photo
        $response->assertSee('pwi-logo');
        $response->assertDontSee('wardoyo-share.jpg');
    }

    public function test_wardoyo_page_has_custom_social_preview_photo_and_icons(): void
    {
        $response = $this->get('/wardoyo');

        $response->assertStatus(200);
        // Social Media Preview (OpenGraph & Twitter Image) must be Wardoyo's photo, not PWI logo
        $response->assertSee('wardoyo-share.jpg');
        $response->assertSee('property="og:image"', false);
        $response->assertSee('name="twitter:image"', false);

        // Social Media & Email icon links
        $response->assertSee('https://www.instagram.com/wardianstp/');
        $response->assertSee('https://www.facebook.com/ward.wardoyo');
        $response->assertSee('wardianstp@gmail.com');

        // Card under photo shows "Ketua PWI Banyuasin"
        $response->assertSee('Ketua PWI Banyuasin');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Back-Office CRUD Tests (/admin/arsip-ketua)
    |--------------------------------------------------------------------------
    */

    public function test_guest_cannot_access_admin_chairman_posts(): void
    {
        $response = $this->get(route('admin.chairman_posts.index'));
        $response->assertRedirect('/login');

        $createResponse = $this->get(route('admin.chairman_posts.create'));
        $createResponse->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_view_chairman_posts_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.chairman_posts.index'));

        $response->assertStatus(200);
        $response->assertSee('Kelola Karya Tulis');
        $response->assertSee('Catatan Teori Komunikasi Wartawan');
        $response->assertSee(route('admin.chairman_posts.create'));
    }

    public function test_authenticated_admin_can_view_create_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.chairman_posts.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Karya Tulis');
        $response->assertSee('name="title"', false);
        $response->assertSee('name="content"', false);
    }

    public function test_authenticated_admin_can_store_new_chairman_post(): void
    {
        $user = User::factory()->create();

        $payload = [
            'title' => 'Esai Analisis Framing Media Lokal',
            'category' => 'Analisis Media',
            'excerpt' => 'Framing media sangat menentukan persepsi publik terhadap kebijakan pemerintah.',
            'content' => '<p>Analisis framing model Robert Entman menjelaskan empat dimensi pembingkaian realitas.</p>',
            'reading_time' => 4,
            'published_at' => now()->format('Y-m-d H:i:s'),
            'original_url' => 'https://wardianst.wordpress.com/framing-media',
        ];

        $response = $this->actingAs($user)->post(route('admin.chairman_posts.store'), $payload);

        $response->assertRedirect(route('admin.chairman_posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('chairman_posts', [
            'title' => 'Esai Analisis Framing Media Lokal',
            'category' => 'Analisis Media',
        ]);
    }

    public function test_authenticated_admin_can_view_edit_form(): void
    {
        $user = User::factory()->create();
        $post = ChairmanPost::first();
        $this->assertNotNull($post);

        $response = $this->actingAs($user)->get(route('admin.chairman_posts.edit', $post->id));

        $response->assertStatus(200);
        $response->assertSee('Sunting Tulisan');
        $response->assertSee(e($post->title), false);
    }

    public function test_authenticated_admin_can_update_chairman_post(): void
    {
        $user = User::factory()->create();
        $post = ChairmanPost::first();
        $this->assertNotNull($post);

        $payload = [
            'title' => 'Judul Catatan Wartawan Diperbarui',
            'category' => 'Etika Jurnalistik',
            'excerpt' => 'Ringkasan yang diperbarui secara akurat.',
            'content' => '<p>Konten revisi mendalam mengenai kode etik jurnalistik PWI.</p>',
            'reading_time' => 5,
            'published_at' => now()->format('Y-m-d H:i:s'),
            'original_url' => 'https://wardianst.wordpress.com/update-test',
        ];

        $response = $this->actingAs($user)->put(route('admin.chairman_posts.update', $post->id), $payload);

        $response->assertRedirect(route('admin.chairman_posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('chairman_posts', [
            'id' => $post->id,
            'title' => 'Judul Catatan Wartawan Diperbarui',
            'category' => 'Etika Jurnalistik',
        ]);
    }

    public function test_authenticated_admin_can_delete_chairman_post(): void
    {
        $user = User::factory()->create();
        $post = ChairmanPost::create([
            'title' => 'Tulisan yang Akan Dihapus',
            'slug' => 'tulisan-yang-akan-dihapus-test',
            'category' => 'Testing',
            'content' => '<p>Tulisan untuk diuji hapus.</p>',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($user)->delete(route('admin.chairman_posts.destroy', $post->id));

        $response->assertRedirect(route('admin.chairman_posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('chairman_posts', [
            'id' => $post->id,
        ]);
    }
}
