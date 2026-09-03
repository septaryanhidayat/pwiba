<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomingLetter;
use Illuminate\Http\Request;

class IncomingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingLetter::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat', 'like', "%{$s}%")
                    ->orWhere('pengirim', 'like', "%{$s}%")
                    ->orWhere('perihal', 'like', "%{$s}%");
            });
        }

        $entries = (int) $request->get('entries', 10);
        $letters = $query->latest('tanggal_diterima')->paginate($entries);

        return view('admin.incoming-letters.index', compact('letters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'status_disposisi' => 'nullable|string|max:100',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'nomor_surat', 'tanggal_surat', 'tanggal_diterima',
            'pengirim', 'perihal', 'isi_ringkas', 'status_disposisi',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('incoming_letters', 'public');
        }

        IncomingLetter::create($data);

        return redirect()->route('admin.incoming-letters.index')->with('success', 'Surat masuk berhasil dicatat ke dalam sistem.');
    }

    public function update(Request $request, $id)
    {
        $letter = IncomingLetter::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'status_disposisi' => 'nullable|string|max:100',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'nomor_surat', 'tanggal_surat', 'tanggal_diterima',
            'pengirim', 'perihal', 'isi_ringkas', 'status_disposisi',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('incoming_letters', 'public');
        }

        $letter->update($data);

        return redirect()->route('admin.incoming-letters.index')->with('success', 'Data surat masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $letter = IncomingLetter::findOrFail($id);
        $letter->delete();

        return redirect()->route('admin.incoming-letters.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}
