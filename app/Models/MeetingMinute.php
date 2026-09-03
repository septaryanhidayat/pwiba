<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingMinute extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_rapat',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'pemimpin_rapat',
        'notulis',
        'agenda',
        'pembahasan',
        'kesimpulan',
        'file_lampiran',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(MeetingAttendance::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'meeting_attendances')
            ->withPivot('status_kehadiran', 'keterangan')
            ->withTimestamps();
    }

    public function getHadirCountAttribute(): int
    {
        return $this->attendances()->where('status_kehadiran', 'hadir')->count();
    }
}
