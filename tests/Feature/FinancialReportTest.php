<?php

namespace Tests\Feature;

use App\Models\FinancialReport;
use App\Models\FinancialReportItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinancialReportTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdmin(): User
    {
        $admin = User::first();
        if (! $admin) {
            $admin = User::factory()->create([
                'email' => 'admin@pwiba.or.id',
                'name' => 'Admin PWI Banyuasin',
            ]);
        }

        return $admin;
    }

    public function test_guest_is_redirected_to_login_when_accessing_financial_reports(): void
    {
        $response = $this->get(route('admin.financial-reports.index'));
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_financial_reports_index(): void
    {
        $admin = $this->getAdmin();

        $response = $this->actingAs($admin)->get(route('admin.financial-reports.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan Keuangan Kegiatan PWI', false);
        $response->assertSee('Total Kas Masuk', false);
        $response->assertSee('Total Kas Keluar', false);
        $response->assertSee('Saldo Akhir Akumulasi', false);
    }

    public function test_admin_can_view_create_form(): void
    {
        $admin = $this->getAdmin();

        $response = $this->actingAs($admin)->get(route('admin.financial-reports.create'));

        $response->assertStatus(200);
        $response->assertSee('Formulir Laporan Keuangan Kegiatan PWI', false);
        $response->assertSee('Penerimaan (Kas Masuk)', false);
        $response->assertSee('Pengeluaran (Kas Keluar)', false);
        $response->assertSee('Perhitungan Saldo Otomatis', false);
    }

    public function test_admin_can_store_financial_report_with_auto_calculated_totals_and_balance(): void
    {
        $admin = $this->getAdmin();

        $postData = [
            'judul_kegiatan' => 'LAPORAN PERTANGGUNGJAWABAN BIAYA DIKLAT JURNALISTIK',
            'lanjutan_nama_kegiatan' => 'ANGKATAN I PWI KABUPATEN BANYUASIN',
            'hari_tanggal' => 'Rabu, 20 Mei 2026',
            'tempat' => 'Mess Pemkab Banyuasin',
            'tempat_tanggal_ttd' => 'Pangkalan Balai, 21 Mei 2026',
            'nama_mengetahui' => 'Wardoyo, S.I.Kom',
            'jabatan_mengetahui' => 'Ketua PWI Banyuasin',
            'nama_bendahara' => 'Ridho Andi Sucipto, M.Pd',
            'jabatan_bendahara' => 'Bendahara',
            'keterangan' => 'Kwitansi asli tersimpan rapi.',
            'penerimaan' => [
                [
                    'tanggal' => '18/05/2026',
                    'uraian' => 'Kas Hibah PWI Banyuasin',
                    'jumlah' => '6.000.000',
                ],
                [
                    'tanggal' => '19/05/2026',
                    'uraian' => 'Kontribusi Peserta Diklat',
                    'jumlah' => '4.000.000',
                ],
            ],
            'pengeluaran' => [
                [
                    'tanggal' => '20/05/2026',
                    'uraian' => 'Honorarium Pemateri & Sertifikat',
                    'jumlah' => '5.000.000',
                ],
                [
                    'tanggal' => '20/05/2026',
                    'uraian' => 'Sewa Aula & Konsumsi Diklat',
                    'jumlah' => '2.500.000',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->post(route('admin.financial-reports.store'), $postData);

        $response->assertRedirect(route('admin.financial-reports.index'));

        $this->assertDatabaseHas('financial_reports', [
            'judul_kegiatan' => 'LAPORAN PERTANGGUNGJAWABAN BIAYA DIKLAT JURNALISTIK',
            'total_penerimaan' => 10000000,
            'total_pengeluaran' => 7500000,
            'saldo' => 2500000,
        ]);

        $report = FinancialReport::where('judul_kegiatan', 'LAPORAN PERTANGGUNGJAWABAN BIAYA DIKLAT JURNALISTIK')->first();
        $this->assertNotNull($report);
        $this->assertEquals(2, $report->penerimaanItems()->count());
        $this->assertEquals(2, $report->pengeluaranItems()->count());
    }

    public function test_admin_can_view_edit_form(): void
    {
        $admin = $this->getAdmin();

        $report = FinancialReport::first();
        if (! $report) {
            $report = FinancialReport::create([
                'judul_kegiatan' => 'LAPORAN UJI COBA',
                'nama_mengetahui' => 'Wardoyo, S.I.Kom',
                'jabatan_mengetahui' => 'Ketua PWI Banyuasin',
                'nama_bendahara' => 'Ridho Andi Sucipto, M.Pd',
                'jabatan_bendahara' => 'Bendahara',
                'total_penerimaan' => 1000,
                'total_pengeluaran' => 800,
                'saldo' => 200,
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.financial-reports.edit', $report->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Laporan Keuangan Kegiatan', false);
        $response->assertSee($report->judul_kegiatan, false);
    }

    public function test_admin_can_update_financial_report(): void
    {
        $admin = $this->getAdmin();

        $report = FinancialReport::create([
            'judul_kegiatan' => 'LAPORAN KEGIATAN SEBELUM UPDATE',
            'nama_mengetahui' => 'Wardoyo, S.I.Kom',
            'jabatan_mengetahui' => 'Ketua PWI Banyuasin',
            'nama_bendahara' => 'Ridho Andi Sucipto, M.Pd',
            'jabatan_bendahara' => 'Bendahara',
            'total_penerimaan' => 5000000,
            'total_pengeluaran' => 3000000,
            'saldo' => 2000000,
        ]);

        FinancialReportItem::create([
            'financial_report_id' => $report->id,
            'jenis' => 'penerimaan',
            'tanggal' => '01/01/2026',
            'uraian' => 'Kas Masuk Awal',
            'jumlah' => 5000000,
            'urutan' => 0,
        ]);

        FinancialReportItem::create([
            'financial_report_id' => $report->id,
            'jenis' => 'pengeluaran',
            'tanggal' => '02/01/2026',
            'uraian' => 'Biaya Awal',
            'jumlah' => 3000000,
            'urutan' => 0,
        ]);

        $updateData = [
            'judul_kegiatan' => 'LAPORAN KEGIATAN SETELAH UPDATE',
            'lanjutan_nama_kegiatan' => 'TEMA TERBARU REVISI',
            'hari_tanggal' => 'Sabtu, 30 Mei 2026',
            'tempat' => 'Sekretariat PWI Banyuasin',
            'tempat_tanggal_ttd' => 'Pangkalan Balai, 30 Mei 2026',
            'nama_mengetahui' => 'Wardoyo, S.I.Kom',
            'jabatan_mengetahui' => 'Ketua PWI Banyuasin',
            'nama_bendahara' => 'Ridho Andi Sucipto, M.Pd',
            'jabatan_bendahara' => 'Bendahara',
            'keterangan' => 'Telah diaudit internal.',
            'penerimaan' => [
                [
                    'tanggal' => '30/05/2026',
                    'uraian' => 'Kas Sponsor Utama',
                    'jumlah' => '12.000.000',
                ],
            ],
            'pengeluaran' => [
                [
                    'tanggal' => '30/05/2026',
                    'uraian' => 'Biaya Pelaksanaan Lengkap',
                    'jumlah' => '7.000.000',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->put(route('admin.financial-reports.update', $report->id), $updateData);

        $response->assertRedirect(route('admin.financial-reports.index'));

        $report->refresh();
        $this->assertEquals('LAPORAN KEGIATAN SETELAH UPDATE', $report->judul_kegiatan);
        $this->assertEquals(12000000, (float) $report->total_penerimaan);
        $this->assertEquals(7000000, (float) $report->total_pengeluaran);
        $this->assertEquals(5000000, (float) $report->saldo);
    }

    public function test_admin_can_view_print_layout_with_landscape_and_official_kop(): void
    {
        $admin = $this->getAdmin();

        $report = FinancialReport::first();
        if (! $report) {
            $report = FinancialReport::create([
                'judul_kegiatan' => 'LAPORAN PERTANGGUNGJAWABAN KEUANGAN RESMI',
                'lanjutan_nama_kegiatan' => 'KEGIATAN BULANAN PWI BANYUASIN',
                'hari_tanggal' => 'Senin, 10 Agustus 2026',
                'nama_mengetahui' => 'Wardoyo, S.I.Kom',
                'jabatan_mengetahui' => 'Ketua PWI Banyuasin',
                'nama_bendahara' => 'Ridho Andi Sucipto, M.Pd',
                'jabatan_bendahara' => 'Bendahara',
                'total_penerimaan' => 10,
                'total_pengeluaran' => 8,
                'saldo' => 2,
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.financial-reports.print', $report->id));

        $response->assertStatus(200);

        // Verify Landscape styling
        $response->assertSee('A4 landscape', false);
        $response->assertSee('btn-paper-a4', false);
        $response->assertSee('btn-paper-legal', false);

        // Verify Official PWI Blue KOP
        $response->assertSee('kop-header', false);
        $response->assertSee('kop-box', false);
        $response->assertSee('PERSATUAN WARTAWAN INDONESIA', false);
        $response->assertSee('PENGURUS KABUPATEN BANYUASIN', false);
        $response->assertSee('kop-divider', false);

        // Verify Side-by-Side Tables & Totals
        $response->assertSee('PENERIMAAN', false);
        $response->assertSee('PENGELUARAN', false);
        $response->assertSee('JUMLAH', false);
        $response->assertSee('SALDO', false);

        // Verify Signatures
        $response->assertSee('Mengetahui,', false);
        $response->assertSee('Wardoyo, S.I.Kom', false);
        $response->assertSee('Ridho Andi Sucipto, M.Pd', false);
        $response->assertSee('Bendahara', false);
    }

    public function test_admin_can_delete_financial_report(): void
    {
        $admin = $this->getAdmin();

        $report = FinancialReport::create([
            'judul_kegiatan' => 'LAPORAN AKAN DIHAPUS',
            'nama_mengetahui' => 'Wardoyo, S.I.Kom',
            'jabatan_mengetahui' => 'Ketua PWI Banyuasin',
            'nama_bendahara' => 'Ridho Andi Sucipto, M.Pd',
            'jabatan_bendahara' => 'Bendahara',
            'total_penerimaan' => 1000,
            'total_pengeluaran' => 500,
            'saldo' => 500,
        ]);

        $itemId = FinancialReportItem::create([
            'financial_report_id' => $report->id,
            'jenis' => 'penerimaan',
            'tanggal' => '01/01/2026',
            'uraian' => 'Uji Hapus',
            'jumlah' => 1000,
            'urutan' => 0,
        ])->id;

        $response = $this->actingAs($admin)->delete(route('admin.financial-reports.destroy', $report->id));

        $response->assertRedirect(route('admin.financial-reports.index'));

        $this->assertDatabaseMissing('financial_reports', ['id' => $report->id]);
        $this->assertDatabaseMissing('financial_report_items', ['id' => $itemId]);
    }
}
