<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;

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

        $entries = (int) $request->get('entries', 10);
        $letters = $query->latest('tanggal')->paginate($entries);
        $members = Member::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.letters.index', compact('letters', 'members'));
    }

    public function create(Request $request)
    {
        $jenis = $request->get('jenis', 'SURAT BIASA');
        $nomorSurat = Letter::generateNomorSurat($jenis);
        $members = Member::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.letters.create', compact('jenis', 'nomorSurat', 'members'));
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
        ]);

        $data = $request->all();

        // Standardize tujuan and keperluan based on letter type
        if ($request->jenis_surat === 'SURAT TUGAS') {
            $member = Member::find($request->member_id);
            $data['keperluan'] = $request->keperluan ?? 'Surat Tugas Peliputan / Kegiatan';
            $data['tujuan'] = $request->tujuan ?? ($request->lokasi ?? 'Lokasi Tugas');
        } elseif (in_array($request->jenis_surat, ['SURAT AUDENSI', 'PROPOSAL', 'SURAT BIASA'])) {
            $data['keperluan'] = $request->perihal ?? ($request->keperluan ?? $request->jenis_surat);
            $data['tujuan'] = $request->nama_pejabat ? ($request->nama_pejabat.($request->jabatan_pejabat ? ' ('.$request->jabatan_pejabat.')' : '')) : ($request->tujuan ?? 'Penerima');
        }

        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('letters', 'public');
        }

        $letter = Letter::create($data);

        return redirect()->route('admin.letters.index')->with('success', "Surat {$letter->nomor_surat} berhasil dibuat.");
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
            'nama_pejabat' => 'nullable|string|max:255',
            'jabatan_pejabat' => 'nullable|string|max:255',
            'alamat_tujuan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'member_id' => 'nullable|exists:members,id',
            'isi_surat' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('letters', 'public');
        }

        $letter->update($data);

        return redirect()->route('admin.letters.index')->with('success', 'Data surat keluar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $letter = Letter::findOrFail($id);
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
