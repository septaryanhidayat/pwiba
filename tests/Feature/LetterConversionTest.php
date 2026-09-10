<?php

namespace Tests\Feature;

use App\Models\Letter;
use App\Models\User;
use App\Services\DocumentConverterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use ZipArchive;

class LetterConversionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@pwibanyuasin.org',
        ]);
    }

    /**
     * Create a dummy .docx file for testing.
     */
    protected function createDummyDocx(string $text = 'Nomor: 099/PWI-BA/IX/2026\nPerihal: Surat Uji Coba Konversi\nKepada Yth. Pimpinan BUMN\n\nDengan hormat, ini adalah isi pengujian.'): string
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'test_docx_').'.docx';
        $zip = new ZipArchive;
        $zip->open($tempPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
    <w:body>
        <w:p><w:r><w:t>'.htmlspecialchars($text, ENT_XML1).'</w:t></w:r></w:p>
    </w:body>
</w:document>';

        $zip->addFromString('word/document.xml', $xml);
        $zip->addFromString('[Content_Types].xml', '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="xml" ContentType="application/xml"/></Types>');
        $zip->close();

        return $tempPath;
    }

    public function test_letters_index_displays_conversion_button(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.letters.index'));
        $response->assertStatus(200);
        $response->assertSee('Konversi Word / PDF');
        $response->assertSee('Buku Register Surat Keluar');
    }

    public function test_document_converter_service_extracts_metadata_correctly(): void
    {
        $converter = app(DocumentConverterService::class);
        $docxPath = $this->createDummyDocx("Nomor: 101/PWI-BA/IX/2026\nPerihal: Undangan Pelatihan AI\nKepada Yth. Kepala Dinas Kominfo\n\nDengan hormat, kami mengundang bapak/ibu.");

        $data = $converter->parseDocument($docxPath, 'docx', 'undangan.docx');
        @unlink($docxPath);

        $this->assertEquals('101/PWI-BA/IX/2026', $data['nomor_surat']);
        $this->assertEquals('Undangan Pelatihan AI', $data['perihal']);
        $this->assertStringContainsString('Kepala Dinas Kominfo', $data['tujuan']);
    }

    public function test_document_converter_service_can_generate_valid_docx(): void
    {
        $letter = Letter::create([
            'nomor_surat' => '102/PWI-BA/IX/2026',
            'tanggal' => '2026-09-10',
            'jenis_surat' => 'PROPOSAL',
            'status' => 'published',
            'perihal' => 'Proposal Kegiatan Uji Coba',
            'keperluan' => 'Proposal Kegiatan Uji Coba',
            'tujuan' => 'PT Mitra Sejahtera',
            'isi_surat' => 'Latar Belakang: Uji coba sistem dokumen.',
        ]);

        $converter = app(DocumentConverterService::class);
        $docxBinary = $converter->generateDocx($letter);

        $this->assertNotEmpty($docxBinary);

        // Verify it is a valid zip with document.xml
        $tempPath = tempnam(sys_get_temp_dir(), 'test_verify_').'.docx';
        file_put_contents($tempPath, $docxBinary);

        $zip = new ZipArchive;
        $opened = $zip->open($tempPath);
        $this->assertTrue($opened === true);
        $docXml = $zip->getFromName('word/document.xml');
        $this->assertNotEmpty($docXml);
        $this->assertStringContainsString('PERSATUAN WARTAWAN INDONESIA', $docXml);
        $this->assertStringContainsString('102/PWI-BA/IX/2026', $docXml);
        $zip->close();
        @unlink($tempPath);
    }

    public function test_admin_can_export_letter_as_docx_file(): void
    {
        $letter = Letter::create([
            'nomor_surat' => '103/PWI-BA/IX/2026',
            'tanggal' => '2026-09-10',
            'jenis_surat' => 'SURAT BIASA',
            'status' => 'published',
            'perihal' => 'Pengujian Export Word',
            'keperluan' => 'Pengujian Export Word',
            'tujuan' => 'Rekan Media Banyuasin',
            'isi_surat' => 'Isi surat uji export.',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.letters.export_docx', $letter->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $this->assertStringContainsString('.docx', $response->headers->get('Content-Disposition'));
    }

    public function test_admin_can_upload_and_convert_docx_to_letter(): void
    {
        Storage::fake('public');

        $docxPath = $this->createDummyDocx("Nomor: 104/PWI-PROP/IX/2026\nPerihal: Pengajuan Kerjasama Sponsorship\nKepada Yth. Bank Sumsel Babel\n\nIsi surat kerjasama.");

        $uploadedFile = new UploadedFile(
            $docxPath,
            'Surat_Sponsorship_Bank.docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            null,
            true
        );

        $response = $this->actingAs($this->admin)->post(route('admin.letters.convert'), [
            'file_dokumen' => $uploadedFile,
            'status' => 'published',
        ]);

        @unlink($docxPath);

        $response->assertRedirect(route('admin.letters.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('letters', [
            'nomor_surat' => '104/PWI-PROP/IX/2026',
            'perihal' => 'Pengajuan Kerjasama Sponsorship',
            'status' => 'published',
        ]);

        $letter = Letter::where('nomor_surat', '104/PWI-PROP/IX/2026')->first();
        $this->assertNotNull($letter);
        $this->assertNotNull($letter->file_dokumen);
        Storage::disk('public')->assertExists($letter->file_dokumen);
    }

    public function test_preview_convert_endpoint_returns_json(): void
    {
        $docxPath = $this->createDummyDocx("Nomor: 105/PWI-PROP/IX/2026\nPerihal: Proposal Pelatihan Jurnalistik AI\nKepada Yth. Diskominfo Banyuasin\n\nIsi rincian kegiatan.");

        $uploadedFile = new UploadedFile(
            $docxPath,
            'Proposal_AI.docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            null,
            true
        );

        $response = $this->actingAs($this->admin)->post(route('admin.letters.preview_convert'), [
            'file_dokumen' => $uploadedFile,
        ], ['Accept' => 'application/json']);

        @unlink($docxPath);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'nomor_surat' => '105/PWI-PROP/IX/2026',
                'perihal' => 'Proposal Pelatihan Jurnalistik AI',
            ],
        ]);
    }

    public function test_document_converter_distinguishes_surat_biasa_from_proposal(): void
    {
        $converter = app(DocumentConverterService::class);

        // Document 1: Surat Keluar Permohonan Sponsorship
        $suratText = "Nomor : 095/PWI-BA/IX/2026\nLampiran : 1 (satu) Berkas Proposal\nPerihal : Permohonan Sponsorship / Dukungan Kerja Sama Seminar Sehari\nKepada Yth. Pemimpin Wilayah PT Pegadaian (Persero)\n\nDengan hormat,\nSeiring berkembangnya pemanfaatan kecerdasan buatan, insan pers dituntut beradaptasi. Kami bermaksud mengajukan permohonan kerjasama sponsorship.\n\nDemikian surat permohonan ini kami sampaikan.";
        $metaSurat = $converter->extractMetadata($suratText, 'surat_sponsorship.docx');

        $this->assertEquals('SURAT BIASA', $metaSurat['jenis_surat']);
        $this->assertEquals('095/PWI-BA/IX/2026', $metaSurat['nomor_surat']);
        $this->assertEquals('Permohonan Sponsorship / Dukungan Kerja Sama Seminar Sehari', $metaSurat['perihal']);
        $this->assertEquals('1 (satu) Berkas Proposal', $metaSurat['lampiran']);

        // Document 2: Berkas Proposal Kegiatan
        $proposalText = "PROPOSAL KEGIATAN SEMINAR SEHARI\n\"Jurnalisme Cerdas di Era AI: Optimalisasi Teknologi Digital untuk Produktivitas Wartawan PWI Banyuasin\"\n\nA. Latar Belakang\nPesatnya perkembangan AI telah mengubah lanskap industri media.\n\nB. Tujuan Kegiatan\nMemberikan pemahaman komprehensif.\n\nC. Pelaksanaan Kegiatan\nSeminar Sehari di Pangkalan Balai.\n\nD. Rencana Anggaran Biaya (RAB)\nTotal Anggaran: Rp 20.350.000\n\nE. Susunan Panitia Pelaksana\nKetua: Quata Akda, Narasumber: Septa Ryan Hidayat\n\nF. Penutup\nDemikian proposal ini.";
        $metaProposal = $converter->extractMetadata($proposalText, 'proposal_seminar.docx');

        $this->assertEquals('PROPOSAL', $metaProposal['jenis_surat']);
        $this->assertEquals('Proposal Kegiatan Seminar Sehari: Jurnalisme Cerdas di Era AI', $metaProposal['perihal']);
        $this->assertEquals('RAB & Susunan Panitia', $metaProposal['lampiran']);
    }

    public function test_letters_index_has_responsive_mobile_and_desktop_views(): void
    {
        Letter::create([
            'nomor_surat' => '095/PWI-BA/IX/2026',
            'tanggal' => '2026-09-10',
            'jenis_surat' => 'SURAT BIASA',
            'status' => 'published',
            'perihal' => 'Permohonan Sponsorship / Dukungan Kerja Sama Seminar Sehari',
            'keperluan' => 'Permohonan Sponsorship / Dukungan Kerja Sama Seminar Sehari',
            'tujuan' => 'Pemimpin Wilayah PT Pegadaian',
            'isi_surat' => 'Isi surat pengujian.',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.letters.index'));
        $response->assertStatus(200);

        // Check dropdown button
        $response->assertSee('+ Buat Surat Baru');
        $response->assertSee('Surat Biasa');
        $response->assertSee('Proposal Kegiatan');
        $response->assertSee('Surat Tugas');
        $response->assertSee('Surat Audiensi');

        // Check that the letter shows up
        $response->assertSee('095/PWI-BA/IX/2026');
        $response->assertSee('Permohonan Sponsorship / Dukungan Kerja Sama Seminar Sehari');
    }
}
