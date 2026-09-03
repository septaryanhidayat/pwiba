<?php

namespace Tests\Feature;

use App\Models\Letter;
use App\Models\MeetingMinute;
use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PwiWebTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_homepage_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Persatuan Wartawan Indonesia');
        $response->assertSee('Kabupaten Banyuasin');
    }

    public function test_public_news_page_and_detail_render(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);
        $response->assertSee('Berita', false);

        $post = Post::where('status', 'published')->first();
        $this->assertNotNull($post);

        $detailResponse = $this->get('/berita/'.$post->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($post->judul, false);
    }

    public function test_public_members_and_organization_and_gallery_render(): void
    {
        $orgResponse = $this->get('/struktur-organisasi');
        $orgResponse->assertStatus(200);
        $orgResponse->assertSee('Jajaran Pengurus PWI Kabupaten Banyuasin');

        $membersResponse = $this->get('/anggota');
        $membersResponse->assertStatus(200);
        $membersResponse->assertSee('Data Wartawan Terdaftar');

        $galleryResponse = $this->get('/galeri');
        $galleryResponse->assertStatus(200);
        $galleryResponse->assertSee('Galeri Foto & Dokumentasi Kegiatan PWI', false);
    }

    public function test_public_inbox_submission_works(): void
    {
        $response = $this->post('/kontak/kirim', [
            'nama' => 'Dinas Kominfo Banyuasin',
            'instansi' => 'Diskominfo Banyuasin',
            'email' => 'diskominfo@banyuasinkab.go.id',
            'telepon' => '081234567890',
            'keperluan' => 'Undangan Rapat Koordinasi Forum Pers',
            'pesan' => 'Mohon kehadiran pengurus pada rapat koordinasi media.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inboxes', [
            'nama' => 'Dinas Kominfo Banyuasin',
            'keperluan' => 'Undangan Rapat Koordinasi Forum Pers',
        ]);
    }

    public function test_admin_authentication_and_dashboard(): void
    {
        $loginPage = $this->get('/login');
        $loginPage->assertStatus(200);

        $authResponse = $this->post('/login', [
            'email' => 'admin@pwibanyuasin.or.id',
            'password' => 'admin123',
        ]);

        $authResponse->assertRedirect(route('admin.dashboard'));

        $admin = User::first();
        $dashboardResponse = $this->actingAs($admin)->get('/admin/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('DATA ANGGOTA PWI BANYUASIN');
        $dashboardResponse->assertSee('Wartawan Muda');
    }

    public function test_admin_meetings_and_attendance_module(): void
    {
        $admin = User::first();

        // Index
        $this->actingAs($admin)->get('/admin/notulen-rapat')
            ->assertStatus(200)
            ->assertSee('Notulen Rapat', false);

        // Create
        $this->actingAs($admin)->get('/admin/notulen-rapat/create')
            ->assertStatus(200)
            ->assertSee('Form Pencatatan Notulen Rapat');

        // Store
        $firstMember = Member::first();
        $storeResponse = $this->actingAs($admin)->post('/admin/notulen-rapat', [
            'judul_rapat' => 'Rapat Evaluasi Triwulan PWI Banyuasin',
            'tanggal' => '2026-09-10',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '12:00',
            'tempat' => 'Sekretariat PWI Banyuasin',
            'pemimpin_rapat' => 'Wardoyo, S.I.Kom',
            'notulis' => 'Deni Arianto',
            'agenda' => 'Evaluasi program kerja dan keaktifan media mitra',
            'pembahasan' => 'Seluruh seksi bidang melaporkan kemajuan program kerja.',
            'kesimpulan' => 'Disepakati pembentukan panitia uji kompetensi lanjutan.',
            'attendances' => [
                $firstMember->id => [
                    'status' => 'hadir',
                    'keterangan' => 'Hadir tepat waktu',
                ],
            ],
        ]);

        $storeResponse->assertRedirect(route('admin.meetings.index'));
        $this->assertDatabaseHas('meeting_minutes', [
            'judul_rapat' => 'Rapat Evaluasi Triwulan PWI Banyuasin',
        ]);

        $meeting = MeetingMinute::where('judul_rapat', 'Rapat Evaluasi Triwulan PWI Banyuasin')->first();
        $this->assertNotNull($meeting);

        // Print
        $this->actingAs($admin)->get(route('admin.meetings.print', $meeting->id))
            ->assertStatus(200)
            ->assertSee('BERITA ACARA', false);
    }

    public function test_admin_incoming_and_outgoing_letters(): void
    {
        $admin = User::first();

        // 1. Surat Masuk
        $this->actingAs($admin)->get('/admin/surat-masuk')
            ->assertStatus(200)
            ->assertSee('Buku Arsip Surat Masuk');

        $this->actingAs($admin)->post('/admin/surat-masuk', [
            'nomor_surat' => '005/100/KOMINFO/2026',
            'tanggal_surat' => '2026-09-01',
            'tanggal_diterima' => '2026-09-02',
            'pengirim' => 'Diskominfo Banyuasin',
            'perihal' => 'Undangan Liputan Khusus HUT Banyuasin',
            'status_disposisi' => 'Diterima',
        ])->assertRedirect(route('admin.incoming-letters.index'));

        $this->assertDatabaseHas('incoming_letters', [
            'nomor_surat' => '005/100/KOMINFO/2026',
        ]);

        // 2. Surat Keluar
        $this->actingAs($admin)->get('/admin/surat-keluar')
            ->assertStatus(200)
            ->assertSee('Buku Register Surat Keluar');

        $this->actingAs($admin)->post('/admin/surat-keluar', [
            'nomor_surat' => '010/PWI-BA/IX/2026',
            'tanggal' => '2026-09-03',
            'jenis_surat' => 'SURAT BIASA',
            'tujuan' => 'Kepala Dinas Pertanian Banyuasin',
            'perihal' => 'Konfirmasi Liputan Panen Raya',
            'isi_surat' => 'Permohonan peliputan panen raya padi di Tanjung Lago.',
        ])->assertRedirect(route('admin.letters.index'));

        $this->assertDatabaseHas('letters', [
            'nomor_surat' => '010/PWI-BA/IX/2026',
        ]);
    }

    public function test_admin_crud_pages_render_for_authenticated_admin(): void
    {
        $admin = User::first();

        // 1. Members
        $this->actingAs($admin)->get('/admin/anggota')->assertStatus(200)->assertSee('Data Wartawan Banyuasin Aktif');
        $this->actingAs($admin)->get('/admin/anggota/tidak-aktif')->assertStatus(200)->assertSee('Data Wartawan Belum / Tidak Aktif');
        $this->actingAs($admin)->get(route('admin.members.print-report'))->assertStatus(200)->assertSee('DAFTAR REKAPITULASI ANGGOTA WARTAWAN AKTIF');

        // 2. Media
        $this->actingAs($admin)->get('/admin/media')->assertStatus(200)->assertSee('Direktori Media Pers Mitra');

        // 3. Organization
        $this->actingAs($admin)->get('/admin/struktur-organisasi')->assertStatus(200)->assertSee('Struktur Kepengurusan PWI Banyuasin');

        // 4. Posts
        $this->actingAs($admin)->get('/admin/berita/publish')->assertStatus(200)->assertSee('Data Publish Berita');
        $this->actingAs($admin)->get('/admin/berita/draft')->assertStatus(200)->assertSee('Data Draf Berita');

        // 5. Galleries
        $this->actingAs($admin)->get('/admin/galeri')->assertStatus(200)->assertSee('Galeri Foto Kegiatan PWI Banyuasin');

        // 6. Inbox
        $this->actingAs($admin)->get('/admin/inbox')->assertStatus(200)->assertSee('Buku Tamu');

        // 7. Settings
        $this->actingAs($admin)->get('/admin/pengaturan/data-pwi')->assertStatus(200)->assertSee('Pengaturan Identitas Kantor PWI');
        $this->actingAs($admin)->get('/admin/pengaturan/ganti-sandi')->assertStatus(200)->assertSee('Ganti Kata Sandi Administrator');
    }

    public function test_hero_banner_displays_ketua_and_sambutan_pdf_links(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Wardoyo, S.I.Kom');
        $response->assertSee('Ketua PWI Kabupaten Banyuasin');
        $response->assertSee('Pelantikan ini bukan sekadar seremonial');
        $response->assertSee('assets/dokumen/sambutan-ketua.pdf');
        $this->assertFileExists(public_path('assets/dokumen/sambutan-ketua.pdf'));
    }

    public function test_wartawan_photos_are_assigned_in_database(): void
    {
        $memberWithPhoto = Member::whereNotNull('foto')->where('nama', '!=', 'Wardoyo, S.I.Kom')->first();
        $this->assertNotNull($memberWithPhoto);
        $this->assertStringContainsString('assets/images/wartawan/', $memberWithPhoto->foto);
        $this->assertFileExists(public_path($memberWithPhoto->foto));
    }

    public function test_letter_verification_and_print_with_digital_qr(): void
    {
        $letter = Letter::first();
        $this->assertNotNull($letter);

        // Verification route
        $verifyResponse = $this->get('/verifikasi-surat/'.$letter->uuid);
        $verifyResponse->assertStatus(200);
        $verifyResponse->assertSee('TERVERIFIKASI');
        $verifyResponse->assertSee($letter->nomor_surat);

        // Print view with QR code and Kop
        $admin = User::first();
        $printResponse = $this->actingAs($admin)->get(route('admin.letters.print', $letter->id));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('PERSATUAN WARTAWAN INDONESIA');
        $printResponse->assertSee('PENGURUS KABUPATEN BANYUASIN');
        $printResponse->assertSee('QR Code Verifikasi');
    }

    public function test_image_service_converts_upload_to_webp(): void
    {
        Storage::fake('public');

        // Create dummy PNG image
        $file = UploadedFile::fake()->image('test_avatar.png', 200, 200);
        $path = ImageService::uploadAndConvertToWebp($file, 'test_dir');

        $this->assertStringEndsWith('.webp', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_footer_renders_mobile_centered_classes_and_webp_logo(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('pwi-logo.webp');
        $response->assertSee('text-center md:text-left');
        $response->assertSee('items-center md:items-start');
    }
}
