<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChairmanPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ChairmanPostController extends Controller
{
    /**
     * Memastikan tabel dan basis data artikel karya ketua siap digunakan.
     */
    protected function ensureTableAndDataReady(): void
    {
        if (! Schema::hasTable('chairman_posts')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                // Ignore if migration fails
            }
        }

        if (Schema::hasTable('chairman_posts')) {
            try {
                if (ChairmanPost::count() === 0) {
                    $jsonFile = database_path('data/wardianst_posts.json');
                    if (File::exists($jsonFile)) {
                        $posts = json_decode(File::get($jsonFile), true);
                        if (is_array($posts) && count($posts) > 0) {
                            foreach (array_chunk($posts, 50) as $chunk) {
                                $cleanChunk = array_map(function ($item) {
                                    unset($item['id']);
                                    $item['published_at'] = ! empty($item['published_at']) ? date('Y-m-d H:i:s', strtotime($item['published_at'])) : date('Y-m-d H:i:s');
                                    $item['created_at'] = ! empty($item['created_at']) ? date('Y-m-d H:i:s', strtotime($item['created_at'])) : date('Y-m-d H:i:s');
                                    $item['updated_at'] = ! empty($item['updated_at']) ? date('Y-m-d H:i:s', strtotime($item['updated_at'])) : date('Y-m-d H:i:s');
                                    $item['reading_time'] = (int) ($item['reading_time'] ?? 3);
                                    $item['views_count'] = (int) ($item['views_count'] ?? 0);

                                    return $item;
                                }, $chunk);

                                ChairmanPost::insert($cleanChunk);
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Abaikan jika seeding otomatis belum berjalan
            }
        }
    }

    /**
     * Menampilkan daftar arsip karya tulis ketua dengan pencarian, filter kategori, dan statistik.
     */
    public function index(Request $request): View
    {
        $this->ensureTableAndDataReady();

        $query = ChairmanPost::query();

        // Pencarian teks
        if ($request->filled('search')) {
            $term = trim($request->search);
            $query->search($term);
        }

        // Filter kategori
        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->category($request->category);
        }

        // Filter tahun
        if ($request->filled('year') && $request->year !== 'Semua') {
            $query->whereYear('published_at', (int) $request->year);
        }

        $perPage = (int) $request->get('entries', 15);
        if (! in_array($perPage, [10, 15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate($perPage)->withQueryString();

        // Statistik dan data pembantu
        $totalPosts = ChairmanPost::count();
        $totalViews = ChairmanPost::sum('views_count');
        $categories = ChairmanPost::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category', 'asc')
            ->pluck('category');

        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $yearSql = $isSqlite ? "strftime('%Y', published_at)" : 'YEAR(published_at)';
        $years = ChairmanPost::selectRaw("DISTINCT {$yearSql} as yr")
            ->whereNotNull('published_at')
            ->orderBy('yr', 'desc')
            ->pluck('yr')
            ->filter();

        return view('admin.chairman_posts.index', compact(
            'posts',
            'totalPosts',
            'totalViews',
            'categories',
            'years'
        ));
    }

    /**
     * Menampilkan formulir penulisan arsip karya ketua baru.
     */
    public function create(): View
    {
        $this->ensureTableAndDataReady();

        $existingCategories = ChairmanPost::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category', 'asc')
            ->pluck('category');

        return view('admin.chairman_posts.create', compact('existingCategories'));
    }

    /**
     * Menyimpan data karya tulis baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->ensureTableAndDataReady();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'reading_time' => 'nullable|integer|min:1|max:120',
            'original_url' => 'nullable|url|max:500',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category.required' => 'Kategori artikel wajib ditentukan.',
            'content.required' => 'Konten lengkap artikel wajib diisi.',
        ]);

        // Auto-generate slug unik
        $baseSlug = Str::slug($validated['title']);
        if (blank($baseSlug)) {
            $baseSlug = 'tulisan-ketua';
        }
        $slug = $baseSlug.'-'.Str::random(5);
        while (ChairmanPost::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.Str::random(5);
        }
        $validated['slug'] = $slug;

        // Auto calculate reading time jika tidak diisi
        if (empty($validated['reading_time'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $validated['reading_time'] = max(1, (int) ceil($wordCount / 200));
        }

        // Auto excerpt jika tidak diisi
        if (empty($validated['excerpt'])) {
            $plain = strip_tags($validated['content']);
            $validated['excerpt'] = Str::limit($plain, 180);
        }

        // Format published_at
        if (! empty($validated['published_at'])) {
            $validated['published_at'] = Carbon::parse($validated['published_at'])->format('Y-m-d H:i:s');
        } else {
            $validated['published_at'] = now()->format('Y-m-d H:i:s');
        }

        ChairmanPost::create($validated);

        return redirect()->route('admin.chairman_posts.index')
            ->with('success', 'Karya/tulisan Ketua berhasil ditambahkan ke dalam arsip digital.');
    }

    /**
     * Menampilkan formulir sunting artikel karya ketua.
     */
    public function edit(int $id): View
    {
        $this->ensureTableAndDataReady();

        $post = ChairmanPost::findOrFail($id);

        $existingCategories = ChairmanPost::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category', 'asc')
            ->pluck('category');

        return view('admin.chairman_posts.edit', compact('post', 'existingCategories'));
    }

    /**
     * Memperbarui data karya tulis ketua.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->ensureTableAndDataReady();

        $post = ChairmanPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'reading_time' => 'nullable|integer|min:1|max:120',
            'original_url' => 'nullable|url|max:500',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category.required' => 'Kategori artikel wajib ditentukan.',
            'content.required' => 'Konten lengkap artikel wajib diisi.',
        ]);

        // Auto calculate reading time jika tidak diisi
        if (empty($validated['reading_time'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $validated['reading_time'] = max(1, (int) ceil($wordCount / 200));
        }

        // Auto excerpt jika tidak diisi
        if (empty($validated['excerpt'])) {
            $plain = strip_tags($validated['content']);
            $validated['excerpt'] = Str::limit($plain, 180);
        }

        // Format published_at
        if (! empty($validated['published_at'])) {
            $validated['published_at'] = Carbon::parse($validated['published_at'])->format('Y-m-d H:i:s');
        }

        $post->update($validated);

        return redirect()->route('admin.chairman_posts.index')
            ->with('success', 'Perubahan pada karya/tulisan Ketua berhasil disimpan.');
    }

    /**
     * Menghapus artikel karya tulis ketua dari arsip.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->ensureTableAndDataReady();

        $post = ChairmanPost::findOrFail($id);
        $title = $post->title;
        $post->delete();

        return redirect()->route('admin.chairman_posts.index')
            ->with('success', "Karya tulis '{$title}' berhasil dihapus dari arsip.");
    }
}
