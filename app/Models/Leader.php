<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    protected $fillable = [
        'urutan',
        'nama',
        'jabatan',
        'periode',
        'tahun_mulai',
        'tahun_selesai',
        'foto',
        'keterangan',
        'status_aktif',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'tahun_mulai' => 'integer',
        'tahun_selesai' => 'integer',
        'status_aktif' => 'boolean',
    ];

    /**
     * Get the photo URL with WebP fallback support
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            $path = $this->foto;
            $basePath = pathinfo($path, PATHINFO_DIRNAME).'/'.pathinfo($path, PATHINFO_FILENAME);
            $webpPath = $basePath.'.webp';

            if (file_exists(public_path('storage/'.$webpPath))) {
                return asset('storage/'.$webpPath);
            }

            if (file_exists(public_path('storage/'.$path))) {
                return asset('storage/'.$path);
            }

            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return asset('assets/images/placeholder-leader.webp');
    }
}
