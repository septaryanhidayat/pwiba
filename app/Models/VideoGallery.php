<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class VideoGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'youtube_url',
        'youtube_id',
        'thumbnail_url',
        'deskripsi',
        'tanggal',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Extract standard 11-character YouTube video ID from various URL formats.
     */
    public static function extractYoutubeId(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        // Handles standard watch URLs, short youtu.be, embed, shorts, and query strings
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Fetch video title and author from YouTube's official oEmbed API.
     *
     * @return array{title: ?string, author_name: ?string, thumbnail_url: ?string}|null
     */
    public static function fetchYoutubeData(string $url): ?array
    {
        try {
            $response = Http::timeout(5)->get('https://www.youtube.com/oembed', [
                'url' => $url,
                'format' => 'json',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'title' => $data['title'] ?? null,
                    'author_name' => $data['author_name'] ?? null,
                    'thumbnail_url' => $data['thumbnail_url'] ?? null,
                ];
            }
        } catch (\Throwable) {
            // Graceful fallback if network is unreachable
        }

        return null;
    }

    /**
     * Get responsive YouTube embed URL.
     */
    public function getEmbedUrlAttribute(): string
    {
        return 'https://www.youtube-nocookie.com/embed/'.$this->youtube_id.'?autoplay=1&rel=0';
    }

    /**
     * Get high-quality thumbnail image URL with fallback.
     */
    public function getThumbnailUrlAttribute(?string $value): string
    {
        if ($value && filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        if ($this->youtube_id) {
            return 'https://i.ytimg.com/vi/'.$this->youtube_id.'/hqdefault.jpg';
        }

        return 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=800&auto=format&fit=crop&q=80';
    }
}
