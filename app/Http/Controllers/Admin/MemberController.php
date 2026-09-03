<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Member;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::where('status', 'aktif')->with('media');

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
        $members = $query->orderBy('nama', 'asc')->paginate($perPage);
        $mediaList = Media::orderBy('nama_media', 'asc')->get();

        return view('admin.members.index', compact('members', 'mediaList'));
    }

    public function inactive(Request $request)
    {
        $query = Member::where('status', 'tidak_aktif')->with('media');

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
        $members = $query->orderBy('nama', 'asc')->paginate($perPage);
        $mediaList = Media::orderBy('nama_media', 'asc')->get();

        return view('admin.members.inactive', compact('members', 'mediaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_kartu' => 'nullable|string|max:100',
            'tingkat_ukw' => 'required|in:Belum UKW,Wartawan Muda,Wartawan Madya,Wartawan Utama',
            'masa_berlaku' => 'nullable|date',
            'jabatan' => 'required|string|max:100',
            'media_id' => 'nullable|exists:media,id',
            'nama_media_custom' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('foto')) {
            $path = ImageService::uploadAndConvertToWebp($request->file('foto'), 'members');
            $validated['foto'] = $path;
        }

        Member::create($validated);

        return redirect()->back()->with('success', 'Data wartawan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_kartu' => 'nullable|string|max:100',
            'tingkat_ukw' => 'required|in:Belum UKW,Wartawan Muda,Wartawan Madya,Wartawan Utama',
            'masa_berlaku' => 'nullable|date',
            'jabatan' => 'required|string|max:100',
            'media_id' => 'nullable|exists:media,id',
            'nama_media_custom' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('foto')) {
            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }
            $path = ImageService::uploadAndConvertToWebp($request->file('foto'), 'members');
            $validated['foto'] = $path;
        }

        $member->update($validated);

        return redirect()->back()->with('success', 'Data wartawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            Storage::disk('public')->delete($member->foto);
        }
        $member->delete();

        return redirect()->back()->with('success', 'Data wartawan berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $member = Member::findOrFail($id);
        $member->status = $member->status === 'aktif' ? 'tidak_aktif' : 'aktif';
        $member->save();

        $msg = $member->status === 'aktif' ? 'Wartawan berhasil diaktifkan kembali.' : 'Wartawan berhasil dipindahkan ke daftar tidak aktif.';

        return redirect()->back()->with('success', $msg);
    }
}
