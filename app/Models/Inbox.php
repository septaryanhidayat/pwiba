<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'nama',
        'instansi',
        'email',
        'telepon',
        'tujuan',
        'keperluan',
        'pesan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
