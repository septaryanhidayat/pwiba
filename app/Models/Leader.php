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
            $path = ltrim($this->foto, '/');
            $filename = basename($path);
            $dir = dirname($path);

            $candidates = [
                'storage/'.$path,
                'storage/'.$dir.'/'.$filename,
                $path,
                'leaders/'.$filename,
                'assets/images/leaders/'.$filename,
            ];

            // Add typo resilience: diding vs dinding
            if (str_contains($filename, 'diding')) {
                $altFilename = str_replace('diding', 'dinding', $filename);
                $candidates[] = 'storage/'.$dir.'/'.$altFilename;
                $candidates[] = 'storage/leaders/'.$altFilename;
                $candidates[] = 'leaders/'.$altFilename;
            } elseif (str_contains($filename, 'dinding')) {
                $altFilename = str_replace('dinding', 'diding', $filename);
                $candidates[] = 'storage/'.$dir.'/'.$altFilename;
                $candidates[] = 'storage/leaders/'.$altFilename;
                $candidates[] = 'leaders/'.$altFilename;
            }

            foreach ($candidates as $candidate) {
                if (file_exists(public_path($candidate))) {
                    return asset($candidate);
                }
            }

            if (file_exists(storage_path('app/public/'.$path))) {
                return asset('storage/'.$path);
            }
        }

        if (file_exists(public_path('assets/images/placeholder-leader.webp'))) {
            return asset('assets/images/placeholder-leader.webp');
        }

        if (file_exists(public_path('assets/images/admin.webp'))) {
            return asset('assets/images/admin.webp');
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->nama).'&background=1e293b&color=f8fafc&size=256&bold=true';
    }
}
