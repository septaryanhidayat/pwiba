<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class SyncPostViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:sync-views {--reset-all : Reset all views_count strictly to post_views count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronkan total views berita dengan jumlah log riil dari tabel post_views atau bersihkan fake counter';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai sinkronisasi total views riil...');

        $posts = Post::withCount(['views as authentic_views_count'])->get();
        $updatedCount = 0;

        foreach ($posts as $post) {
            $realCount = (int) $post->authentic_views_count;
            // Reset known fake counters or sync to real count if reset-all is passed
            if ($this->option('reset-all') || in_array($post->getRawOriginal('views_count'), [669, 238, 750, 743, 789, 922])) {
                $post->update(['views_count' => $realCount]);
                $updatedCount++;
            }
        }

        $this->info("Berhasil! {$updatedCount} berita disinkronkan ke total view autentik.");

        return Command::SUCCESS;
    }
}
