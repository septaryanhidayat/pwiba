<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_kartu',
        'tingkat_ukw',
        'masa_berlaku',
        'jabatan',
        'media_id',
        'nama_media_custom',
        'foto',
        'x_twitter',
        'facebook',
        'instagram',
        'youtube',
        'no_hp',
        'email',
        'status',
        'catatan',
    ];

    protected $casts = [
        'masa_berlaku' => 'date',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function assignedLetters(): HasMany
    {
        return $this->hasMany(Letter::class, 'member_id');
    }

    public function meetings(): BelongsToMany
    {
        return $this->belongsToMany(MeetingMinute::class, 'meeting_attendances')
            ->withPivot('status_kehadiran', 'keterangan')
            ->withTimestamps();
    }

    public function getNamaMediaAttribute(): string
    {
        if ($this->media) {
            return $this->media->nama_media;
        }

        return $this->nama_media_custom ?? '-';
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

        return 'https://ui-avatars.com/api/?name='.urlencode($this->nama).'&background=e2e8f0&color=334155&size=256&bold=true';
    }

    public function getUkwColorBadgeAttribute(): string
    {
        return match ($this->tingkat_ukw) {
            'Wartawan Utama' => 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/50 dark:text-rose-400 dark:border-rose-800',
            'Wartawan Madya' => 'bg-sky-50 text-sky-700 border border-sky-200 dark:bg-sky-950/50 dark:text-sky-400 dark:border-sky-800',
            'Wartawan Muda' => 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-400 dark:border-emerald-800',
            default => 'bg-slate-100 text-slate-600 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700',
        };
    }
}
