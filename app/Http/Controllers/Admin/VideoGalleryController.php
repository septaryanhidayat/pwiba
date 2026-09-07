<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoGalleryController extends Controller
{
    public function index(Request $request): View
    {
        $query = VideoGallery::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                    ->orWhere('deskripsi', 'like', "%{$s}%");
            });
        }

        $perPage = (int) $request->get('entries', 12);
        $videos = $query->orderBy('urutan', 'asc')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return view('admin.video_galleries.index', compact('videos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'youtube_url' => 'required|string|url',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $youtubeId = VideoGallery::extractYoutubeId($validated['youtube_url']);
        if (! $youtubeId) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['youtube_url' => 'Format link YouTube tidak valid. Mohon masukkan link video YouTube yang valid.']);
        }

        $ytData = VideoGallery::fetchYoutubeData($validated['youtube_url']);

        // Judul diambil otomatis dari YouTube jika tidak diisi secara manual
        if (empty($validated['judul'])) {
            $validated['judul'] = $ytData['title'] ?? 'Video Kegiatan PWI Banyuasin';
        }

        $validated['youtube_id'] = $youtubeId;
        $validated['thumbnail_url'] = $ytData['thumbnail_url'] ?? "https://i.ytimg.com/vi/{$youtubeId}/hqdefault.jpg";
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['tanggal'] = $validated['tanggal'] ?? now()->toDateString();

        VideoGallery::create($validated);

        return redirect()->back()->with('success', 'Video galeri berhasil ditambahkan.');
    }

    public function update(Request $request, int|string $id): RedirectResponse
    {
        $video = VideoGallery::findOrFail($id);

        $validated = $request->validate([
            'youtube_url' => 'required|string|url',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $youtubeId = VideoGallery::extractYoutubeId($validated['youtube_url']);
        if (! $youtubeId) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['youtube_url' => 'Format link YouTube tidak valid.']);
        }

        $validated['youtube_id'] = $youtubeId;
        if ($video->youtube_url !== $validated['youtube_url'] || empty($video->thumbnail_url)) {
            $ytData = VideoGallery::fetchYoutubeData($validated['youtube_url']);
            $validated['thumbnail_url'] = $ytData['thumbnail_url'] ?? "https://i.ytimg.com/vi/{$youtubeId}/hqdefault.jpg";
        }

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $video->update($validated);

        return redirect()->back()->with('success', 'Data video galeri berhasil diperbarui.');
    }

    public function destroy(int|string $id): RedirectResponse
    {
        $video = VideoGallery::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'Video galeri berhasil dihapus.');
    }

    /**
     * AJAX endpoint to fetch title and thumbnail live directly from YouTube oEmbed API.
     */
    public function fetchInfo(Request $request): JsonResponse
    {
        $url = $request->query('url');
        if (! $url || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['success' => false, 'message' => 'URL tidak valid'], 422);
        }

        $youtubeId = VideoGallery::extractYoutubeId($url);
        if (! $youtubeId) {
            return response()->json(['success' => false, 'message' => 'Link bukan video YouTube yang valid'], 422);
        }

        $data = VideoGallery::fetchYoutubeData($url);
        $title = $data['title'] ?? null;
        $thumbnail = $data['thumbnail_url'] ?? "https://i.ytimg.com/vi/{$youtubeId}/hqdefault.jpg";

        return response()->json([
            'success' => true,
            'youtube_id' => $youtubeId,
            'title' => $title,
            'thumbnail_url' => $thumbnail,
            'author_name' => $data['author_name'] ?? null,
        ]);
    }
}
