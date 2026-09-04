<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Inbox;
use App\Models\Leader;
use App\Models\Letter;
use App\Models\Media;
use App\Models\Member;
use App\Models\OrganizationStructure;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    protected function ensureTablesExist(): void
    {
        if (! Schema::hasTable('posts') || ! Schema::hasTable('leaders') || ! Schema::hasTable('organization_structures')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                if (Schema::hasTable('posts') && Post::count() === 0) {
                    Artisan::call('db:seed', ['--force' => true]);
                }
            } catch (\Throwable $e) {
                // Silently ignore if artisan migrate cannot run on hosting
            }
        }
    }

    public function index()
    {
        $this->ensureTablesExist();

        // 1. Core Profile & News Data for Modern Single-Page Home
        $posts = Schema::hasTable('posts') ? Post::where('status', 'published')->latest('published_at')->take(6)->get() : collect();
        $structures = Schema::hasTable('organization_structures') ? OrganizationStructure::orderBy('urutan')->get() : collect();
        $galleries = Schema::hasTable('galleries') ? Gallery::latest('tanggal_kegiatan')->take(9)->get() : collect();
        $settings = Schema::hasTable('settings') ? Setting::pluck('value', 'key')->all() : [];

        // 2. Organization Statistics
        $ukwStats = [
            'belum_ukw' => Schema::hasTable('members') ? Member::where('status', 'aktif')->where('tingkat_ukw', 'Belum UKW')->count() : 0,
            'muda' => Schema::hasTable('members') ? Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Muda')->count() : 0,
            'madya' => Schema::hasTable('members') ? Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Madya')->count() : 0,
            'utama' => Schema::hasTable('members') ? Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Utama')->count() : 0,
            'total_aktif' => Schema::hasTable('members') ? Member::where('status', 'aktif')->count() : 0,
        ];

        $mediaCount = Schema::hasTable('media') ? Media::count() : 0;
        $newsCount = Schema::hasTable('posts') ? Post::where('status', 'published')->count() : 0;
        $galleryCount = Schema::hasTable('galleries') ? Gallery::count() : 0;

        // 3. Featured Members
        $featuredMembers = Schema::hasTable('members') ? Member::where('status', 'aktif')
            ->whereIn('jabatan', ['KETUA', 'SEKRETARIS', 'BENDAHARA', 'WAKIL KETUA I', 'WAKIL KETUA II', 'WAKIL KETUA III'])
            ->get() : collect();

        return view('public.home', compact('posts', 'structures', 'galleries', 'settings', 'ukwStats', 'mediaCount', 'newsCount', 'galleryCount', 'featuredMembers'));
    }

    public function news(Request $request)
    {
        $this->ensureTablesExist();

        if (! Schema::hasTable('posts')) {
            $posts = new LengthAwarePaginator([], 0, 9);
            $categories = [];
            $popularPosts = collect();

            return view('public.news', compact('posts', 'categories', 'popularPosts'));
        }

        $query = Post::where('status', 'published');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                    ->orWhere('konten', 'like', "%{$s}%")
                    ->orWhere('penulis', 'like', "%{$s}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(24);
        $categories = Post::where('status', 'published')->distinct()->pluck('kategori');
        $recentPosts = Post::where('status', 'published')->latest('published_at')->take(5)->get();

        return view('public.news.index', compact('posts', 'categories', 'recentPosts'));
    }

    public function newsDetail(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $this->recordPostView($post, $request);

        $relatedPosts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('kategori', $post->kategori)
            ->take(3)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::where('status', 'published')
                ->where('id', '!=', $post->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        $recentPosts = Post::where('status', 'published')->latest('published_at')->take(5)->get();

        return view('public.news.show', compact('post', 'relatedPosts', 'recentPosts'));
    }

    /**
     * Catat kunjungan pembaca autentik (anti-bot & deduplikasi sesi/IP).
     */
    protected function recordPostView(Post $post, Request $request): void
    {
        $userAgent = $request->userAgent() ?? '';

        // Abaikan web crawler, spider, dan bot pencari
        if ($this->isCrawler($userAgent)) {
            return;
        }

        $sessionKey = 'viewed_post_'.$post->id;

        // Jika sesi pengunjung sudah pernah membaca berita ini, jangan hitung ganda
        if ($request->session()->has($sessionKey)) {
            return;
        }

        $ip = $request->ip();

        // Cek apakah ada view dari IP yang sama dalam 3 jam terakhir
        $recentView = PostView::where('post_id', $post->id)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHours(3))
            ->exists();

        if (! $recentView) {
            PostView::create([
                'post_id' => $post->id,
                'ip_address' => $ip,
                'user_agent' => substr($userAgent, 0, 500),
                'session_id' => $request->session()->getId(),
            ]);

            $post->increment('views_count');
        }

        $request->session()->put($sessionKey, now()->timestamp);
    }

    /**
     * Deteksi apakah User-Agent adalah crawler / search engine bot.
     */
    protected function isCrawler(string $userAgent): bool
    {
        if (empty($userAgent)) {
            return false;
        }

        $crawlers = [
            'googlebot',
            'bingbot',
            'slurp',
            'duckduckbot',
            'baiduspider',
            'yandexbot',
            'sogou',
            'exabot',
            'facebot',
            'ia_archiver',
            'ahrefsbot',
            'semrushbot',
            'petalbot',
            'mj12bot',
            'dotbot',
            'headlesschrome',
            'lighthouse',
            'curl',
            'wget',
            'python-requests',
            'scrapy',
        ];

        $pattern = '/('.implode('|', $crawlers).')/i';

        return (bool) preg_match($pattern, $userAgent);
    }

    public function organization()
    {
        $structures = OrganizationStructure::orderBy('urutan')->get();
        $tree = OrganizationStructure::getHierarchyTree();
        $settings = Setting::pluck('value', 'key')->all();

        return view('public.organization', compact('structures', 'tree', 'settings'));
    }

    public function leaders()
    {
        if (! Schema::hasTable('leaders')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                // Ignore if migration cannot run
            }
        }

        $leaders = Schema::hasTable('leaders') ? Leader::orderBy('urutan', 'asc')->get() : collect();
        $settings = Setting::pluck('value', 'key')->all();

        return view('public.leaders', compact('leaders', 'settings'));
    }

    public function members(Request $request)
    {
        $showPublicMembers = (Setting::where('key', 'show_public_members')->value('value') ?? '0') === '1';

        $orderSql = "CASE 
            WHEN UPPER(TRIM(jabatan)) = 'KETUA' THEN 1
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKIL KETUA%' THEN 2
            WHEN UPPER(TRIM(jabatan)) = 'SEKRETARIS' THEN 3
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKIL SEKRETARIS%' THEN 4
            WHEN UPPER(TRIM(jabatan)) = 'BENDAHARA' THEN 5
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKIL BENDAHARA%' THEN 6
            WHEN UPPER(TRIM(jabatan)) LIKE 'KABID%' THEN 7
            WHEN UPPER(TRIM(jabatan)) LIKE 'WAKABID%' THEN 8
            WHEN UPPER(TRIM(jabatan)) LIKE 'ANGGOTA BID%' THEN 9
            WHEN UPPER(TRIM(jabatan)) != 'ANGGOTA' THEN 10
            ELSE 20 END";

        $query = Member::with('media')->where('status', 'aktif');

        if ($request->filled('ukw')) {
            $query->where('tingkat_ukw', $request->ukw);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu_ukw', 'like', "%{$s}%")
                    ->orWhere('jabatan', 'like', "%{$s}%")
                    ->orWhere('nama_media_custom', 'like', "%{$s}%")
                    ->orWhereHas('media', function ($mq) use ($s) {
                        $mq->where('nama_media', 'like', "%{$s}%");
                    });
            });
        }

        $members = $query->orderByRaw($orderSql)->orderBy('nama', 'asc')->paginate(12);

        $ukwStats = [
            'belum_ukw' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Belum UKW')->count(),
            'muda' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Muda')->count(),
            'madya' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Madya')->count(),
            'utama' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Utama')->count(),
        ];

        return view('public.members', compact('members', 'ukwStats', 'showPublicMembers'));
    }

    public function gallery()
    {
        $galleries = Gallery::latest('tanggal_kegiatan')->paginate(24);

        return view('public.gallery', compact('galleries'));
    }

    public function storeInbox(Request $request)
    {
        $throttleKey = 'inbox|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return redirect()->back()->with('error_inbox', "Terlalu banyak pengiriman pesan. Demi keamanan, silakan coba kembali dalam {$seconds} detik.");
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'instansi' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:100',
            'telepon' => 'nullable|string|max:30',
            'tujuan' => 'nullable|string|max:150',
            'keperluan' => 'required|string|max:200',
            'pesan' => 'required|string|max:3000',
        ]);

        RateLimiter::hit($throttleKey, 120);

        // Sanitize string inputs against XSS
        foreach ($validated as $key => $val) {
            if (is_string($val)) {
                $validated[$key] = strip_tags(trim($val));
            }
        }

        Inbox::create([
            'tanggal' => now(),
            'nama' => $validated['nama'],
            'instansi' => $validated['instansi'] ?? 'Umum / Masyarakat',
            'email' => $validated['email'] ?? null,
            'telepon' => $validated['telepon'] ?? null,
            'tujuan' => $validated['tujuan'] ?? 'PWI Kabupaten Banyuasin',
            'keperluan' => $validated['keperluan'],
            'pesan' => $validated['pesan'],
            'status' => 'baru',
        ]);

        return redirect()->back()->with('success_inbox', 'Terima kasih! Pesan buku tamu Anda telah terkirim kepada Pengurus PWI Kabupaten Banyuasin.');
    }

    public function verifyLetter(string $hash)
    {
        $letter = Letter::where('uuid', $hash)
            ->orWhere('hash_keabsahan', $hash)
            ->orWhere('nomor_surat', $hash)
            ->orWhere('id', $hash)
            ->first();

        $settings = Setting::pluck('value', 'key')->all();

        return view('public.letter_verify', compact('letter', 'hash', 'settings'));
    }
}
