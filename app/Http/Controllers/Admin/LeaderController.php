<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaderController extends Controller
{
    public function index(Request $request)
    {
        $query = Leader::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                    ->orWhere('jabatan', 'like', "%{$s}%")
                    ->orWhere('periode', 'like', "%{$s}%")
                    ->orWhere('keterangan', 'like', "%{$s}%");
            });
        }

        $leaders = $query->orderBy('urutan', 'asc')->paginate(15);

        return view('admin.leaders.index', compact('leaders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'periode' => 'required|string|max:100',
            'tahun_mulai' => 'nullable|integer|min:1946|max:2100',
            'tahun_selesai' => 'nullable|integer|min:1946|max:2100',
            'urutan' => 'nullable|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'keterangan' => 'nullable|string',
            'status_aktif' => 'nullable|boolean',
        ]);

        if (empty($validated['urutan'])) {
            $maxUrutan = Leader::max('urutan') ?? 0;
            $validated['urutan'] = $maxUrutan + 1;
        }

        $validated['status_aktif'] = $request->has('status_aktif');

        if ($request->hasFile('foto')) {
            $validated['foto'] = ImageService::convertToWebp($request->file('foto'), 'leaders');
        }

        Leader::create($validated);

        return redirect()->route('admin.leaders.index')
            ->with('success', 'Data Ketua dari masa ke masa berhasil ditambahkan.');
    }

    public function update(Request $request, Leader $leader)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'periode' => 'required|string|max:100',
            'tahun_mulai' => 'nullable|integer|min:1946|max:2100',
            'tahun_selesai' => 'nullable|integer|min:1946|max:2100',
            'urutan' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'keterangan' => 'nullable|string',
            'status_aktif' => 'nullable|boolean',
        ]);

        $validated['status_aktif'] = $request->has('status_aktif');

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($leader->foto && Storage::disk('public')->exists($leader->foto)) {
                Storage::disk('public')->delete($leader->foto);
            }
            $validated['foto'] = ImageService::convertToWebp($request->file('foto'), 'leaders');
        }

        $leader->update($validated);

        return redirect()->route('admin.leaders.index')
            ->with('success', 'Data Ketua dari masa ke masa berhasil diperbarui.');
    }

    public function destroy(Leader $leader)
    {
        if ($leader->foto && Storage::disk('public')->exists($leader->foto)) {
            Storage::disk('public')->delete($leader->foto);
        }

        $leader->delete();

        return redirect()->route('admin.leaders.index')
            ->with('success', 'Data Ketua dari masa ke masa berhasil dihapus.');
    }
}
