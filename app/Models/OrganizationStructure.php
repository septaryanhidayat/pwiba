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
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        if ($this->foto && file_exists(public_path($this->foto))) {
            return asset($this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=1e293b&color=fff&size=200';
    }
}
