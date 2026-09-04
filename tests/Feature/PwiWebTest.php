<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Leader;
use App\Models\Letter;
use App\Models\Media;
use App\Models\MeetingMinute;
use App\Models\Member;
use App\Models\OrganizationStructure;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Setting;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
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
        $dashboardResponse->assertSee('Publikasi Berita');
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
        $this->assertNotEmpty($memberWithPhoto->foto_url);
        $this->assertNotEmpty($memberWithPhoto->foto);
    }

    public function test_member_ordering_puts_pengurus_first(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin/anggota');
        $response->assertStatus(200);

        // First members should be leadership (Ketua, etc.)
        $members = Member::where('status', 'aktif')
            ->orderByRaw("CASE 
                WHEN UPPER(TRIM(jabatan)) = 'KETUA' THEN 1
                WHEN UPPER(TRIM(jabatan)) LIKE 'WAKIL KETUA%' THEN 2
                WHEN UPPER(TRIM(jabatan)) = 'SEKRETARIS' THEN 3
                ELSE 20 END")
            ->orderBy('nama', 'asc')
            ->take(5)
            ->pluck('jabatan')
            ->toArray();

        $this->assertEquals('KETUA', $members[0]);
    }

    public function test_public_members_directory_toggle(): void
    {
        $admin = User::first();

        // Turn OFF
        Setting::updateOrCreate(['key' => 'show_public_members'], ['value' => '0']);
        $respOff = $this->get('/anggota');
        $respOff->assertStatus(200);
        $respOff->assertSee('Direktori Anggota Sedang Diperbarui');

        // Toggle via admin
        $toggleResp = $this->actingAs($admin)->post('/admin/anggota/toggle-publik');
        $toggleResp->assertRedirect();
        $this->assertEquals('1', Setting::where('key', 'show_public_members')->value('value'));

        // Turn ON check
        $respOn = $this->get('/anggota');
        $respOn->assertStatus(200);
        $respOn->assertSee('Insan Pers Terdaftar');
        $respOn->assertSee('Wardoyo, S.I.Kom');

        // Reset to OFF as requested by user
        Setting::updateOrCreate(['key' => 'show_public_members'], ['value' => '0']);
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

    public function test_public_leaders_page_renders_with_proportional_data(): void
    {
        $response = $this->get('/ketua-dari-masa-ke-masa');
        $response->assertStatus(200);
        $response->assertSee('Ketua PWI Kabupaten Banyuasin');
        $response->assertSee('Dari Masa ke Masa');
        $response->assertSee('Wardoyo, S.I.Kom');
        $response->assertSee('2025 - 2028');
        $response->assertSee('Saryanto, SH');
        $response->assertSee('Dian Fauzen, ST');
    }

    public function test_admin_can_manage_leaders_crud(): void
    {
        $admin = User::first();
        $this->assertNotNull($admin);

        // Index
        $indexResponse = $this->actingAs($admin)->get(route('admin.leaders.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Ketua PWI Banyuasin Dari Masa ke Masa');

        // Create / Store
        $storeResponse = $this->actingAs($admin)->post(route('admin.leaders.store'), [
            'nama' => 'Ketua Percobaan, S.Pd',
            'jabatan' => 'Ketua PWI Banyuasin',
            'periode' => '2028 - 2031',
            'tahun_mulai' => 2028,
            'tahun_selesai' => 2031,
            'urutan' => 6,
            'keterangan' => 'Ketua masa depan',
        ]);
        $storeResponse->assertRedirect(route('admin.leaders.index'));

        $leader = Leader::where('nama', 'Ketua Percobaan, S.Pd')->first();
        $this->assertNotNull($leader);
        $this->assertEquals('2028 - 2031', $leader->periode);

        // Update
        $updateResponse = $this->actingAs($admin)->put(route('admin.leaders.update', $leader->id), [
            'nama' => 'Ketua Percobaan, M.Si',
            'jabatan' => 'Ketua PWI Banyuasin',
            'periode' => '2028 - 2031',
            'tahun_mulai' => 2028,
            'tahun_selesai' => 2031,
            'urutan' => 6,
            'keterangan' => 'Ketua masa depan terupdate',
        ]);
        $updateResponse->assertRedirect(route('admin.leaders.index'));
        $this->assertEquals('Ketua Percobaan, M.Si', $leader->fresh()->nama);

        // Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.leaders.destroy', $leader->id));
        $deleteResponse->assertRedirect(route('admin.leaders.index'));
        $this->assertNull(Leader::find($leader->id));
    }

    public function test_database_has_exact_22_published_news_and_17_galleries(): void
    {
        $publishedNewsCount = Post::where('status', 'published')->count();
        $this->assertEquals(22, $publishedNewsCount);

        $galleryCount = Gallery::count();
        $this->assertEquals(17, $galleryCount);

        $leadersCount = Leader::count();
        $this->assertEquals(5, $leadersCount);

        $orgsCount = OrganizationStructure::count();
        $this->assertEquals(32, $orgsCount);
    }

    public function test_home_page_shows_four_distinct_executives_and_sejarah_menu(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sejarah');
        $response->assertSee('Wardoyo, S.I.Kom');
        $response->assertSee('H. Gusra Yetri, SH');
        $response->assertSee('Deni Arianto');
        $response->assertSee('Ridho Andi Sucipto, M.Pd');
    }

    public function test_all_admin_navigation_pages_render_status_200(): void
    {
        $admin = User::first();
        $this->assertNotNull($admin);

        $urls = [
            '/admin/dashboard',
            '/admin/anggota',
            '/admin/anggota/tidak-aktif',
            '/admin/media',
            '/admin/struktur-organisasi',
            '/admin/ketua-dari-masa-ke-masa',
            '/admin/notulen-rapat',
            '/admin/notulen-rapat/tambah',
            '/admin/surat-keluar',
            '/admin/surat-keluar/buat',
            '/admin/surat-masuk',
            '/admin/inbox',
            '/admin/berita/publish',
            '/admin/berita/draft',
            '/admin/berita/tambah',
            '/admin/galeri',
            '/admin/pengaturan/data-pwi',
            '/admin/pengaturan/ganti-sandi',
        ];

        foreach ($urls as $url) {
            $response = $this->actingAs($admin)->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_new_domain_application_letter_and_notulen_paper_sheet(): void
    {
        $admin = User::first();
        $letter = Letter::where('nomor_surat', '094/PWI-BA/IX/2026')->first();
        $this->assertNotNull($letter);
        $this->assertEquals('Pengajuan Nama Domain', $letter->perihal);

        $response = $this->actingAs($admin)->get("/admin/surat-keluar/{$letter->id}/cetak");
        $response->assertStatus(200);
        $response->assertSee('094/PWI-BA/IX/2026');
        $response->assertSee('Pengelola Domain ID Indonesia');

        $meeting = MeetingMinute::first();
        $this->assertNotNull($meeting);
        $resMeeting = $this->actingAs($admin)->get("/admin/notulen-rapat/{$meeting->id}/cetak");
        $resMeeting->assertStatus(200);
        $resMeeting->assertSee('page-sheet');
        $resMeeting->assertSee('paper-toolbar');
    }

    public function test_admin_leaders_crud_and_aliases(): void
    {
        $admin = User::first();
        $leader = Leader::first();
        $this->assertNotNull($leader);

        // Test GET /admin/ketua-dari-masa-ke-masa
        $this->actingAs($admin)->get('/admin/ketua-dari-masa-ke-masa')
            ->assertStatus(200)
            ->assertSee('Ketua PWI Banyuasin Dari Masa ke Masa');

        // Test GET /admin/leaders (alias)
        $this->actingAs($admin)->get('/admin/leaders')
            ->assertStatus(200)
            ->assertSee('Ketua PWI Banyuasin Dari Masa ke Masa');

        // Test GET /admin/leaders/{id} redirects gracefully instead of 404
        $this->actingAs($admin)->get("/admin/leaders/{$leader->id}")
            ->assertRedirect(route('admin.leaders.index'));

        // Test PUT /admin/leaders/{id} succeeds
        $this->actingAs($admin)->put("/admin/leaders/{$leader->id}", [
            'nama' => $leader->nama,
            'jabatan' => $leader->jabatan,
            'periode' => $leader->periode,
            'tahun_mulai' => $leader->tahun_mulai,
            'tahun_selesai' => $leader->tahun_selesai,
            'urutan' => $leader->urutan,
            'keterangan' => 'Ketua Pertama Terverifikasi',
        ])->assertRedirect(route('admin.leaders.index'));

        // Test PUT /admin/ketua-dari-masa-ke-masa/{id} with uploaded photo succeeds
        $testLeader = Leader::create([
            'nama' => 'Testing Leader',
            'jabatan' => 'Ketua Demisioner',
            'periode' => '1999 - 2000',
            'urutan' => 99,
        ]);
        $fakePhoto = UploadedFile::fake()->image('test_leader.jpg', 400, 500);
        $this->actingAs($admin)->put("/admin/ketua-dari-masa-ke-masa/{$testLeader->id}", [
            'nama' => 'Testing Leader Updated',
            'jabatan' => 'Ketua Demisioner',
            'periode' => '1999 - 2000',
            'urutan' => 99,
            'foto' => $fakePhoto,
        ])->assertRedirect(route('admin.leaders.index'));
        $testLeader->delete();
    }

    public function test_admin_can_update_member_media_properly(): void
    {
        $admin = User::first();
        $this->assertNotNull($admin);

        $member = Member::where('nama', 'like', '%Malyadi%')->first();
        $this->assertNotNull($member);

        $mediaRadar = Media::where('nama_media', 'like', '%Radar Banyuasin%')->first();
        $this->assertNotNull($mediaRadar);

        $response = $this->actingAs($admin)->put(route('admin.members.update', $member->id), [
            'nama' => 'Malyadi, SH, M.Si',
            'nomor_kartu' => $member->nomor_kartu,
            'nomor_kartu_ukw' => $member->nomor_kartu_ukw,
            'tingkat_ukw' => $member->tingkat_ukw,
            'masa_berlaku' => $member->masa_berlaku ? $member->masa_berlaku->format('Y-m-d') : '2028-04-16',
            'jabatan' => $member->jabatan,
            'media_id' => $mediaRadar->id,
            'nama_media_custom' => $mediaRadar->nama_media,
            'status' => 'aktif',
        ]);

        $response->assertRedirect();
        $this->assertEquals($mediaRadar->id, $member->fresh()->media_id);
        $this->assertEquals($mediaRadar->nama_media, $member->fresh()->nama_media_custom);
    }

    public function test_public_organization_renders_hierarchy_tree_chart(): void
    {
        $response = $this->get('/struktur-organisasi');
        $response->assertStatus(200);
        $response->assertSee('Bagan Alur & Hirarki Kepengurusan', false);
        $response->assertSee('Format Landscape', false);
        $response->assertSee('Wardoyo, S.I.Kom', false);
        $response->assertSee('WAKIL KETUA 1', false);
        $response->assertSee('WAKIL KETUA 2', false);
        $response->assertSee('WAKIL KETUA 3', false);
        $response->assertSee('BIDANG A', false);
        $response->assertSee('Unduh PNG', false);
    }

    public function test_public_members_page_renders_malyadi_and_radar_banyuasin_when_enabled(): void
    {
        Setting::updateOrCreate(['key' => 'show_public_members'], ['value' => '1']);

        $member = Member::where('nama', 'like', '%Malyadi%')->first();
        $mediaRadar = Media::where('nama_media', 'like', '%Radar Banyuasin%')->first();
        $member->media_id = $mediaRadar->id;
        $member->nama_media_custom = $mediaRadar->nama_media;
        $member->save();

        $response = $this->get('/anggota?search=Malyadi');
        $response->assertStatus(200);
        $response->assertSee('Malyadi, SH, M.Si', false);
        $response->assertSee('Radar Banyuasin', false);
    }

    public function test_admin_organization_structure_renders_without_sql_errors(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin/struktur-organisasi');
        $response->assertStatus(200);
        $response->assertSee('Struktur Kepengurusan PWI Banyuasin');
    }

    public function test_admin_members_page_does_not_leak_javascript_code_in_html(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin/anggota');
        $response->assertStatus(200);
        $response->assertSee('function memberManager()', false);
        $response->assertSee('x-data="memberManager()"', false);
    }

    public function test_admin_forms_include_wordpress_style_rich_editor(): void
    {
        $admin = User::first();

        // 1. Post Create Form
        $postCreate = $this->actingAs($admin)->get(route('admin.posts.create'));
        $postCreate->assertStatus(200);
        $postCreate->assertSee('rich-editor', false);
        $postCreate->assertSee('initWordPressEditor', false);
        $postCreate->assertSee('tinymce.init', false);

        // 2. Meeting Create Form
        $meetingCreate = $this->actingAs($admin)->get(route('admin.meetings.create'));
        $meetingCreate->assertStatus(200);
        $meetingCreate->assertSee('rich-editor', false);
        $meetingCreate->assertSee('pembahasan', false);
        $meetingCreate->assertSee('kesimpulan', false);

        // 3. Letter Create Form
        $letterCreate = $this->actingAs($admin)->get(route('admin.letters.create'));
        $letterCreate->assertStatus(200);
        $letterCreate->assertSee('rich-editor', false);
        $letterCreate->assertSee('isi_surat', false);
    }

    public function test_admin_letter_and_meeting_print_views_have_kop_revision_and_paper_switcher(): void
    {
        $admin = User::first();

        // Check Letter Print View
        $letter = Letter::first();
        $letterPrint = $this->actingAs($admin)->get(route('admin.letters.print', $letter->id));
        $letterPrint->assertStatus(200);
        $letterPrint->assertSee('margin: 0.5cm', false);
        $letterPrint->assertSee('padding: 0.5cm', false);
        $letterPrint->assertSee('Jalan Merdeka NO 3 RT 02 RW 02', false);
        $letterPrint->assertDontSee('Sumatera Selatan<br>', false);
        $letterPrint->assertSee('btn-paper-a4', false);
        $letterPrint->assertSee('btn-paper-legal', false);
        $letterPrint->assertSee('setPaperSize', false);

        // Check Meeting Print View
        $meeting = MeetingMinute::first();
        if ($meeting) {
            $meetingPrint = $this->actingAs($admin)->get(route('admin.meetings.print', $meeting->id));
            $meetingPrint->assertStatus(200);
            $meetingPrint->assertSee('margin: 0.5cm', false);
            $meetingPrint->assertSee('padding: 0.5cm', false);
            $meetingPrint->assertSee('btn-paper-a4', false);
            $meetingPrint->assertSee('btn-paper-legal', false);
            $meetingPrint->assertSee('setPaperSize', false);
        }

        // Check Members Print Report View
        $reportPrint = $this->actingAs($admin)->get(route('admin.members.print-report'));
        $reportPrint->assertStatus(200);
        $reportPrint->assertSee('margin: 0.5cm', false);
        $reportPrint->assertSee('padding: 0.5cm', false);
        $reportPrint->assertSee('btn-paper-a4', false);
        $reportPrint->assertSee('btn-paper-legal', false);
    }

    public function test_post_with_wordpress_rich_html_formats_renders_correctly_on_public_page(): void
    {
        $admin = User::first();

        $richContent = '<p style="text-align: justify;"><span style="color: #0b2b68; font-size: 16pt;"><strong>Rapat Koordinasi Bersejarah PWI Banyuasin</strong></span></p><p style="text-align: justify;"><em>Pangkalan Balai</em> - Berita acara pembahasan <strong>resmi</strong> dengan perataan penuh (justify) dan warna khas organisasi.</p>';

        $response = $this->actingAs($admin)->post(route('admin.posts.store'), [
            'judul' => 'Uji Coba Toolbar WordPress CMS PWI',
            'ringkasan' => 'Ringkasan singkat uji coba fitur toolbar.',
            'konten' => $richContent,
            'penulis' => 'Wardoyo, S.I.Kom',
            'kategori' => 'Organisasi',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.posts.publish'));

        $post = Post::where('judul', 'Uji Coba Toolbar WordPress CMS PWI')->first();
        $this->assertNotNull($post);
        $this->assertEquals($richContent, $post->konten);

        // Verify public detail view renders the HTML
        $publicDetail = $this->get(route('news.show', $post->slug));
        $publicDetail->assertStatus(200);
        $publicDetail->assertSee('text-align: justify;', false);
        $publicDetail->assertSee('color: #0b2b68;', false);
        $publicDetail->assertSee('Rapat Koordinasi Bersejarah PWI Banyuasin', false);
    }

    public function test_news_detail_renders_all_seven_circular_share_buttons_without_adblock_risk(): void
    {
        $post = Post::where('status', 'published')->first();
        $this->assertNotNull($post);

        $response = $this->get(route('news.show', $post->slug));
        $response->assertStatus(200);
        $response->assertSee('Bagikan Berita Ini:', false);

        // Assert all 7 round share icons exist
        $response->assertSee('fa-whatsapp', false);
        $response->assertSee('fa-facebook-f', false);
        $response->assertSee('fa-instagram', false);
        $response->assertSee('fa-x-twitter', false);
        $response->assertSee('fa-telegram', false);
        $response->assertSee('fa-threads', false);
        $response->assertSee('copyShareIcon', false);
        $response->assertSee('rounded-full', false);
        $response->assertSee('copyNewsLink', false);

        // Assert all 7 shareTo actions are present in buttons
        $response->assertSee("shareTo('whatsapp')", false);
        $response->assertSee("shareTo('facebook')", false);
        $response->assertSee("shareTo('instagram')", false);
        $response->assertSee("shareTo('x')", false);
        $response->assertSee("shareTo('telegram')", false);
        $response->assertSee("shareTo('threads')", false);

        // Assert direct tracker URLs are NOT used on <a> tags to prevent Brave Shields / adblocker cosmetic hiding
        $response->assertDontSee('href="https://www.facebook.com/sharer', false);
        $response->assertDontSee('href="https://twitter.com/intent', false);
        $response->assertDontSee('href="https://t.me/share', false);
    }

    public function test_first_visit_increments_views_count_and_creates_post_view_record(): void
    {
        $post = Post::where('status', 'published')->first();
        $this->assertNotNull($post);

        $initialViews = $post->views_count;
        $initialRecords = PostView::where('post_id', $post->id)->count();

        $response = $this->withServerVariables([
            'REMOTE_ADDR' => '192.168.10.15',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        ])->get(route('news.show', $post->slug));

        $response->assertStatus(200);

        $post->refresh();
        $this->assertEquals($initialViews + 1, $post->views_count);
        $this->assertEquals($initialRecords + 1, PostView::where('post_id', $post->id)->count());

        $latestView = PostView::where('post_id', $post->id)->latest('id')->first();
        $this->assertEquals('192.168.10.15', $latestView->ip_address);
    }

    public function test_refreshing_page_in_same_session_does_not_increment_counter(): void
    {
        $post = Post::where('status', 'published')->first();
        $this->assertNotNull($post);

        // First visit
        $this->withSession(['viewed_post_'.$post->id => now()->timestamp])
            ->get(route('news.show', $post->slug))
            ->assertStatus(200);

        $post->refresh();
        $viewsAfterFirst = $post->views_count;

        // Second visit with same session (refresh)
        $this->withSession(['viewed_post_'.$post->id => now()->timestamp])
            ->get(route('news.show', $post->slug))
            ->assertStatus(200);

        $post->refresh();
        $this->assertEquals($viewsAfterFirst, $post->views_count);
    }

    public function test_bot_crawlers_are_ignored_and_do_not_increment_counter(): void
    {
        $post = Post::where('status', 'published')->first();
        $this->assertNotNull($post);

        $initialViews = $post->views_count;

        // Bot visit (Googlebot)
        $this->withServerVariables([
            'REMOTE_ADDR' => '66.249.66.1',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
        ])->get(route('news.show', $post->slug))->assertStatus(200);

        $post->refresh();
        $this->assertEquals($initialViews, $post->views_count);

        // Bot visit (AhrefsBot)
        $this->withServerVariables([
            'REMOTE_ADDR' => '54.36.148.1',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)',
        ])->get(route('news.show', $post->slug))->assertStatus(200);

        $post->refresh();
        $this->assertEquals($initialViews, $post->views_count);
    }

    public function test_sync_post_views_artisan_command(): void
    {
        $post = Post::where('status', 'published')->first();
        $this->assertNotNull($post);

        // Set a fake views_count
        $post->update(['views_count' => 999]);

        $exitCode = Artisan::call('posts:sync-views', ['--reset-all' => true]);
        $this->assertEquals(0, $exitCode);

        $post->refresh();
        $realCount = PostView::where('post_id', $post->id)->count();
        $this->assertEquals($realCount, $post->views_count);
    }

    public function test_pagination_renders_numeric_and_icons_without_raw_translation_keys(): void
    {
        // Seed enough posts to generate pagination (more than 9)
        for ($i = 1; $i <= 15; $i++) {
            Post::create([
                'judul' => "Berita Uji Pagination $i",
                'ringkasan' => "Ringkasan berita ke-$i",
                'konten' => "<p>Isi berita ke-$i</p>",
                'status' => 'published',
                'published_at' => now()->subMinutes($i),
            ]);
        }

        $response = $this->get('/berita');
        $response->assertStatus(200);

        // Ensure raw pagination translation strings are never displayed
        $response->assertDontSee('pagination.previous');
        $response->assertDontSee('pagination.next');

        // Check for modern chevron icons
        $response->assertSee('fa-chevron-left');
        $response->assertSee('fa-chevron-right');

        // Check admin posts pagination
        $admin = User::first();
        $adminPosts = $this->actingAs($admin)->get(route('admin.posts.index'));
        $adminPosts->assertStatus(200);
        $adminPosts->assertDontSee('pagination.previous');
        $adminPosts->assertDontSee('pagination.next');
    }

    public function test_admin_header_has_symmetric_controls_and_clean_buttons(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);

        // Header controls have symmetric w-9 h-9 rounded-xl sizing
        $response->assertSee('w-9 h-9 rounded-xl');

        // Check organization page doesn't have duplicate + + in buttons
        $orgResponse = $this->actingAs($admin)->get(route('admin.organization.index'));
        $orgResponse->assertStatus(200);
        $orgResponse->assertDontSee('+ +');
        $orgResponse->assertSee('Tambah Pengurus');
    }

    public function test_centralized_office_settings_can_be_updated_and_reflected_globally(): void
    {
        $admin = User::first();

        // Update office settings via admin endpoint
        $response = $this->actingAs($admin)->post(route('admin.settings.office.update'), [
            'nama_pwi' => 'PWI Kabupaten Banyuasin',
            'alamat_kantor' => 'Jalan PWI Terintegrasi No. 99, Pangkalan Balai',
            'kota' => 'Pangkalan Balai',
            'no_telp' => '0812-9999-8888',
            'email' => 'sekretariat@pwiba.or.id',
            'ketua_nama' => 'Wardoyo, S.I.Kom',
            'ketua_sambutan' => 'Sambutan resmi PWI',
            'visi' => 'Visi PWI',
            'misi' => 'Misi PWI',
        ]);

        $response->assertRedirect();

        // Check that public pages reflect the new email, address, and phone
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('sekretariat@pwiba.or.id');
        $homeResponse->assertSee('Jalan PWI Terintegrasi No. 99, Pangkalan Balai');
        $homeResponse->assertSee('0812-9999-8888');
    }

    public function test_watermark_beranda_teknologi_digital_renders_in_public_and_admin_footers(): void
    {
        // Public footer check
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Beranda Teknologi Digital');
        $homeResponse->assertSee('https://berandadigital.net');

        // Admin footer check
        $admin = User::first();
        $adminResponse = $this->actingAs($admin)->get(route('admin.dashboard'));
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Beranda Teknologi Digital');
        $adminResponse->assertSee('https://berandadigital.net');
    }
}
