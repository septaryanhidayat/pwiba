<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'nama',
        'nomor_kartu',
        'tingkat_ukw',
        'masa_berlaku',
        'jabatan',
        'urutan',
        'foto',
        'x_twitter',
        'facebook',
        'instagram',
        'youtube',
        'periode',
        'status',
    ];

    protected $casts = [
        'masa_berlaku' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $this->foto);
            if ($webp !== $this->foto && (file_exists(public_path('storage/'.$webp)) || file_exists(public_path($webp)))) {
                return file_exists(public_path('storage/'.$webp)) ? asset('storage/'.$webp) : asset($webp);
            }
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://') || str_starts_with($this->foto, 'assets/')) {
                return str_starts_with($this->foto, 'assets/') ? asset($this->foto) : $this->foto;
            }
            if (file_exists(public_path('storage/'.$this->foto))) {
                return asset('storage/'.$this->foto);
            }
            if (file_exists(public_path($this->foto))) {
                return asset($this->foto);
            }

            return asset('storage/'.$this->foto);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->nama).'&background=e2e8f0&color=334155&size=200&bold=true';
    }
}
