<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Member;
use App\Models\Setting;
use App\Services\DocumentConverterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $query = Letter::with('member');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat', 'like', "%{$s}%")
                    ->orWhere('tujuan', 'like', "%{$s}%")
                    ->orWhere('keperluan', 'like', "%{$s}%")
                    ->orWhere('jenis_surat', 'like', "%{$s}%")
                    ->orWhere('nama_pejabat', 'like', "%{$s}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_surat', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $totalCount = Letter::count();
        $publishedCount = Letter::where('status', '!=', 'draft')->count();
        $draftCount = Letter::where('status', 'draft')->count();

        $entries = (int) $request->get('entries', 10);
        $letters = $query->latest('tanggal')->latest('id')->paginate($entries);
        $members = Member::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.letters.index', compact('letters', 'members', 'totalCount', 'publishedCount', 'draftCount'));
    }

    public function create(Request $request)
    {
        $jenis = $request->get('jenis', 'SURAT BIASA');
        $nomorSurat = Letter::generateNomorSurat($jenis);
        $generatedNumber = $nomorSurat;
        $defaultKetua = 'Wardoyo, S.I.Kom';
        $members = Member::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.letters.create', compact('jenis', 'nomorSurat', 'generatedNumber', 'defaultKetua', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|unique:letters,nomor_surat',
            'tanggal' => 'required|date',
            'jenis_surat' => 'required|string',
            'tujuan' => 'nullable|string|max:255',
            'keperluan' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'tempat_tujuan' => 'nullable|string|max:255',
            'nama_pejabat' => 'nullable|string|max:255',
            'jabatan_pejabat' => 'nullable|string|max:255',
            'alamat_tujuan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'member_id' => 'nullable|exists:members,id',
            'isi_surat' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'nullable|string|in:draft,published',
        ]);

        $data = $request->all();
        $data['status'] = $request->input('status', 'published');
        $data['tempat_tujuan'] = $request->filled('tempat_tujuan') ? $request->tempat_tujuan : 'Di Tempat';

        // Standardize tujuan and keperluan based on letter type
        if ($request->jenis_surat === 'SURAT TUGAS') {
            $member = Member::find($request->member_id);
            $data['keperluan'] = $request->keperluan ?? 'Surat Tugas Peliputan / Kegiatan';
            $data['tujuan'] = $request->tujuan ?? ($request->lokasi ?? 'Lokasi Tugas');
        } elseif (in_array($request->jenis_surat, ['SURAT AUDENSI', 'PROPOSAL', 'SURAT BIASA'])) {
            $data['keperluan'] = $request->perihal ?? ($request->keperluan ?? $request->jenis_surat);
            $data['tujuan'] = $request->tujuan ?? ($request->jabatan_pejabat ?? ($request->nama_pejabat ?? 'Penerima'));
            $data['nama_pejabat'] = $request->nama_pejabat ?? null;
        }

        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('letters', 'public');
        }

        $letter = Letter::create($data);

        $msg = $letter->status === 'draft'
            ? "Draft surat {$letter->nomor_surat} berhasil disimpan."
            : "Surat {$letter->nomor_surat} berhasil dibuat dan dipublish.";

        return redirect()->route('admin.letters.index')->with('success', $msg);
    }

    public function edit($id)
    {
        $letter = Letter::findOrFail($id);
        $members = Member::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.letters.edit', compact('letter', 'members'));
    }

    public function update(Request $request, $id)
    {
        $letter = Letter::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|string|unique:letters,nomor_surat,'.$id,
            'tanggal' => 'required|date',
            'jenis_surat' => 'required|string',
            'tujuan' => 'nullable|string|max:255',
            'keperluan' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'tempat_tujuan' => 'nullable|string|max:255',
            'nama_pejabat' => 'nullable|string|max:255',
            'jabatan_pejabat' => 'nullable|string|max:255',
            'alamat_tujuan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'member_id' => 'nullable|exists:members,id',
            'isi_surat' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'nullable|string|in:draft,published',
        ]);

        $data = $request->all();

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        if ($request->has('tempat_tujuan') && empty($data['tempat_tujuan'])) {
            $data['tempat_tujuan'] = 'Di Tempat';
        }

        if ($request->hasFile('file_dokumen')) {
            if ($letter->file_dokumen && Storage::disk('public')->exists($letter->file_dokumen)) {
                Storage::disk('public')->delete($letter->file_dokumen);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('letters', 'public');
        }

        $letter->update($data);

        $msg = $letter->status === 'draft'
            ? 'Draft surat keluar berhasil diperbarui.'
            : 'Data surat keluar berhasil diperbarui dan dipublish.';

        return redirect()->route('admin.letters.index')->with('success', $msg);
    }

    public function toggleStatus($id)
    {
        $letter = Letter::findOrFail($id);
        $letter->status = $letter->status === 'draft' ? 'published' : 'draft';
        $letter->save();

        $msg = $letter->status === 'published'
            ? "Surat {$letter->nomor_surat} berhasil dipublish (resmi diterbitkan)."
            : "Surat {$letter->nomor_surat} berhasil dikembalikan ke status Draft.";

        return redirect()->back()->with('success', $msg);
    }

    public function destroy($id)
    {
        $letter = Letter::findOrFail($id);
        if ($letter->file_dokumen && Storage::disk('public')->exists($letter->file_dokumen)) {
            Storage::disk('public')->delete($letter->file_dokumen);
        }
        $letter->delete();

        return redirect()->route('admin.letters.index')->with('success', 'Surat berhasil dihapus.');
    }

    public function print($id)
    {
        $letter = Letter::with('member')->findOrFail($id);
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.letters.print', compact('letter', 'settings'));
    }

    /**
     * AJAX endpoint to extract metadata and preview text from uploaded Word/PDF document.
     */
    public function previewConvert(Request $request, DocumentConverterService $converter)
    {
        $request->validate([
            'file_dokumen' => 'required|file|mimes:docx,doc,pdf|max:20480',
        ]);

        $file = $request->file('file_dokumen');
        $extracted = $converter->parseDocument(
            $file->getRealPath(),
            $file->getClientOriginalExtension(),
            $file->getClientOriginalName()
        );

        if (empty($extracted['nomor_surat'])) {
            $extracted['nomor_surat'] = Letter::generateNomorSurat($extracted['jenis_surat'] ?? 'SURAT BIASA');
        }

        return response()->json([
            'success' => true,
            'message' => 'Berkas berhasil diekstrak.',
            'data' => $extracted,
        ]);
    }

    /**
     * Convert and record uploaded Word/PDF file directly into the letters table.
     */
    public function convertAndStore(Request $request, DocumentConverterService $converter)
    {
        $request->validate([
            'file_dokumen' => 'required|file|mimes:docx,doc,pdf|max:20480',
            'jenis_surat' => 'nullable|string',
            'nomor_surat' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'perihal' => 'nullable|string|max:255',
            'tujuan' => 'nullable|string|max:255',
            'nama_pejabat' => 'nullable|string|max:255',
            'tempat_tujuan' => 'nullable|string|max:255',
            'alamat_tujuan' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'isi_surat' => 'nullable|string',
            'status' => 'nullable|string|in:draft,published',
        ]);

        $file = $request->file('file_dokumen');
        $extracted = $converter->parseDocument(
            $file->getRealPath(),
            $file->getClientOriginalExtension(),
            $file->getClientOriginalName()
        );

        $jenis = $request->filled('jenis_surat') ? $request->jenis_surat : ($extracted['jenis_surat'] ?? 'SURAT BIASA');

        $nomorSurat = $request->filled('nomor_surat')
            ? $request->nomor_surat
            : (! empty($extracted['nomor_surat']) ? $extracted['nomor_surat'] : Letter::generateNomorSurat($jenis));

        // If nomor surat already exists, regenerate
        if (Letter::where('nomor_surat', $nomorSurat)->exists()) {
            $nomorSurat = Letter::generateNomorSurat($jenis);
        }

        $tanggal = $request->filled('tanggal') ? $request->tanggal : ($extracted['tanggal'] ?? date('Y-m-d'));
        $perihal = $request->filled('perihal') ? $request->perihal : ($extracted['perihal'] ?? 'Surat Administrasi / Proposal');
        $tujuan = $request->filled('tujuan') ? $request->tujuan : ($extracted['tujuan'] ?? 'Mitra / Instansi Terkait');
        $tempatTujuan = $request->filled('tempat_tujuan') ? $request->tempat_tujuan : ($extracted['tempat_tujuan'] ?? 'Di Tempat');
        $namaPejabat = $request->filled('nama_pejabat') ? $request->nama_pejabat : ($extracted['nama_pejabat'] ?? null);
        $alamatTujuan = $request->filled('alamat_tujuan') ? $request->alamat_tujuan : ($extracted['alamat_tujuan'] ?? null);
        $lampiran = $request->filled('lampiran') ? $request->lampiran : ($extracted['lampiran'] ?? ($jenis === 'PROPOSAL' ? '1 (Satu) Berkas Proposal' : '1 (Satu) Berkas'));
        $isiSurat = $request->filled('isi_surat') ? $request->isi_surat : ($extracted['isi_surat'] ?? '');
        $status = $request->input('status', 'published');

        // Store the original document in storage/letters
        $storedPath = $file->store('letters', 'public');

        $letter = Letter::create([
            'nomor_surat' => $nomorSurat,
            'tanggal' => $tanggal,
            'jenis_surat' => $jenis,
            'status' => $status,
            'perihal' => $perihal,
            'keperluan' => $perihal,
            'tujuan' => $tujuan,
            'tempat_tujuan' => $tempatTujuan,
            'nama_pejabat' => $namaPejabat,
            'alamat_tujuan' => $alamatTujuan,
            'lampiran' => $lampiran,
            'isi_surat' => $isiSurat,
            'file_dokumen' => $storedPath,
            'penandatangan_nama' => 'Wardoyo, S.I.Kom',
            'penandatangan_sekretaris' => 'Deni Arianto',
        ]);

        return redirect()->route('admin.letters.index')->with('success', "Berkas '{$file->getClientOriginalName()}' berhasil dikonversi dan tercatat sebagai Surat Keluar [{$letter->nomor_surat}]!");
    }

    /**
     * Export any stored letter or proposal as an official Microsoft Word (.docx) document.
     */
    public function exportDocx($id, DocumentConverterService $converter)
    {
        $letter = Letter::with('member')->findOrFail($id);
        $docxBinary = $converter->generateDocx($letter);

        $safeName = Str::slug($letter->nomor_surat, '_') ?: 'surat_'.$letter->id;
        $fileName = "{$safeName}.docx";

        return response($docxBinary, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Content-Length' => strlen($docxBinary),
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
