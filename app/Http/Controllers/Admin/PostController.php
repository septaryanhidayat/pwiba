<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function publishIndex(Request $request)
    {
        $query = Post::where('status', 'published');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                    ->orWhere('penulis', 'like', "%{$s}%")
                    ->orWhere('kategori', 'like', "%{$s}%");
            });
        }

        $perPage = $request->get('entries', 10);
        $posts = $query->orderBy('published_at', 'desc')->paginate($perPage);

        return view('admin.posts.index', compact('posts'));
    }

    public function draftIndex(Request $request)
    {
        $query = Post::where('status', 'draft');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                    ->orWhere('penulis', 'like', "%{$s}%")
                    ->orWhere('kategori', 'like', "%{$s}%");
            });
        }

        $perPage = $request->get('entries', 10);
        $posts = $query->orderBy('updated_at', 'desc')->paginate($perPage);

        return view('admin.posts.draft', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'penulis' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $validated['slug'] = Str::slug($validated['judul']).'-'.Str::random(5);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            $path = ImageService::uploadAndConvertToWebp($request->file('gambar'), 'posts');
            $validated['gambar'] = $path;
        }

        Post::create($validated);

        $route = $validated['status'] === 'published' ? 'admin.posts.publish' : 'admin.posts.draft';

        return redirect()->route($route)->with('success', 'Berita berhasil disimpan.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'penulis' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        if ($post->status === 'draft' && $validated['status'] === 'published' && empty($post->published_at)) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
                Storage::disk('public')->delete($post->gambar);
            }
            $path = ImageService::uploadAndConvertToWebp($request->file('gambar'), 'posts');
            $validated['gambar'] = $path;
        }

        $post->update($validated);

        $route = $post->status === 'published' ? 'admin.posts.publish' : 'admin.posts.draft';

        return redirect()->route($route)->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
            Storage::disk('public')->delete($post->gambar);
        }
        $status = $post->status;
        $post->delete();

        $route = $status === 'published' ? 'admin.posts.publish' : 'admin.posts.draft';

        return redirect()->route($route)->with('success', 'Berita berhasil dihapus.');
    }

    public function togglePublish($id)
    {
        $post = Post::findOrFail($id);
        if ($post->status === 'draft') {
            $post->status = 'published';
            if (! $post->published_at) {
                $post->published_at = now();
            }
            $msg = 'Berita berhasil dipublikasikan.';
        } else {
            $post->status = 'draft';
            $msg = 'Berita dipindahkan ke draf.';
        }
        $post->save();

        return redirect()->back()->with('success', $msg);
    }
}
