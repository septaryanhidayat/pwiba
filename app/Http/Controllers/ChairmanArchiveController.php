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
     * Mengambil data dinamis dari dashboard admin jika ada, dengan fallback komprehensif.
     */
    public static function getChairmanProfile(): array
    {
        $defaults = [
            'name' => 'Wardoyo, S.I.Kom.',
            'title' => 'Ketua PWI Kabupaten Banyuasin (Periode 2025–2028)',
            'foto_url' => asset('assets/images/pengurus/pengurus_inti_1_wardoyo.webp'),
            'sk_resmi' => 'SK PWI Pusat Nomor: 033/PP-PWI/XI/2025',
            'badge_top' => 'Profil Eksekutif & Personal Branding Resmi',
            'tag_status_pers' => 'Wartawan Utama Dewan Pers',
            'tag_organisasi_provinsi' => 'Anggota DKP PWI Sumsel',
            'motto' => 'Menegakkan kemerdekaan pers yang beretika, membangun sinergi kemitraan strategis yang bermartabat, dan memperjuangkan kapasitas serta kesejahteraan wartawan di Kabupaten Banyuasin.',
            'ttl' => 'Sragen (Jawa Tengah), 17 Februari 1976',
            'agama' => 'Islam',
            'alamat' => 'Komplek Tanah Mas Azhar Permai, Blok F2 No. 8, Kelurahan Tanah Mas, Kec. Talang Kelapa, Kabupaten Banyuasin, Sumatera Selatan',
            'lokasi_singkat' => 'Talang Kelapa, Banyuasin',

            // Card di bawah foto
            'badge_bawah_foto' => 'PWI KABUPATEN BANYUASIN',
            'judul_bawah_foto' => 'Ketua PWI Banyuasin',
            'subjudul_bawah_foto' => 'Masa Bakti 2025 – 2028',

            'kontak' => [
                'telepon' => null,
                'email' => 'wardianstp@gmail.com',
                'instagram' => 'https://www.instagram.com/wardianstp/',
                'facebook' => 'https://www.facebook.com/ward.wardoyo',
            ],

            // Stat counters
            'stat_karya' => '320+',
            'stat_karya_label' => 'Karya Tulis',
            'stat_kiprah' => '18+ Th',
            'stat_kiprah_label' => 'Kiprah Jurnalistik',
            'stat_lisensi' => 'Utama',
            'stat_lisensi_label' => 'Lisensi UKW',
            'stat_pendidikan' => 'S.I.Kom.',
            'stat_pendidikan_label' => 'Ilmu Komunikasi',

            // Narasi & Biografi
            'narasi_judul' => 'Komitmen Teruji Mengawal Integritas Pers & Pembangunan Banyuasin',
            'narasi_subjudul' => 'Tentang Kepemimpinan & Pengabdian',
            'narasi_paragraf_1' => 'Wardoyo, S.I.Kom. adalah tokoh pers dan praktisi komunikasi yang telah mendedikasikan lebih dari 18 tahun kariernya di dunia jurnalistik Sumatera Selatan. Memulai langkah dari wartawan lapangan, peliput investigasi, hingga memimpin media siber nasional sebagai Pemimpin Redaksi, beliau memiliki pemahaman mendalam tentang ekosistem pers dan dinamika publik.',
            'narasi_paragraf_2' => 'Menyelesaikan studi Sarjana (S1) Ilmu Komunikasi bidang Jurnalistik serta menempuh studi lanjutan pascasarjana di STISIPOL Candradimuka Palembang, Wardoyo memadukan kecakapan teknis jurnalistik dengan landasan intelektual yang kokoh. Beliau mengantongi predikat Wartawan Tingkat Utama Dewan Pers yang diuji langsung oleh tokoh pers nasional mantan Kepala Biro LKBN ANTARA New York, Bapak Aat Surya Safaat.',
            'narasi_paragraf_3' => 'Terpilih sebagai Ketua PWI Kabupaten Banyuasin Periode 2025–2028 berdasarkan SK PWI Pusat Nomor 033/PP-PWI/XI/2025, Wardoyo membawa visi transformasi organisasi pers yang berdaya saing, independen, menjunjung tinggi Kode Etik Jurnalistik (KEJ), serta menjadi mitra kritis dan solutif bagi kemajuan daerah.',

            // 4 Pilar Nilai Strategis
            'pilar_nilai' => [
                [
                    'icon' => 'fa-solid fa-scale-balanced',
                    'title' => 'Integritas & Etika Pers',
                    'desc' => 'Menegakkan kepatuhan terhadap UU Pers No. 40/1999 dan Kode Etik Jurnalistik demi menjaga kepercayaan publik.',
                ],
                [
                    'icon' => 'fa-solid fa-graduation-cap',
                    'title' => 'Transformasi SDM & Kompetensi',
                    'desc' => 'Mendorong sertifikasi Uji Kompetensi Wartawan (UKW) berkala dan literasi digital di era media siber.',
                ],
                [
                    'icon' => 'fa-solid fa-handshake-angle',
                    'title' => 'Kemitraan Kritis & Solutif',
                    'desc' => 'Membangun sinergi konstruktif dengan Forkopimda dan institusi daerah demi kemajuan Banyuasin.',
                ],
                [
                    'icon' => 'fa-solid fa-shield-halved',
                    'title' => 'Advokasi & Perlindungan Hukum',
                    'desc' => 'Menjamin keamanan dan perlindungan profesi wartawan dalam menjalankan tugas jurnalistik di lapangan.',
                ],
            ],

            'pendidikan' => [
                ['tingkat' => 'Pascasarjana (S2)', 'instansi' => 'STISIPOL Candradimuka Palembang', 'prodi' => 'Program Studi Ilmu Komunikasi', 'status' => 'Sedang Ditempuh', 'is_completed' => false],
                ['tingkat' => 'S1 (Sarjana)', 'instansi' => 'STISIPOL Candradimuka Palembang', 'prodi' => 'Ilmu Komunikasi (Program Studi Ilmu Jurnalistik)', 'status' => 'Lulus', 'is_completed' => true],
                ['tingkat' => 'Diploma', 'instansi' => 'Universitas Bina Darma Palembang', 'prodi' => 'Teknik Komputer', 'status' => 'Lulus', 'is_completed' => true],
                ['tingkat' => 'SMA', 'instansi' => 'SMA YP Mantra Mariana Banyuasin', 'prodi' => 'Jurusan Biologi (A2)', 'status' => 'Lulus', 'is_completed' => true],
                ['tingkat' => 'SMP', 'instansi' => 'SMP Negeri 3 Banyuasin', 'prodi' => 'Pendidikan Dasar', 'status' => 'Lulus', 'is_completed' => true],
                ['tingkat' => 'SD', 'instansi' => 'SD Negeri 1 Sumber Rejo', 'prodi' => 'Kecamatan Pulau Rimau', 'status' => 'Lulus', 'is_completed' => true],
            ],
            'sertifikasi' => [
                [
                    'bidang' => 'Uji Kompetensi Wartawan (UKW) Tingkat Utama',
                    'penerbit' => 'Dewan Pers & PWI Pusat',
                    'nomor' => '1231-PWI/WU/DP/XII/2018/17/02/76',
                    'penguji' => 'Aat Surya Safaat (Mantan Kepala Biro LKBN ANTARA di New York, Direktur UKW PWI Pusat)',
                    'tahun' => 'Lulus 2018',
                    'keterangan' => 'Lisensi Wartawan Tingkat Utama Dewan Pers Republik Indonesia',
                ],
                [
                    'bidang' => 'Pelatihan Peliputan Investigasi',
                    'penerbit' => 'Komisi Pemberantasan Korupsi (KPK)',
                    'nomor' => '-',
                    'tahun' => '2014',
                    'keterangan' => 'Pelatihan investigasi tindak pidana korupsi untuk jurnalis',
                ],
                [
                    'bidang' => 'Lokakarya Wartawan "Meliput Perubahan Iklim"',
                    'penerbit' => 'Lembaga Pers Dr. Soetomo (LPDS) & Kedutaan Norwegia',
                    'nomor' => '-',
                    'tahun' => '2012',
                    'keterangan' => 'Pelatihan liputan lingkungan hidup dan perubahan iklim',
                ],
                [
                    'bidang' => 'Diseminasi Pedoman Peliputan Terorisme',
                    'penerbit' => 'BNPT & Forum Koordinasi Pencegahan Terorisme Sumsel',
                    'nomor' => '-',
                    'tahun' => '2016',
                    'keterangan' => 'Peningkatan profesionalisme pers dalam peliputan isu terorisme',
                ],
                [
                    'bidang' => 'Fellowship Jurnalisme Perubahan Perilaku (FJPP)',
                    'penerbit' => 'Satgas Penanganan COVID-19 & Dewan Pers',
                    'nomor' => '-',
                    'tahun' => '2020–2021',
                    'keterangan' => 'Menghasilkan 157 karya berita advokasi kesehatan publik',
                ],
                [
                    'bidang' => 'Akreditasi Pemantau Pemilu MAPPILU PWI',
                    'penerbit' => 'BAWASLU Republik Indonesia',
                    'nomor' => '034/BAWASLU/II/2019',
                    'tahun' => '2019',
                    'keterangan' => 'Pemantau Pemilu Terakreditasi Nasional',
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

            // Footer Banner Kemitraan
            'footer_badge' => 'Silaturahmi & Kemitraan Strategis',
            'footer_title' => 'Terhubung Langsung dengan Wardoyo, S.I.Kom.',
            'footer_desc' => 'Terbuka untuk ruang diskusi, kemitraan strategis kelembagaan, audiensi pers, narasumber media & jurnalisme, maupun silaturahmi pembangunan daerah Kabupaten Banyuasin.',
        ];

        try {
            if (Schema::hasTable('settings')) {
                $savedJson = Setting::get('chairman_profile_data');
                if ($savedJson) {
                    $savedData = json_decode($savedJson, true);
                    if (is_array($savedData)) {
                        $listKeys = ['organisasi', 'pendidikan', 'sertifikasi', 'pilar_nilai'];
                        foreach ($listKeys as $listKey) {
                            if (array_key_exists($listKey, $savedData)) {
                                $defaults[$listKey] = $savedData[$listKey];
                                unset($savedData[$listKey]);
                            }
                        }
                        $defaults = array_replace_recursive($defaults, $savedData);
                    }
                }

                $customPhoto = Setting::get('chairman_profile_photo');
                if ($customPhoto && Storage::disk('public')->exists($customPhoto)) {
                    $defaults['foto_url'] = Storage::disk('public')->url($customPhoto);
                }
            }
        } catch (\Throwable $e) {
            // Gunakan fallback default jika database/setting belum siap
        }

        return $defaults;
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
