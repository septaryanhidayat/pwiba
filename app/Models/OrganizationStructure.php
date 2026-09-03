<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

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
        'x_twitter',
        'facebook',
        'instagram',
        'youtube',
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

        return 'https://ui-avatars.com/api/?name='.urlencode($this->nama).'&background=e2e8f0&color=334155&size=200&bold=true';
    }

    public function getUkwBadgeColorAttribute(): string
    {
        return match ($this->tingkat_ukw) {
            'Wartawan Utama' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/60 dark:text-rose-400 dark:border-rose-800',
            'Wartawan Madya' => 'bg-cyan-50 text-cyan-700 border-cyan-200 dark:bg-cyan-950/60 dark:text-cyan-400 dark:border-cyan-800',
            'Wartawan Muda' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-400 dark:border-emerald-800',
            default => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
        };
    }

    /**
     * Group organization structures into visual hierarchy tree.
     */
    public static function getHierarchyTree(): array
    {
        $query = static::query();
        if (Schema::hasColumn('organization_structures', 'status')) {
            $query->where('status', '!=', 'nonaktif');
        }
        $structures = $query->orderBy('urutan')->get();

        $ketua = $structures->first(fn ($s) => strtoupper(trim($s->jabatan)) === 'KETUA');
        $wakilKetuaList = $structures->filter(fn ($s) => str_starts_with(strtoupper(trim($s->jabatan)), 'WAKIL KETUA'))
            ->sortBy(function ($s) {
                $j = strtoupper(trim($s->jabatan));
                if ($j === 'WAKIL KETUA' || str_contains($j, 'WAKIL KETUA 1') || str_contains($j, 'WAKIL KETUA I')) {
                    return 1;
                }
                if (str_contains($j, 'WAKIL KETUA 2') || str_contains($j, 'WAKIL KETUA II')) {
                    return 2;
                }
                if (str_contains($j, 'WAKIL KETUA 3') || str_contains($j, 'WAKIL KETUA III')) {
                    return 3;
                }

                return 4;
            })->values();

        $sekretaris = $structures->first(fn ($s) => strtoupper(trim($s->jabatan)) === 'SEKRETARIS');
        $wakilSekretaris = $structures->first(fn ($s) => strtoupper(trim($s->jabatan)) === 'WAKIL SEKRETARIS');
        $bendahara = $structures->first(fn ($s) => strtoupper(trim($s->jabatan)) === 'BENDAHARA');
        $wakilBendahara = $structures->first(fn ($s) => strtoupper(trim($s->jabatan)) === 'WAKIL BENDAHARA');

        $assignedIds = collect([
            $ketua?->id,
            $sekretaris?->id,
            $wakilSekretaris?->id,
            $bendahara?->id,
            $wakilBendahara?->id,
        ])->merge($wakilKetuaList->pluck('id'))->filter()->all();

        $bidangDefs = [
            'pembelaan' => ['code' => 'A', 'title' => 'Pembelaan Wartawan', 'icon' => 'fa-shield-halved', 'color' => 'indigo', 'match' => 'PEMBELAAN'],
            'organisasi' => ['code' => 'B', 'title' => 'Organisasi & Kaderisasi', 'icon' => 'fa-sitemap', 'color' => 'blue', 'match' => 'ORGANISASI'],
            'pendidikan' => ['code' => 'C', 'title' => 'Pendidikan & Pelatihan', 'icon' => 'fa-graduation-cap', 'color' => 'emerald', 'match' => 'PENDIDIKAN'],
            'publikasi' => ['code' => 'D', 'title' => 'Publikasi & Informasi', 'icon' => 'fa-bullhorn', 'color' => 'sky', 'match' => 'PUBLIKASI'],
            'kesejahteraan' => ['code' => 'E', 'title' => 'Kesejahteraan', 'icon' => 'fa-hand-holding-heart', 'color' => 'amber', 'match' => 'KESEJAHTERAAN'],
            'siwo' => ['code' => 'F', 'title' => 'SIWO (Olahraga)', 'icon' => 'fa-trophy', 'color' => 'rose', 'match' => 'SIWO'],
            'kemasyarakatan' => ['code' => 'G', 'title' => 'Sosial & Kemasyarakatan', 'icon' => 'fa-users', 'color' => 'teal', 'match' => 'MASYARAKAT'],
        ];

        $bidangs = [];
        foreach ($bidangDefs as $key => $b) {
            $membersInBidang = $structures->filter(function ($s) use ($b, $assignedIds) {
                if (in_array($s->id, $assignedIds)) {
                    return false;
                }

                return str_contains(strtoupper($s->jabatan), $b['match']);
            })->values();

            $kabid = $membersInBidang->first(fn ($s) => str_starts_with(strtoupper(trim($s->jabatan)), 'KABID') || str_starts_with(strtoupper(trim($s->jabatan)), 'KETUA'));
            $wakabid = $membersInBidang->first(fn ($s) => str_starts_with(strtoupper(trim($s->jabatan)), 'WAKABID') || str_starts_with(strtoupper(trim($s->jabatan)), 'WAKIL'));
            $anggotaList = $membersInBidang->filter(fn ($s) => $s->id !== $kabid?->id && $s->id !== $wakabid?->id)->values();

            foreach ($membersInBidang as $m) {
                $assignedIds[] = $m->id;
            }

            $bidangs[$key] = [
                'info' => $b,
                'kabid' => $kabid,
                'wakabid' => $wakabid,
                'anggota' => $anggotaList,
                'members' => $membersInBidang,
            ];
        }

        $anggotaUmum = $structures->reject(fn ($s) => in_array($s->id, $assignedIds))->values();

        return [
            'all' => $structures,
            'ketua' => $ketua,
            'wakil_ketua' => $wakilKetuaList,
            'sekretariat' => [
                'utama' => $sekretaris,
                'wakil' => $wakilSekretaris,
            ],
            'kebendaharaan' => [
                'utama' => $bendahara,
                'wakil' => $wakilBendahara,
            ],
            'bidangs' => $bidangs,
            'anggota_umum' => $anggotaUmum,
        ];
    }
}
