<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
}
