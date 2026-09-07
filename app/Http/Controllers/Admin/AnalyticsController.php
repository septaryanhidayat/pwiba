<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        // 1. Key Performance Indicators (Authentic Numbers)
        $totalPageviews = VisitorLog::count();
        $totalUniqueVisitors = VisitorLog::distinct('session_id')->count('session_id');

        $todayHits = VisitorLog::today()->count();
        $todayVisitors = VisitorLog::today()->distinct('session_id')->count('session_id');

        $yesterdayHits = VisitorLog::yesterday()->count();
        $yesterdayVisitors = VisitorLog::yesterday()->distinct('session_id')->count('session_id');

        $onlineVisitors = VisitorLog::online()->distinct('session_id')->count('session_id');

        // 2. Reading & Traffic Trends (Daily timeline for last 14 days)
        $dates = collect();
        for ($i = 13; $i >= 0; $i--) {
            $dateStr = now()->subDays($i)->format('Y-m-d');
            $dates->put($dateStr, [
                'date' => $dateStr,
                'label' => now()->subDays($i)->translatedFormat('d M'),
                'hits' => 0,
                'visitors' => 0,
            ]);
        }

        $dailyStats = VisitorLog::where('created_at', '>=', now()->subDays(14)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as hits, COUNT(DISTINCT session_id) as visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        foreach ($dailyStats as $stat) {
            if ($dates->has($stat->date)) {
                $item = $dates->get($stat->date);
                $item['hits'] = (int) $stat->hits;
                $item['visitors'] = (int) $stat->visitors;
                $dates->put($stat->date, $item);
            }
        }

        $trends = $dates->values();
        $maxDailyHits = max($trends->max('hits') ?: 1, 10);

        // 3. Top Most Visited Pages & Articles
        $topPages = VisitorLog::select('url', DB::raw('COUNT(*) as total_views'), DB::raw('COUNT(DISTINCT session_id) as unique_readers'))
            ->groupBy('url')
            ->orderByDesc('total_views')
            ->take(8)
            ->get();

        // 4. Most Read News Articles (Cross-referenced with Post table)
        $popularPosts = Post::where('status', 'published')
            ->orderByDesc('views_count')
            ->take(5)
            ->get(['id', 'judul', 'slug', 'views_count', 'published_at']);

        // 5. Referrer Traffic Source Distribution
        $referrers = VisitorLog::select('referrer_domain', 'referrer_type', DB::raw('COUNT(*) as count'))
            ->groupBy('referrer_domain', 'referrer_type')
            ->orderByDesc('count')
            ->take(7)
            ->get();

        // 6. Device Breakdown (Mobile vs Desktop vs Tablet)
        $devices = VisitorLog::select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();

        // 7. Browser Breakdown
        $browsers = VisitorLog::select('browser', DB::raw('COUNT(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // 8. Platform/OS Breakdown
        $platforms = VisitorLog::select('platform', DB::raw('COUNT(*) as count'))
            ->groupBy('platform')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // 9. Recent Visitor Logs Feed (Latest 20 genuine visitor hits)
        $recentLogs = VisitorLog::latest('id')
            ->take(20)
            ->get();

        return view('admin.analytics.index', compact(
            'totalPageviews',
            'totalUniqueVisitors',
            'todayHits',
            'todayVisitors',
            'yesterdayHits',
            'yesterdayVisitors',
            'onlineVisitors',
            'trends',
            'maxDailyHits',
            'topPages',
            'popularPosts',
            'referrers',
            'devices',
            'browsers',
            'platforms',
            'recentLogs'
        ));
    }
}
