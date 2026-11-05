<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\FinancialReportItem;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinancialReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = FinancialReport::withCount('items');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul_kegiatan', 'like', "%{$s}%")
                    ->orWhere('lanjutan_nama_kegiatan', 'like', "%{$s}%")
                    ->orWhere('hari_tanggal', 'like', "%{$s}%")
                    ->orWhere('nama_bendahara', 'like', "%{$s}%");
            });
        }

        $entries = (int) $request->get('entries', 10);
        $reports = $query->latest()->paginate($entries);

        $totalKasMasuk = (float) FinancialReport::sum('total_penerimaan');
        $totalKasKeluar = (float) FinancialReport::sum('total_pengeluaran');
        $totalSaldoAkumulasi = (float) FinancialReport::sum('saldo');

        return view('admin.financial_reports.index', compact(
            'reports',
            'totalKasMasuk',
            'totalKasKeluar',
            'totalSaldoAkumulasi'
        ));
    }

    public function create(): View
    {
        $defaultTtdDate = 'Pangkalan Balai, '.now()->translatedFormat('d F Y');

        return view('admin.financial_reports.create', compact('defaultTtdDate'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'lanjutan_nama_kegiatan' => 'nullable|string|max:255',
            'hari_tanggal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'tempat_tanggal_ttd' => 'nullable|string|max:255',
            'nama_mengetahui' => 'required|string|max:255',
            'jabatan_mengetahui' => 'required|string|max:255',
            'nama_bendahara' => 'required|string|max:255',
            'jabatan_bendahara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'penerimaan' => 'nullable|array',
            'pengeluaran' => 'nullable|array',
        ]);

        $report = new FinancialReport($request->only([
            'judul_kegiatan',
            'lanjutan_nama_kegiatan',
            'hari_tanggal',
            'tempat',
            'tempat_tanggal_ttd',
            'nama_mengetahui',
            'jabatan_mengetahui',
            'nama_bendahara',
            'jabatan_bendahara',
            'keterangan',
        ]));

        $report->total_penerimaan = 0;
        $report->total_pengeluaran = 0;
        $report->saldo = 0;
        $report->save();

        $this->saveItems($report, $request->input('penerimaan', []), 'penerimaan');
        $this->saveItems($report, $request->input('pengeluaran', []), 'pengeluaran');

        $report->recalculateTotals();

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan keuangan kegiatan berhasil dibuat.');
    }

    public function show(int|string $id): View
    {
        return $this->print($id);
    }

    public function edit(int|string $id): View
    {
        $report = FinancialReport::with('items')->findOrFail($id);
        $penerimaanItems = $report->penerimaanItems;
        $pengeluaranItems = $report->pengeluaranItems;

        return view('admin.financial_reports.edit', compact('report', 'penerimaanItems', 'pengeluaranItems'));
    }

    public function update(Request $request, int|string $id): RedirectResponse
    {
        $report = FinancialReport::findOrFail($id);

        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'lanjutan_nama_kegiatan' => 'nullable|string|max:255',
            'hari_tanggal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'tempat_tanggal_ttd' => 'nullable|string|max:255',
            'nama_mengetahui' => 'required|string|max:255',
            'jabatan_mengetahui' => 'required|string|max:255',
            'nama_bendahara' => 'required|string|max:255',
            'jabatan_bendahara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'penerimaan' => 'nullable|array',
            'pengeluaran' => 'nullable|array',
        ]);

        $report->update($request->only([
            'judul_kegiatan',
            'lanjutan_nama_kegiatan',
            'hari_tanggal',
            'tempat',
            'tempat_tanggal_ttd',
            'nama_mengetahui',
            'jabatan_mengetahui',
            'nama_bendahara',
            'jabatan_bendahara',
            'keterangan',
        ]));

        // Refresh items
        $report->items()->delete();
        $this->saveItems($report, $request->input('penerimaan', []), 'penerimaan');
        $this->saveItems($report, $request->input('pengeluaran', []), 'pengeluaran');

        $report->recalculateTotals();

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    public function destroy(int|string $id): RedirectResponse
    {
        $report = FinancialReport::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan keuangan berhasil dihapus.');
    }

    public function print(int|string $id): View
    {
        $report = FinancialReport::with('items')->findOrFail($id);
        $settings = Setting::pluck('value', 'key')->all();

        $penerimaan = $report->penerimaanItems;
        $pengeluaran = $report->pengeluaranItems;

        // Balance row count so side-by-side rows align nicely
        $maxRows = max($penerimaan->count(), $pengeluaran->count(), 1);

        return view('admin.financial_reports.print', compact(
            'report',
            'settings',
            'penerimaan',
            'pengeluaran',
            'maxRows'
        ));
    }

    /**
     * Helper to parse and persist items from form input.
     *
     * @param  array<int, array<string, mixed>>  $rawItems
     */
    protected function saveItems(FinancialReport $report, array $rawItems, string $jenis): void
    {
        $order = 0;
        foreach ($rawItems as $item) {
            $uraian = trim($item['uraian'] ?? '');
            if ($uraian === '') {
                continue;
            }

            // Clean number input (handle strings like "100.000", "Rp 50,000", etc.)
            $jumlahRaw = $item['jumlah'] ?? 0;
            if (is_string($jumlahRaw)) {
                $cleaned = preg_replace('/[^0-9]/', '', $jumlahRaw);
                $jumlah = $cleaned !== '' ? (float) $cleaned : 0;
            } else {
                $jumlah = (float) $jumlahRaw;
            }

            FinancialReportItem::create([
                'financial_report_id' => $report->id,
                'jenis' => $jenis,
                'tanggal' => trim($item['tanggal'] ?? ''),
                'uraian' => $uraian,
                'jumlah' => $jumlah,
                'urutan' => $order++,
            ]);
        }
    }
}
