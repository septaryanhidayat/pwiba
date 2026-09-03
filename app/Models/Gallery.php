<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
        'tanggal_kegiatan',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://') || str_starts_with($this->foto, 'assets/')) {
                return str_starts_with($this->foto, 'assets/') ? asset($this->foto) : $this->foto;
            }
            if (file_exists(public_path('storage/' . $this->foto))) {
                return asset('storage/' . $this->foto);
            }
            if (file_exists(public_path($this->foto))) {
                return asset($this->foto);
            }
        }
        return 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&auto=format&fit=crop&q=80';
    }
}
