<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialReportItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_report_id',
        'jenis',
        'tanggal',
        'uraian',
        'jumlah',
        'urutan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'urutan' => 'integer',
    ];

    public function financialReport(): BelongsTo
    {
        return $this->belongsTo(FinancialReport::class);
    }
}
