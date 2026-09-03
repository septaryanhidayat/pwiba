<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'nomor_surat',
        'tanggal',
        'jenis_surat',
        'member_id',
        'tujuan',
        'keperluan',
        'perihal',
        'tempat_tujuan',
        'nama_pejabat',
        'jabatan_pejabat',
        'alamat_tujuan',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lampiran',
        'isi_surat',
        'file_dokumen',
        'penandatangan_nama',
        'penandatangan_sekretaris',
        'status_verifikasi',
        'hash_keabsahan',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($letter) {
            if (empty($letter->uuid)) {
                $letter->uuid = (string) \Illuminate\Support\Str::uuid();
            }
            if (empty($letter->hash_keabsahan)) {
                $letter->hash_keabsahan = hash('sha256', ($letter->nomor_surat ?? '') . '|' . ($letter->tanggal ?? '') . '|' . ($letter->tujuan ?? '') . '|PWI-BANYUASIN-OFFICIAL');
            }
        });
    }

    public function getVerificationUrlAttribute(): string
    {
        return route('letter.verify', $this->uuid);
    }

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public static function generateNomorSurat(string $jenis = 'SURAT BIASA'): string
    {
        $count = self::count() + 1;
        $padded = str_pad($count, 3, '0', STR_PAD_LEFT);
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $month = $romanMonths[date('n')];
        $year = date('Y');

        $kode = match (strtoupper($jenis)) {
            'SURAT TUGAS' => 'PWI-ST',
            'SURAT AUDENSI' => 'PWI-AUD',
            'PROPOSAL' => 'PWI-PROP',
            default => 'PWI-BA',
        };

        return "{$padded}/{$kode}/{$month}/{$year}";
    }

    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_dokumen) {
            return asset('storage/' . $this->file_dokumen);
        }
        return null;
    }
}
