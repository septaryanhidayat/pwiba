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

    /*
    |--------------------------------------------------------------------------
    | Admin Chairman Profile & Portfolio Management Tests (/admin/profil-ketua)
    |--------------------------------------------------------------------------
    */

    public function test_guest_cannot_access_admin_chairman_profile_edit(): void
    {
        $response = $this->get(route('admin.chairman_profile.edit'));
        $response->assertRedirect('/login');

        $postResponse = $this->post(route('admin.chairman_profile.update'), []);
        $postResponse->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_view_chairman_profile_edit_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.chairman_profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Edit Profil &amp; Portofolio Ketua', false);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="title"', false);
        $response->assertSee('name="foto"', false);
        $response->assertSee('1. Identitas &amp; Foto Utama', false);
    }

    public function test_authenticated_admin_can_update_chairman_profile_and_reflects_publicly(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'Wardoyo, S.I.Kom., M.I.Kom.',
            'title' => 'Ketua Terpilih PWI Kabupaten Banyuasin',
            'sk_resmi' => 'SK PWI Pusat Nomor: 999/PP-PWI/XII/2025',
            'badge_top' => 'Profil Resmi Pemimpin Redaksi & Tokoh Pers',
            'tag_status_pers' => 'Wartawan Tingkat Utama Nasional',
            'tag_organisasi_provinsi' => 'Dewan Penasihat PWI Sumsel',
            'motto' => 'Membangun jurnalisme berkarakter demi kemajuan Bumi Sedulang Setudung.',
            'ttl' => 'Sragen, 17 Februari 1976',
            'agama' => 'Islam',
            'lokasi_singkat' => 'Pangkalan Balai, Banyuasin',
            'alamat' => 'Jl. Lintas Timur KM 42, Pangkalan Balai',

            'badge_bawah_foto' => 'LEMBAGA PERS RESMI',
            'judul_bawah_foto' => 'Ketua PWI Banyuasin',
            'subjudul_bawah_foto' => 'Periode 2025 – 2028',

            'telepon' => '0812-3456-7890',
            'email' => 'wardoyo.ketua@pwiba.or.id',
            'instagram' => 'https://www.instagram.com/wardoyo_official/',
            'facebook' => 'https://www.facebook.com/wardoyo.official',

            'stat_karya' => '500+',
            'stat_karya_label' => 'Arsip Karya',
            'stat_kiprah' => '20+ Th',
            'stat_kiprah_label' => 'Dedikasi Pers',
            'stat_lisensi' => 'Utama Dewan Pers',
            'stat_lisensi_label' => 'Lisensi Kompetensi',
            'stat_pendidikan' => 'M.I.Kom.',
            'stat_pendidikan_label' => 'Magister Komunikasi',

            'narasi_subjudul' => 'Dedikasi Dua Dekade',
            'narasi_judul' => 'Integritas Mengabdi Tanpa Henti',
            'narasi_paragraf_1' => 'Paragraf pertama biografi kepemimpinan yang diperbarui oleh admin.',
            'narasi_paragraf_2' => 'Paragraf kedua perjalanan akademik dan profesional.',
            'narasi_paragraf_3' => 'Paragraf ketiga komitmen visi masa depan PWI.',

            'pilar_nilai' => [
                [
                    'icon' => 'fa-solid fa-feather',
                    'title' => 'Kemerdekaan Pers Digital',
                    'desc' => 'Menjaga marwah jurnalisme di era teknologi informasi.',
                ],
            ],

            'organisasi' => [
                [
                    'posisi' => 'Ketua PWI Kabupaten Banyuasin',
                    'masa' => '2025 – 2028',
                    'ket' => 'SK PWI Pusat Nomor 999',
                ],
            ],

            'pendidikan' => [
                [
                    'tingkat' => 'S1 (Sarjana)',
                    'instansi' => 'STISIPOL Candradimuka',
                    'prodi' => 'Ilmu Jurnalistik',
                    'status' => 'Lulus',
                ],
            ],

            'sertifikasi' => [
                [
                    'bidang' => 'Wartawan Utama Dewan Pers',
                    'penerbit' => 'Dewan Pers RI',
                    'nomor' => '999/DP/2025',
                    'tahun' => '2025',
                    'keterangan' => 'Predikat Terbaik',
                ],
            ],

            'footer_badge' => 'Kemitraan Terpercaya',
            'footer_title' => 'Kolaborasi Bersama PWI Banyuasin',
            'footer_desc' => 'Membuka pintu sinergi pembangunan daerah yang berkelanjutan.',
        ];

        $response = $this->actingAs($user)->post(route('admin.chairman_profile.update'), $payload);

        $response->assertRedirect(route('admin.chairman_profile.edit'));
        $response->assertSessionHas('success');

        // Pastikan perubahan langsung terefleksi di halaman publik /wardoyo
        $publicResponse = $this->get('/wardoyo');
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Wardoyo, S.I.Kom., M.I.Kom.');
        $publicResponse->assertSee('Ketua Terpilih PWI Kabupaten Banyuasin');
        $publicResponse->assertSee('SK PWI Pusat Nomor: 999/PP-PWI/XII/2025');
        $publicResponse->assertSee('Membangun jurnalisme berkarakter demi kemajuan Bumi Sedulang Setudung.');
        $publicResponse->assertSee('500+');
        $publicResponse->assertSee('Arsip Karya');
        $publicResponse->assertSee('Integritas Mengabdi Tanpa Henti');
        $publicResponse->assertSee('Kemerdekaan Pers Digital');
        $publicResponse->assertSee('wardoyo.ketua@pwiba.or.id');
        $publicResponse->assertSee('0812-3456-7890');
        $publicResponse->assertSee('https://www.instagram.com/wardoyo_official/');
        $publicResponse->assertSee('Kolaborasi Bersama PWI Banyuasin');
    }
}
