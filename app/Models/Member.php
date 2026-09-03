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
            return asset('storage/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=0f172a&color=f8fafc&size=256&bold=true';
    }

    public function getUkwColorBadgeAttribute(): string
    {
        return match ($this->tingkat_ukw) {
            'Wartawan Utama' => 'bg-rose-500/10 text-rose-500 border border-rose-500/20',
            'Wartawan Madya' => 'bg-cyan-500/10 text-cyan-500 border border-cyan-500/20',
            'Wartawan Muda'  => 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20',
            default          => 'bg-slate-500/10 text-slate-400 border border-slate-500/20',
        };
    }
}
