<?php

namespace Tests\Feature;

use App\Models\Letter;
use App\Models\User;
use Database\Seeders\RabBanyuasin2027Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialLetterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_generate_nomor_surat_for_surat_khusus(): void
    {
        $nomor = Letter::generateNomorSurat('SURAT KHUSUS');
        $this->assertStringContainsString('PWI-SK', $nomor);
    }

    public function test_can_create_surat_khusus_without_sekretaris(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post(route('admin.letters.store'), [
            'nomor_surat' => '099/PWI-SK/IX/2026',
            'tanggal' => '2026-09-14',
            'jenis_surat' => 'SURAT KHUSUS',
            'perihal' => 'Mandat Khusus Peliputan Daerah Tertinggal',
            'tujuan' => 'Dinas Kominfo Banyuasin',
            'isi_surat' => 'Dengan hormat, surat mandat khusus ini diterbitkan untuk keperluan koordinasi khusus.',
            'penandatangan_nama' => 'Wardoyo, S.I.Kom',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.letters.index'));

        $letter = Letter::where('nomor_surat', '099/PWI-SK/IX/2026')->first();
        $this->assertNotNull($letter);
        $this->assertEquals('SURAT KHUSUS', $letter->jenis_surat);
        $this->assertNull($letter->penandatangan_sekretaris);
        $this->assertEquals('Wardoyo, S.I.Kom', $letter->penandatangan_nama);
    }

    public function test_surat_khusus_print_renders_kop_exact_color_and_only_ketua_signature_centered(): void
    {
        $admin = User::first();

        $letter = Letter::create([
            'nomor_surat' => '100/PWI-SK/IX/2026',
            'tanggal' => '2026-09-14',
            'jenis_surat' => 'SURAT KHUSUS',
            'perihal' => 'Instruksi Khusus Internal',
            'tujuan' => 'Seluruh Anggota PWI',
            'isi_surat' => 'Instruksi khusus kepada seluruh anggota...',
            'penandatangan_nama' => 'Wardoyo, S.I.Kom',
            'penandatangan_sekretaris' => null,
            'status' => 'published',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.letters.print', $letter->id));
        $response->assertStatus(200);

        // Verify Kop Surat Color & Structure
        $response->assertSee('background-color: #0B4DA2', false);
        $response->assertSee('PERSATUAN WARTAWAN INDONESIA');
        $response->assertSee('PENGURUS KABUPATEN BANYUASIN');
        $response->assertSee('Central Executive Board');
        $response->assertSee('INDONESIAN JOURNALIST', false);
        $response->assertSee('Jalan Merdeka', false);

        // Verify Center Signature Section
        $response->assertSee('signature-section');
        $response->assertSee('Hormat kami,');
        $response->assertSee('Pengurus PWI Banyuasin');
        $response->assertSee('signature-single');
        $response->assertSee('Wardoyo, S.I.Kom');
        $response->assertSee('Ketua');

        // Ensure Sekretaris is NOT rendered in signature block
        $response->assertDontSee('Sekretaris');
        $response->assertDontSee('Deni Arianto');

        // Verify Tembusan
        $response->assertSee('Tembusan :');
        $response->assertSee('1. Arsip.');
    }

    public function test_surat_biasa_print_renders_both_ketua_and_sekretaris_centered(): void
    {
        $admin = User::first();

        $letter = Letter::where('jenis_surat', 'SURAT BIASA')->first();
        if (! $letter) {
            $letter = Letter::create([
                'nomor_surat' => '048/PWI-BA/IV/2026',
                'tanggal' => '2026-04-27',
                'jenis_surat' => 'SURAT BIASA',
                'perihal' => 'Permohonan Hibah Tanah',
                'tujuan' => 'Bupati Banyuasin',
                'isi_surat' => 'Pengurus Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin...',
                'penandatangan_nama' => 'Wardoyo, S.I.Kom',
                'penandatangan_sekretaris' => 'Deni Arianto',
                'status' => 'published',
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.letters.print', $letter->id));
        $response->assertStatus(200);

        // Verify Kop color
        $response->assertSee('background-color: #0B4DA2', false);

        // Verify Both signers appear
        $response->assertSee('Wardoyo, S.I.Kom');
        $response->assertSee('Ketua');
        $response->assertSee('Deni Arianto');
        $response->assertSee('Sekretaris');

        // Verify Tembusan
        $response->assertSee('Tembusan :');
        $response->assertSee('1. Arsip.');
    }

    public function test_surat_khusus_word_export(): void
    {
        $admin = User::first();

        $letter = Letter::create([
            'nomor_surat' => '101/PWI-SK/IX/2026',
            'tanggal' => '2026-09-14',
            'jenis_surat' => 'SURAT KHUSUS',
            'perihal' => 'Mandat Khusus Word Export',
            'tujuan' => 'Mitra Strategis',
            'isi_surat' => 'Testing Word export layout for Surat Khusus.',
            'penandatangan_nama' => 'Wardoyo, S.I.Kom',
            'penandatangan_sekretaris' => null,
            'status' => 'published',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.letters.export_docx', $letter->id));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    }

    public function test_rab_banyuasin_2027_seeder_and_export(): void
    {
        $admin = User::first();
        $this->seed(RabBanyuasin2027Seeder::class);

        $pengantar = Letter::where('nomor_surat', '097/PWI-BA/IX/2026')->first();
        $this->assertNotNull($pengantar);
        $this->assertEquals('SURAT BIASA', $pengantar->jenis_surat);
        $this->assertStringContainsString('Program Kerja dan RAB PWI Banyuasin TA 2027', $pengantar->perihal);

        $printPengantar = $this->actingAs($admin)->get(route('admin.letters.print', $pengantar->id));
        $printPengantar->assertStatus(200);
        $printPengantar->assertSee('white-space: nowrap', false);
        $printPengantar->assertSee('Bupati Banyuasin');

        $docxPengantar = $this->actingAs($admin)->get(route('admin.letters.export_docx', $pengantar->id));
        $docxPengantar->assertStatus(200);

        $proposal = Letter::where('nomor_surat', '098/PWI-PROP/IX/2026')->first();
        $this->assertNotNull($proposal);
        $this->assertEquals('PROPOSAL', $proposal->jenis_surat);
        $this->assertStringContainsString('345.000.000', $proposal->isi_surat);

        $printProposal = $this->actingAs($admin)->get(route('admin.letters.print', $proposal->id));
        $printProposal->assertStatus(200);
        $printProposal->assertSee('PROPOSAL KEGIATAN');
        $printProposal->assertSee('345.000.000');

        $docxProposal = $this->actingAs($admin)->get(route('admin.letters.export_docx', $proposal->id));
        $docxProposal->assertStatus(200);
    }

    public function test_index_page_links_directly_to_full_page_create_for_all_letter_types(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get(route('admin.letters.index'));
        $response->assertStatus(200);

        // Verify direct links to full-page create with letter types
        $response->assertSee(route('admin.letters.create'));
        $response->assertSee(route('admin.letters.create', ['jenis' => 'SURAT BIASA']));
        $response->assertSee(route('admin.letters.create', ['jenis' => 'PROPOSAL']));
        $response->assertSee(route('admin.letters.create', ['jenis' => 'SURAT KHUSUS']));
        $response->assertSee(route('admin.letters.create', ['jenis' => 'SURAT TUGAS']));
        $response->assertSee(route('admin.letters.create', ['jenis' => 'SURAT AUDENSI']));
    }

    public function test_create_letter_full_page_renders_complete_form_and_toolbar(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get(route('admin.letters.create', ['jenis' => 'SURAT KHUSUS']));
        $response->assertStatus(200);

        // Verify full-page components
        $response->assertSee('Buat Surat Keluar Baru');
        $response->assertSee('rich-editor');
        $response->assertSee('tinymce');
        $response->assertSee('SURAT BIASA');
        $response->assertSee('PROPOSAL');
        $response->assertSee('SURAT KHUSUS');
        $response->assertSee('SURAT TUGAS');
        $response->assertSee('SURAT AUDENSI');
        $response->assertSee('Simpan sebagai Draft');
        $response->assertSee('Publish / Terbitkan Surat');
    }

    public function test_edit_letter_full_page_renders_complete_form_and_toolbar(): void
    {
        $admin = User::first();
        $letter = Letter::first();

        $response = $this->actingAs($admin)->get(route('admin.letters.edit', $letter->id));
        $response->assertStatus(200);

        $response->assertSee('Edit Surat Keluar');
        $response->assertSee('rich-editor');
        $response->assertSee('tinymce');
        $response->assertSee($letter->nomor_surat);
    }

    public function test_can_store_draft_and_published_from_full_page_form(): void
    {
        $admin = User::first();

        // 1. Store as Draft
        $resDraft = $this->actingAs($admin)->post(route('admin.letters.store'), [
            'nomor_surat' => '102/PWI-BA/IX/2026',
            'tanggal' => '2026-09-14',
            'jenis_surat' => 'SURAT BIASA',
            'perihal' => 'Draft Surat Kerjasama',
            'tujuan' => 'Dinas Pendidikan Banyuasin',
            'tempat_tujuan' => 'Pangkalan Balai',
            'isi_surat' => '<p>Isi draft surat penting...</p>',
            'status' => 'draft',
        ]);
        $resDraft->assertRedirect(route('admin.letters.index'));

        $draft = Letter::where('nomor_surat', '102/PWI-BA/IX/2026')->first();
        $this->assertNotNull($draft);
        $this->assertEquals('draft', $draft->status);

        // 2. Store as Published
        $resPub = $this->actingAs($admin)->post(route('admin.letters.store'), [
            'nomor_surat' => '103/PWI-PROP/IX/2026',
            'tanggal' => '2026-09-14',
            'jenis_surat' => 'PROPOSAL',
            'perihal' => 'Proposal Kemitraan Publikasi',
            'tujuan' => 'PT Semen Baturaja',
            'tempat_tujuan' => 'Palembang',
            'isi_surat' => '<p>Isi proposal kemitraan lengkap...</p>',
            'status' => 'published',
        ]);
        $resPub->assertRedirect(route('admin.letters.index'));

        $pub = Letter::where('nomor_surat', '103/PWI-PROP/IX/2026')->first();
        $this->assertNotNull($pub);
        $this->assertEquals('published', $pub->status);
    }

    public function test_can_update_letter_with_full_fields(): void
    {
        $admin = User::first();
        $letter = Letter::where('nomor_surat', '099/PWI-SK/IX/2026')->first() ?? Letter::first();

        $resUpdate = $this->actingAs($admin)->put(route('admin.letters.update', $letter->id), [
            'nomor_surat' => $letter->nomor_surat,
            'tanggal' => '2026-09-15',
            'jenis_surat' => $letter->jenis_surat,
            'perihal' => 'Perihal Terupdate',
            'tujuan' => 'Instansi Terupdate',
            'tempat_tujuan' => 'Kota Palembang',
            'isi_surat' => '<p>Konten surat yang telah diedit secara visual.</p>',
            'penandatangan_nama' => 'Wardoyo, S.I.Kom',
            'status' => 'published',
        ]);
        $resUpdate->assertRedirect(route('admin.letters.index'));

        $letter->refresh();
        $this->assertEquals('Perihal Terupdate', $letter->perihal);
        $this->assertEquals('Instansi Terupdate', $letter->tujuan);
        $this->assertEquals('Kota Palembang', $letter->tempat_tujuan);
    }
}
