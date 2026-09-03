<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'perihal',
        'isi_ringkas',
        'file_lampiran',
        'status_disposisi',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_lampiran) {
            return asset('storage/' . $this->file_lampiran);
        }
        return null;
    }
}
