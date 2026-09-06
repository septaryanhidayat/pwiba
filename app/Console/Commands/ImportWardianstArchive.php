<?php

namespace App\Console\Commands;

use App\Models\ChairmanPost;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportWardianstArchive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:import-wardianst {--file= : Custom path to raw JSON file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import dan sanitasi 320 tulisan & profil Ketua PWI Banyuasin dari blog wardianst.wordpress.com';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = $this->option('file') ?: database_path('data/wardianst_posts.json');

        if (! file_exists($filePath)) {
            $scratchPath = 'C:/Users/RYAN/.gemini/antigravity-ide/brain/c2beda88-3ffc-4214-9997-4b2d9232dfef/scratch/raw_wp_posts.json';
            if (file_exists($scratchPath)) {
                $filePath = $scratchPath;
            } else {
                $this->error("File arsip tidak ditemukan di: {$filePath}");

                return self::FAILURE;
            }
        }

        $rawContent = file_get_contents($filePath);
        $posts = json_decode($rawContent, true);

        if (! is_array($posts)) {
            $this->error('Format data JSON tidak valid.');

            return self::FAILURE;
        }

        $this->info('Memproses '.count($posts).' arsip tulisan...');
        $bar = $this->output->createProgressBar(count($posts));
        $bar->start();

        $imported = 0;

        foreach ($posts as $p) {
            // Cek apakah data sudah dalam format tersanitasi
            if (isset($p['title']) && is_string($p['title']) && isset($p['slug']) && isset($p['content'])) {
                ChairmanPost::updateOrCreate(
                    ['slug' => $p['slug']],
                    [
                        'wp_id' => $p['wp_id'] ?? null,
                        'title' => $p['title'],
                        'category' => $p['category'] ?? 'Opini & Catatan',
                        'excerpt' => $p['excerpt'] ?? null,
                        'content' => $p['content'],
                        'reading_time' => $p['reading_time'] ?? 3,
                        'published_at' => $p['published_at'] ?? now(),
                        'original_url' => $p['original_url'] ?? null,
                    ]
                );
                $imported++;
                $bar->advance();

                continue;
            }

            // Format raw WordPress
            $wpId = $p['id'] ?? null;
            $rawTitle = $p['title']['rendered'] ?? 'Tanpa Judul';
            $rawContent = $p['content']['rendered'] ?? '';
            $rawExcerpt = $p['excerpt']['rendered'] ?? '';
            $date = $p['date'] ?? now()->toDateTimeString();
            $link = $p['link'] ?? null;
            $slug = $p['slug'] ?? Str::slug($rawTitle);

            // Sanitasi Judul
            $title = trim(html_entity_decode(strip_tags($rawTitle), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $title = preg_replace('/\s+/', ' ', $title);

            // Sanitasi Konten
            $content = $this->sanitizeContent($rawContent);

            // Sanitasi Excerpt
            $excerpt = trim(html_entity_decode(strip_tags($rawExcerpt), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $excerpt = preg_replace('/\s+/', ' ', $excerpt);
            if (empty($excerpt) || strlen($excerpt) < 20) {
                $plainText = trim(strip_tags($content));
                $excerpt = Str::limit($plainText, 180, '...');
            } else {
                $excerpt = Str::limit($excerpt, 220, '...');
            }

            // Klasifikasi Kategori Otomatis
            $category = $this->classifyCategory($title, $content, $slug);

            // Hitung reading time
            $wordCount = str_word_count(strip_tags($content));
            $readingTime = max(1, (int) ceil($wordCount / 200));

            // Simpan ke database
            ChairmanPost::updateOrCreate(
                ['slug' => $slug],
                [
                    'wp_id' => $wpId,
                    'title' => $title,
                    'category' => $category,
                    'excerpt' => $excerpt,
                    'content' => $content,
                    'reading_time' => $readingTime,
                    'published_at' => $date,
                    'original_url' => $link,
                ]
            );

            $imported++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Berhasil mengimpor dan menyaring {$imported} artikel ke tabel chairman_posts!");

        return self::SUCCESS;
    }

    /**
     * Sanitasi konten HTML dari WordPress
     */
    protected function sanitizeContent(string $html): string
    {
        // Decode entitas HTML
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Hapus elemen pelacak, script, iframe, tombol share bawaan WordPress
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $html);
        $html = preg_replace('/<div class=["\']sharedaddy[^"\']*["\'].*?<\/div>/is', '', $html);
        $html = preg_replace('/<div id=["\']jp-post-flair[^"\']*["\'].*?<\/div>/is', '', $html);
        $html = preg_replace('/<div class=["\']wpcnt[^"\']*["\'].*?<\/div>/is', '', $html);

        // Hapus inline style font/warna/background acak bawaan copas WP
        $html = preg_replace('/style=["\'][^"\']*?(font-family|font-size|background|color)[^"\']*?["\']/i', '', $html);

        // Bersihkan tag font jadul
        $html = preg_replace('/<\/?font[^>]*>/i', '', $html);

        // Bersihkan class aneh dari wordpress theme lama
        $html = preg_replace('/\sclass=["\'](has-text-align-[^"\']*|alignleft|alignright|size-[^"\']*|wp-image-[^"\']*)["\']/i', '', $html);

        // Ubah link eksternal agar aman dan membuka rel noopener
        $html = preg_replace('/<a href="(https?:\/\/[^"]+)"/i', '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-amber-400 underline hover:opacity-80 font-medium"', $html);

        // Rapikan spasi berlebih antar paragraf
        $html = preg_replace('/<p>\s*(&nbsp;|\s)*<\/p>/i', '', $html);
        $html = preg_replace('/<p><\/p>/i', '', $html);
        $html = trim($html);

        if (empty($html)) {
            $html = '<p class="text-slate-600 dark:text-slate-300">Tidak ada konten teks tambahan untuk artikel arsip ini.</p>';
        }

        return $html;
    }

    /**
     * Klasifikasi kategori otomatis yang rapi dan kontekstual
     */
    protected function classifyCategory(string $title, string $content, string $slug): string
    {
        $haystack = strtolower($title.' '.$slug.' '.substr($content, 0, 500));

        if (str_contains($haystack, 'profil') || str_contains($haystack, 'wardoyo') || str_contains($haystack, 'biodata')) {
            return 'Profil & Biografi';
        }

        if (str_contains($haystack, 'teori komunikasi') || str_contains($haystack, 'komunikasi politik') || str_contains($haystack, 'agenda setting') || str_contains($haystack, 'hypodermic') || str_contains($haystack, 'article review')) {
            return 'Teori Komunikasi';
        }

        if (str_contains($haystack, 'dewan pers') || str_contains($haystack, 'wartawan') || str_contains($haystack, 'jurnalistik') || str_contains($haystack, 'jurnalis') || str_contains($haystack, 'kemerdekaan pers') || str_contains($haystack, 'kode etik') || str_contains($haystack, 'pwi') || str_contains($haystack, 'media') || str_contains($haystack, 'aji')) {
            return 'Pers & Jurnalistik';
        }

        if (str_contains($haystack, 'kpu') || str_contains($haystack, 'pilkada') || str_contains($haystack, 'pemilu') || str_contains($haystack, 'pileg') || str_contains($haystack, 'dprd') || str_contains($haystack, 'partai') || str_contains($haystack, 'golkar') || str_contains($haystack, 'caleg') || str_contains($haystack, 'bawaslu') || str_contains($haystack, 'panwascam') || str_contains($haystack, 'capres')) {
            return 'Politik & Pemilu';
        }

        if (str_contains($haystack, 'hukum') || str_contains($haystack, 'polisi') || str_contains($haystack, 'divonis') || str_contains($haystack, 'pengadilan') || str_contains($haystack, 'kejaksaan') || str_contains($haystack, 'kpk') || str_contains($haystack, 'korupsi') || str_contains($haystack, 'pidana') || str_contains($haystack, 'uu')) {
            return 'Hukum & Keadilan';
        }

        if (str_contains($haystack, 'banyuasin') || str_contains($haystack, 'palembang') || str_contains($haystack, 'sumsel') || str_contains($haystack, 'pemkab') || str_contains($haystack, 'diskominfo') || str_contains($haystack, 'dinas')) {
            return 'Daerah & Kebijakan';
        }

        return 'Opini & Catatan';
    }
}
