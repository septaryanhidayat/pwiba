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
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
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

    public function newsDetail($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $post->increment('views_count');

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

    public function organization()
    {
        $structures = OrganizationStructure::orderBy('urutan')->get();
        $settings = Setting::pluck('value', 'key')->all();

        return view('public.organization', compact('structures', 'settings'));
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
        $query = Member::with('media')->where('status', 'aktif');

        if ($request->filled('ukw')) {
            $query->where('tingkat_ukw', $request->ukw);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu', 'like', "%{$s}%")
                    ->orWhere('jabatan', 'like', "%{$s}%");
            });
        }

        $members = $query->orderBy('nama')->paginate(12);

        $ukwStats = [
            'belum_ukw' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Belum UKW')->count(),
            'muda' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Muda')->count(),
            'madya' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Madya')->count(),
            'utama' => Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Utama')->count(),
        ];

        return view('public.members', compact('members', 'ukwStats'));
    }

    public function gallery()
    {
        $galleries = Gallery::latest('tanggal_kegiatan')->paginate(24);

        return view('public.gallery', compact('galleries'));
    }

    public function storeInbox(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'tujuan' => 'nullable|string|max:255',
            'keperluan' => 'required|string|max:255',
            'pesan' => 'required|string|max:3000',
        ]);

        Inbox::create([
            'tanggal' => now(),
            'nama' => $request->nama,
            'instansi' => $request->instansi ?? 'Umum / Masyarakat',
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tujuan' => $request->tujuan ?? 'PWI Kabupaten Banyuasin',
            'keperluan' => $request->keperluan,
            'pesan' => $request->pesan,
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
