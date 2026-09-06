<?php

namespace App\Http\Controllers;

use App\Models\ChairmanPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ChairmanArchiveController extends Controller
{
    /**
     * Pastikan tabel dan data dasar chairman_posts tersedia
     * Aman untuk hosting cPanel / shared hosting tanpa akses terminal SSH
     */
    protected function ensureTableExists(): void
    {
        if (! Schema::hasTable('chairman_posts')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                // Abaikan jika migrasi gagal
            }
        }

        if (Schema::hasTable('chairman_posts')) {
            try {
                if (ChairmanPost::count() === 0) {
                    $jsonFile = database_path('data/wardianst_posts.json');
                    if (file_exists($jsonFile)) {
                        $posts = json_decode(file_get_contents($jsonFile), true);
                        if (is_array($posts) && count($posts) > 0) {
                            foreach (array_chunk($posts, 50) as $chunk) {
                                $cleanChunk = array_map(function ($item) {
                                    unset($item['id']);
                                    $item['published_at'] = isset($item['published_at']) ? date('Y-m-d H:i:s', strtotime($item['published_at'])) : date('Y-m-d H:i:s');
                                    $item['created_at'] = isset($item['created_at']) ? date('Y-m-d H:i:s', strtotime($item['created_at'])) : date('Y-m-d H:i:s');
                                    $item['updated_at'] = isset($item['updated_at']) ? date('Y-m-d H:i:s', strtotime($item['updated_at'])) : date('Y-m-d H:i:s');
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
     * Profil lengkap dan rekam jejak resmi Wardoyo, S.I.Kom.
     */
    protected function getChairmanProfile(): array
    {
        return [
            'name' => 'Wardoyo, S.I.Kom.',
            'title' => 'Ketua PWI Kabupaten Banyuasin (Periode 2025–2028)',
            'foto_url' => asset('assets/images/pengurus/pengurus_inti_1_wardoyo.webp'),
            'sk_resmi' => 'SK PWI Pusat Nomor: 033/PP-PWI/XI/2025',
            'ttl' => 'Sragen (Jawa Tengah), 17 Februari 1976',
            'agama' => 'Islam',
            'keluarga' => [
                'istri' => 'Ny. Darmini, A.Md. (Alumni Universitas Bina Darma Palembang)',
                'tanggal_nikah' => '18 Desember 2007',
                'anak' => [
                    'Aulia Tika Wardani (Tika) - Lahir 20 November 2008',
                    'Muhammad Ali Wardana (Ardan) - Lahir 20 Maret 2013',
                    'Muhammad Alfadilan Wardoyo (Dilan) - Lahir 15 Maret 2023',
                ],
            ],
            'alamat' => 'Komplek Tanah Mas Azhar Permai, Blok F2 No. 8, Kelurahan Tanah Mas, Kec. Talang Kelapa, Kabupaten Banyuasin, Sumatera Selatan',
            'kontak' => [
                'telepon' => '0853-7799-1976',
                'email' => 'wardianstp@gmail.com',
                'facebook' => 'https://www.facebook.com/ward.wardoyo',
                'blog_asli' => 'https://wardianst.wordpress.com/',
            ],
            'pendidikan' => [
                ['tingkat' => 'S2 (Magister)', 'instansi' => 'STISIPOL Candradimuka Palembang', 'prodi' => 'Magister Ilmu Komunikasi (Konsentrasi Komunikasi Politik)'],
                ['tingkat' => 'S1 (Sarjana)', 'instansi' => 'STISIPOL Candradimuka Palembang', 'prodi' => 'Ilmu Komunikasi (Program Studi Ilmu Jurnalistik)'],
                ['tingkat' => 'Diploma', 'instansi' => 'Universitas Bina Darma Palembang', 'prodi' => 'Teknik Komputer'],
                ['tingkat' => 'SMA', 'instansi' => 'SMA YP Mantra Mariana Banyuasin', 'prodi' => 'Jurusan Biologi (A2)'],
                ['tingkat' => 'SMP', 'instansi' => 'SMP Negeri 3 Banyuasin', 'prodi' => 'Pendidikan Dasar'],
                ['tingkat' => 'SD', 'instansi' => 'SD Negeri 1 Sumber Rejo', 'prodi' => 'Kecamatan Pulau Rimau'],
            ],
            'sertifikasi' => [
                [
                    'bidang' => 'Uji Kompetensi Wartawan (UKW) Tingkat Utama',
                    'penerbit' => 'Dewan Pers & PWI Pusat',
                    'nomor' => '1231-PWI/WU/DP/XII/2018/17/02/76',
                    'penguji' => 'Aat Surya Safaat (Mantan Kepala Biro LKBN ANTARA di New York, Direktur UKW PWI Pusat)',
                    'tahun' => 'Lulus 2018',
                ],
                [
                    'bidang' => 'Sekolah Jurnalisme Indonesia (SJI)',
                    'penerbit' => 'Dewan Pers - PWI Angkatan III Palembang',
                    'tahun' => '2011',
                    'keterangan' => 'Sertifikasi kompetensi standar industri media',
                ],
                [
                    'bidang' => 'Pelatihan Peliputan Investigasi',
                    'penerbit' => 'Komisi Pemberantasan Korupsi (KPK)',
                    'tahun' => '2014',
                    'keterangan' => 'Pelatihan investigasi tindak pidana korupsi untuk jurnalis',
                ],
                [
                    'bidang' => 'Lokakarya Wartawan "Meliput Perubahan Iklim"',
                    'penerbit' => 'Lembaga Pers Dr. Soetomo (LPDS) & Kedutaan Norwegia',
                    'tahun' => '2012',
                    'keterangan' => 'Pelatihan liputan lingkungan hidup dan perubahan iklim',
                ],
                [
                    'bidang' => 'Diseminasi Pedoman Peliputan Terorisme',
                    'penerbit' => 'BNPT & Forum Koordinasi Pencegahan Terorisme Sumsel',
                    'tahun' => '2016',
                    'keterangan' => 'Peningkatan profesionalisme pers dalam peliputan isu terorisme',
                ],
                [
                    'bidang' => 'Fellowship Jurnalisme Perubahan Perilaku (FJPP)',
                    'penerbit' => 'Satgas Penanganan COVID-19 & Dewan Pers',
                    'tahun' => '2020–2021',
                    'keterangan' => 'Menghasilkan 157 karya berita advokasi kesehatan publik',
                ],
                [
                    'bidang' => 'Akreditasi Pemantau Pemilu MAPPILU PWI',
                    'penerbit' => 'BAWASLU Republik Indonesia',
                    'nomor' => '034/BAWASLU/II/2019',
                    'tahun' => '2019',
                ],
            ],
            'organisasi' => [
                ['posisi' => 'Ketua PWI Kabupaten Banyuasin', 'masa' => '2025 – 2028', 'ket' => 'Berdasarkan SK PWI Pusat Nomor: 033/PP-PWI/XI/2025'],
                ['posisi' => 'Anggota Dewan Kehormatan & Profesi (DKP) PWI Sumsel', 'masa' => '2024 – 2029', 'ket' => 'SK PWI Pusat No. 356-PGS/PP-PWI/2025 (Mengundurkan diri pasca terpilih Ketua PWI Banyuasin)'],
                ['posisi' => 'Ketua MAPPILU PWI Kabupaten Banyuasin', 'masa' => '2018 – 2023', 'ket' => 'Masyarakat dan Pers Pemantau Pemilu PWI'],
                ['posisi' => 'Pemimpin Redaksi Buana Indonesia', 'masa' => '2015 – Sekarang', 'ket' => 'Media Berita Online Nasional & Regional'],
                ['posisi' => 'Komisaris PT Buana Indonesia Media', 'masa' => '2015 – Sekarang', 'ket' => 'Badan Hukum Pers Nomor: AHU-0008788.AH.01.01 Tahun 2015'],
                ['posisi' => 'Ketua ASPEKINDO Kabupaten Banyuasin', 'masa' => '2024 – 2029', 'ket' => 'Asosiasi Pengusaha Konstruksi Indonesia (SK 345/KPTS/DPN-ASPEKINDO/V/2024)'],
                ['posisi' => 'Ketua HIMSSI Kabupaten Banyuasin', 'masa' => '2022 – 2026', 'ket' => 'Himpunan Seni Silat Indonesia (SK Nomor: 01/SK/DP HIMSSI/VII/2022)'],
                ['posisi' => 'Wakil Ketua APPSI Kabupaten Banyuasin', 'masa' => '2026 – 2031', 'ket' => 'Asosiasi Pedagang Pasar Seluruh Indonesia (SK: 012/SK/DPW-APPSI/VI/2026)'],
                ['posisi' => 'Sekretaris Federasi HOCKEY Indonesia (FHI) Banyuasin', 'masa' => 'Pengurus Daerah', 'ket' => 'Cabang Olahraga Prestasi KONI'],
            ],
        ];
    }

    /**
     * Halaman Indeks Katalog Arsip Tulisan & Profil Ketua
     */
    public function index(Request $request): View
    {
        $this->ensureTableExists();

        if (! Schema::hasTable('chairman_posts')) {
            $articles = new LengthAwarePaginator([], 0, 12);
            $categories = collect();
            $years = collect();
            $profile = $this->getChairmanProfile();
            $totalArticles = 0;
            $settings = Schema::hasTable('settings') ? Setting::pluck('value', 'key')->all() : [];

            return view('public.chairman_archive.index', compact(
                'articles',
                'categories',
                'years',
                'profile',
                'totalArticles',
                'settings'
            ));
        }

        $query = ChairmanPost::query();

        // 1. Search Query
        if ($request->filled('q')) {
            $query->search($request->input('q'));
        }

        // 2. Category Filter
        if ($request->filled('kategori') && $request->input('kategori') !== 'Semua') {
            $query->category($request->input('kategori'));
        }

        // 3. Year Filter
        if ($request->filled('tahun') && $request->input('tahun') !== 'Semua') {
            $query->whereYear('published_at', $request->input('tahun'));
        }

        // 4. Pagination
        $articles = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();

        // 5. Category statistics
        $categories = ChairmanPost::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        // 6. Available years (Compatible with both MySQL and SQLite)
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $yearSql = $isSqlite ? "strftime('%Y', published_at)" : 'YEAR(published_at)';
        $years = ChairmanPost::selectRaw("{$yearSql} as year, count(*) as total")
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $profile = $this->getChairmanProfile();
        $totalArticles = ChairmanPost::count();
        $settings = Schema::hasTable('settings') ? Setting::pluck('value', 'key')->all() : [];

        return view('public.chairman_archive.index', compact(
            'articles',
            'categories',
            'years',
            'profile',
            'totalArticles',
            'settings'
        ));
    }

    /**
     * Halaman Baca Detail Tulisan Arsip
     */
    public function show(string $slug): View
    {
        $this->ensureTableExists();

        if (! Schema::hasTable('chairman_posts')) {
            abort(404);
        }

        $article = ChairmanPost::where('slug', $slug)->firstOrFail();
        $article->increment('views_count');

        $related = ChairmanPost::where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest('published_at')
            ->take(4)
            ->get();

        $previous = ChairmanPost::where('published_at', '<', $article->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $next = ChairmanPost::where('published_at', '>', $article->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        $profile = $this->getChairmanProfile();
        $settings = Schema::hasTable('settings') ? Setting::pluck('value', 'key')->all() : [];

        return view('public.chairman_archive.show', compact(
            'article',
            'related',
            'previous',
            'next',
            'profile',
            'settings'
        ));
    }
}
