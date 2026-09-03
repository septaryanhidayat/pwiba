<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $countBelumUkw = Member::where('status', 'aktif')->where('tingkat_ukw', 'Belum UKW')->count();
        $countMuda = Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Muda')->count();
        $countMadya = Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Madya')->count();
        $countUtama = Member::where('status', 'aktif')->where('tingkat_ukw', 'Wartawan Utama')->count();

        $ukwStats = [
            'belum_ukw' => $countBelumUkw,
            'muda' => $countMuda,
            'madya' => $countMadya,
            'utama' => $countUtama,
            'total_aktif' => $countBelumUkw + $countMuda + $countMadya + $countUtama,
        ];

        $query = Member::where('status', 'aktif')->with('media');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                    ->orWhere('nomor_kartu', 'like', "%{$s}%")
                    ->orWhere('jabatan', 'like', "%{$s}%")
                    ->orWhere('tingkat_ukw', 'like', "%{$s}%");
            });
        }

        $perPage = $request->get('entries', 10);
        $members = $query->orderBy('nama', 'asc')->paginate($perPage);

        return view('admin.dashboard', compact(
            'countBelumUkw',
            'countMuda',
            'countMadya',
            'countUtama',
            'ukwStats',
            'members'
        ));
    }

    public function printReport(Request $request)
    {
        $tingkat = $request->get('tingkat');
        $query = Member::where('status', 'aktif')->with('media');

        if ($tingkat && in_array($tingkat, ['Belum UKW', 'Wartawan Muda', 'Wartawan Madya', 'Wartawan Utama'])) {
            $query->where('tingkat_ukw', $tingkat);
            $title = 'REKAPITULASI DATA ANGGOTA PWI BANYUASIN - '.strtoupper($tingkat);
        } else {
            $title = 'REKAPITULASI SELURUH DATA ANGGOTA PWI KABUPATEN BANYUASIN';
        }

        $members = $query->orderBy('nama', 'asc')->get();
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.members.print-report', compact('members', 'title', 'settings', 'tingkat'));
    }
}
