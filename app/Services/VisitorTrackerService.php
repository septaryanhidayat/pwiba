<?php

namespace App\Services;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class VisitorTrackerService
{
    /**
     * Record genuine visitor analytics log.
     */
    public static function track(Request $request): void
    {
        // 1. Skip non-public or static asset routes
        if (! Schema::hasTable('visitor_logs')) {
            return;
        }

        $path = $request->path();
        if (
            $request->is('storage*') ||
            $request->is('up') ||
            $request->is('livewire*') ||
            $request->is('_ignition*') ||
            $request->is('vendor*')
        ) {
            return;
        }

        // Only track standard GET page loads
        if (! $request->isMethod('GET')) {
            return;
        }

        $userAgent = (string) $request->header('User-Agent', '');

        // 2. Filter out bots and automated crawlers to maintain authentic metrics
        if (preg_match('/bot|crawl|slurp|spider|mediapartners|lighthouse|headlesschrome|uptimerobot|facebookexternalhit/i', $userAgent)) {
            return;
        }

        $ip = $request->ip();
        $sessionId = $request->hasSession() ? $request->session()->getId() : null;
        $url = '/'.ltrim($path, '/');

        // Debounce 1 second only to prevent duplicate requests from prefetch/browser double-hit
        $alreadyLogged = VisitorLog::where('url', $url)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subSecond())
            ->exists();

        if ($alreadyLogged) {
            return;
        }

        // 4. Parse Device, Browser, and OS Platform
        $deviceType = self::detectDevice($userAgent);
        $browser = self::detectBrowser($userAgent);
        $platform = self::detectPlatform($userAgent);

        // 5. Parse Referrer
        $referrer = (string) $request->header('referer', '');
        $referrerDomain = self::extractReferrerDomain($referrer, $request->getHost());
        $referrerType = self::classifyReferrerType($referrerDomain, $referrer);

        try {
            VisitorLog::create([
                'ip_address' => $ip,
                'session_id' => $sessionId,
                'url' => substr($url, 0, 255),
                'route_name' => $request->route()?->getName(),
                'method' => 'GET',
                'referrer' => $referrer ? substr($referrer, 0, 500) : null,
                'referrer_domain' => $referrerDomain,
                'referrer_type' => $referrerType,
                'user_agent' => substr($userAgent, 0, 500),
                'device_type' => $deviceType,
                'browser' => $browser,
                'platform' => $platform,
            ]);
        } catch (\Throwable) {
            // Graceful silent fallback so visitor tracking never interrupts page rendering
        }
    }

    /**
     * Detect device type (Desktop, Mobile, or Tablet).
     */
    public static function detectDevice(string $ua): string
    {
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            return 'Tablet';
        }

        if (preg_match('/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/i', $ua)) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    /**
     * Detect browser name.
     */
    public static function detectBrowser(string $ua): string
    {
        if (preg_match('/edg(?:e)?\/([0-9.]+)/i', $ua)) {
            return 'Microsoft Edge';
        }
        if (preg_match('/opera|opr\/([0-9.]+)/i', $ua)) {
            return 'Opera';
        }
        if (preg_match('/chrome\/([0-9.]+)/i', $ua)) {
            return 'Google Chrome';
        }
        if (preg_match('/version\/([0-9.]+).*safari/i', $ua)) {
            return 'Apple Safari';
        }
        if (preg_match('/firefox\/([0-9.]+)/i', $ua)) {
            return 'Mozilla Firefox';
        }

        return 'Browser Lainnya';
    }

    /**
     * Detect OS platform.
     */
    public static function detectPlatform(string $ua): string
    {
        if (preg_match('/windows nt/i', $ua)) {
            return 'Windows';
        }
        if (preg_match('/android/i', $ua)) {
            return 'Android';
        }
        if (preg_match('/iphone|ipad|ipod/i', $ua)) {
            return 'iOS';
        }
        if (preg_match('/macintosh|mac os x/i', $ua)) {
            return 'macOS';
        }
        if (preg_match('/linux/i', $ua)) {
            return 'Linux';
        }

        return 'OS Lainnya';
    }

    /**
     * Extract hostname from referrer.
     */
    public static function extractReferrerDomain(string $referrer, string $currentHost): string
    {
        if (empty($referrer)) {
            return 'Direct / Langsung';
        }

        $parsed = parse_url($referrer, PHP_URL_HOST);
        if (! $parsed || $parsed === $currentHost) {
            return 'Direct / Langsung';
        }

        return preg_replace('/^www\./i', '', strtolower($parsed));
    }

    /**
     * Classify referrer type (Direct, Search Engine, Social Media, or Website Rujukan).
     */
    public static function classifyReferrerType(string $domain, string $referrer): string
    {
        if ($domain === 'Direct / Langsung' || empty($referrer)) {
            return 'Direct / Langsung';
        }

        if (preg_match('/google\.|bing\.|yahoo\.|duckduckgo\.|yandex\./i', $domain)) {
            return 'Mesin Pencari (Search)';
        }

        if (preg_match('/facebook\.|fb\.com|instagram\.|t\.co|twitter\.|x\.com|tiktok\.|whatsapp\.|wa\.me|linkedin\.|threads\./i', $domain)) {
            return 'Media Sosial';
        }

        return 'Situs Eksternal';
    }

    /**
     * Retrieve aggregated real-time visitor statistics for public display & dashboard.
     *
     * @return array{today: int, yesterday: int, total_visitors: int, total_hits: int, online: int}
     */
    public static function getRealVisitorStats(): array
    {
        if (! Schema::hasTable('visitor_logs')) {
            return [
                'today' => 0,
                'yesterday' => 0,
                'this_month' => 0,
                'total_visitors' => 0,
                'total_hits' => 0,
                'online' => 1,
            ];
        }

        $today = VisitorLog::whereDate('created_at', today())->count();
        $yesterday = VisitorLog::whereDate('created_at', today()->subDay())->count();
        $thisMonth = VisitorLog::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        $totalVisitors = VisitorLog::count();
        $totalHits = $totalVisitors;
        $online = VisitorLog::where('created_at', '>=', now()->subMinutes(15))->count();

        return [
            'today' => max($today, 1),
            'yesterday' => $yesterday,
            'this_month' => max($thisMonth, 1),
            'total_visitors' => max($totalVisitors, 1),
            'total_hits' => max($totalHits, 1),
            'online' => max($online, 1),
        ];
    }
}
