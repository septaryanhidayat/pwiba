<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizationStructure::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('nomor_kartu', 'like', "%{$s}%")
                  ->orWhere('jabatan', 'like', "%{$s}%")
                  ->orWhere('tingkat_ukw', 'like', "%{$s}%");
            });
        }

        $perPage = $request->get('entries', 10);
        $structures = $query->orderBy('urutan', 'asc')->paginate($perPage);
        $officials = $structures;
        $members = Member::where('status', 'aktif')->orderBy('nama', 'asc')->get();

        return view('admin.organization.index', compact('structures', 'officials', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'nama' => 'required|string|max:255',
            'nomor_kartu' => 'nullable|string|max:100',
            'tingkat_ukw' => 'nullable|string|max:100',
            'masa_berlaku' => 'nullable|date',
            'jabatan' => 'required|string|max:100',
            'urutan' => 'nullable|integer',
            'periode' => 'nullable|string|max:50',
            'status' => 'nullable|in:aktif,nonaktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'x_twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'aktif';
        }

        if (!empty($validated['member_id'])) {
            $member = Member::find($validated['member_id']);
            if ($member) {
                $validated['nama'] = $member->nama;
                $validated['nomor_kartu'] = $member->nomor_kartu;
                $validated['tingkat_ukw'] = $member->tingkat_ukw;
                $validated['masa_berlaku'] = $member->masa_berlaku;
                if (empty($validated['foto']) && $member->foto) {
                    $validated['foto'] = $member->foto;
                }
            }
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('organization', 'public');
            $validated['foto'] = $path;
        }

        if (empty($validated['urutan'])) {
            $maxUrutan = OrganizationStructure::max('urutan') ?? 0;
            $validated['urutan'] = $maxUrutan + 1;
        }

        OrganizationStructure::create($validated);

        return redirect()->back()->with('success', 'Data pengurus organisasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $official = OrganizationStructure::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_kartu' => 'nullable|string|max:100',
            'tingkat_ukw' => 'nullable|string|max:100',
            'masa_berlaku' => 'nullable|date',
            'jabatan' => 'required|string|max:100',
            'urutan' => 'nullable|integer',
            'periode' => 'nullable|string|max:50',
            'status' => 'nullable|in:aktif,nonaktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'x_twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            if ($official->foto && Storage::disk('public')->exists($official->foto)) {
                Storage::disk('public')->delete($official->foto);
            }
            $path = $request->file('foto')->store('organization', 'public');
            $validated['foto'] = $path;
        }

        $official->update($validated);

        return redirect()->back()->with('success', 'Data pengurus organisasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $official = OrganizationStructure::findOrFail($id);
        if ($official->foto && Storage::disk('public')->exists($official->foto)) {
            Storage::disk('public')->delete($official->foto);
        }
        $official->delete();

        return redirect()->back()->with('success', 'Data pengurus berhasil dihapus.');
    }
}
