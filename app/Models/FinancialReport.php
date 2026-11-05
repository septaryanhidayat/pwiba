<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_kegiatan',
        'lanjutan_nama_kegiatan',
        'hari_tanggal',
        'tempat',
        'tempat_tanggal_ttd',
        'nama_mengetahui',
        'jabatan_mengetahui',
        'nama_bendahara',
        'jabatan_bendahara',
        'total_penerimaan',
        'total_pengeluaran',
        'saldo',
        'keterangan',
    ];

    protected $casts = [
        'total_penerimaan' => 'decimal:2',
        'total_pengeluaran' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(FinancialReportItem::class)->orderBy('urutan')->orderBy('id');
    }

    public function penerimaanItems(): HasMany
    {
        return $this->items()->where('jenis', 'penerimaan');
    }

    public function pengeluaranItems(): HasMany
    {
        return $this->items()->where('jenis', 'pengeluaran');
    }

    /**
     * Recalculate totals and balance from items.
     */
    public function recalculateTotals(): self
    {
        $this->total_penerimaan = (float) $this->items()->where('jenis', 'penerimaan')->sum('jumlah');
        $this->total_pengeluaran = (float) $this->items()->where('jenis', 'pengeluaran')->sum('jumlah');
        $this->saldo = $this->total_penerimaan - $this->total_pengeluaran;
        $this->save();

        return $this;
    }
}
