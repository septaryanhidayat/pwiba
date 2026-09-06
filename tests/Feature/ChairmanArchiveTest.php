<?php

namespace Tests\Feature;

use App\Models\ChairmanPost;
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

    public function test_wardoyo_archive_index_page_is_accessible(): void
    {
        $response = $this->get('/wardoyo');

        $response->assertStatus(200);
        $response->assertSee('Wardoyo, S.I.Kom.');
        $response->assertSee('Katalog Tulisan');
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
    }

    public function test_wardoyo_archive_detail_returns_404_for_invalid_slug(): void
    {
        $response = $this->get('/wardoyo/slug-yang-sama-sekali-tidak-ada-999');

        $response->assertStatus(404);
    }

    public function test_wardoyo_archive_link_is_not_exposed_in_public_navbar_yet(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Memastikan link /wardoyo belum bocor ke navbar utama sesuai instruksi user
        $response->assertDontSee('href="http://localhost/wardoyo"', false);
        $response->assertDontSee("href='http://localhost/wardoyo'", false);
    }
}
