<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'nama_media',
        'website',
        'alamat',
        'pimpinan_redaksi',
        'kontak',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
