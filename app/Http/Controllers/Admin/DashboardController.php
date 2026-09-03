<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Inbox;
use App\Models\IncomingLetter;
use App\Models\Letter;
use App\Models\MeetingMinute;
use App\Models\Member;
use App\Models\Post;
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

        // Data Operasional & Ringkasan Eksekutif
        $totalNews = Post::where('status', 'published')->count();
        $totalViews = Post::sum('views_count');
        $latestPosts = Post::latest('published_at')->take(5)->get();

        $totalLettersOut = Letter::count();
        $totalLettersIn = IncomingLetter::count();
        $latestLetters = Letter::latest('tanggal')->take(5)->get();

        $totalMeetings = MeetingMinute::count();
        $latestMeetings = MeetingMinute::withCount('attendances')->latest('tanggal')->take(4)->get();

        $totalInboxes = Inbox::count();
        $unreadInboxes = Inbox::where('status', 'belum_dibaca')->count();
        $latestInboxes = Inbox::latest('tanggal')->take(4)->get();

        $totalGalleries = Gallery::count();

        return view('admin.dashboard', compact(
            'countBelumUkw',
            'countMuda',
            'countMadya',
            'countUtama',
            'ukwStats',
            'totalNews',
            'totalViews',
            'latestPosts',
            'totalLettersOut',
            'totalLettersIn',
            'latestLetters',
            'totalMeetings',
            'latestMeetings',
            'totalInboxes',
            'unreadInboxes',
            'latestInboxes',
            'totalGalleries'
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
