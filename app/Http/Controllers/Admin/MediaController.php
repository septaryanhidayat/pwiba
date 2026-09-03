<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_media', 'like', "%{$s}%")
                  ->orWhere('website', 'like', "%{$s}%")
                  ->orWhere('alamat', 'like', "%{$s}%");
            });
        }

        $perPage = $request->get('entries', 10);
        $media = $query->orderBy('nama_media', 'asc')->paginate($perPage);
        $mediaList = $media;

        return view('admin.media.index', compact('media', 'mediaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_media' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'pimpinan_redaksi' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:100',
        ]);

        Media::create($validated);

        return redirect()->back()->with('success', 'Data media berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $validated = $request->validate([
            'nama_media' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'pimpinan_redaksi' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:100',
        ]);

        $media->update($validated);

        return redirect()->back()->with('success', 'Data media berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        return redirect()->back()->with('success', 'Data media berhasil dihapus.');
    }
}
