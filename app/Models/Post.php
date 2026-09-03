<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'penulis',
        'kategori',
        'status',
        'views_count',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->judul).'-'.Str::random(5);
            }
        });
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $this->gambar);
            if ($webp !== $this->gambar && (file_exists(public_path('storage/'.$webp)) || file_exists(public_path($webp)))) {
                return file_exists(public_path('storage/'.$webp)) ? asset('storage/'.$webp) : asset($webp);
            }
            if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://') || str_starts_with($this->gambar, 'assets/')) {
                return str_starts_with($this->gambar, 'assets/') ? asset($this->gambar) : $this->gambar;
            }
            if (file_exists(public_path('storage/'.$this->gambar))) {
                return asset('storage/'.$this->gambar);
            }
            if (file_exists(public_path($this->gambar))) {
                return asset($this->gambar);
            }

            return asset('storage/'.$this->gambar);
        }

        return 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=800&auto=format&fit=crop&q=80';
    }
}
