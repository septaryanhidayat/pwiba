<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitorLog;
use App\Services\VisitorTrackerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function getAdminUser(): User
    {
        return User::first() ?? User::factory()->create([
            'email' => 'admin@pwibanyuasin.or.id',
            'role' => 'admin',
        ]);
    }

    public function test_public_page_visit_records_visitor_log(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
        ])->get('/');

        $response->assertStatus(200);

        $this->assertDatabaseHas('visitor_logs', [
            'url' => '/',
            'method' => 'GET',
            'device_type' => 'Desktop',
            'browser' => 'Google Chrome',
            'platform' => 'Windows',
        ]);
    }

    public function test_visitor_tracking_debounces_rapid_reloads_on_same_page(): void
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari/604.1',
        ];

        // 1st request
        $this->withHeaders($headers)->get('/berita');
        $initialCount = VisitorLog::where('url', '/berita')->count();
        $this->assertEquals(1, $initialCount);

        // Immediate 2nd request with same session
        $this->withHeaders($headers)->get('/berita');
        $countAfterReload = VisitorLog::where('url', '/berita')->count();

        // Should not duplicate due to 5-minute debounce
        $this->assertEquals(1, $countAfterReload);
    }

    public function test_public_footer_renders_real_visitor_stats(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Statistik Pengunjung', false);
        $response->assertSee('Hari Ini', false);
        $response->assertSee('Kemarin', false);
        $response->assertSee('Bulan Ini', false);
        $response->assertSee('Total Tamu', false);
        $response->assertSee('Online', false);
    }

    public function test_unauthenticated_user_cannot_access_analytics_dashboard(): void
    {
        $response = $this->get('/admin/analitik-pengunjung');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_access_analytics_dashboard(): void
    {
        $admin = $this->getAdminUser();

        // Create sample visitor logs with real schema
        VisitorLog::create([
            'ip_address' => '127.0.0.1',
            'session_id' => 'test-session-123',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0',
            'device_type' => 'Desktop',
            'browser' => 'Google Chrome',
            'platform' => 'Windows',
            'referrer' => 'https://google.com/search?q=pwi',
            'referrer_domain' => 'google.com',
            'referrer_type' => 'Mesin Pencari (Search)',
            'url' => '/',
            'method' => 'GET',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/admin/analitik-pengunjung');

        $response->assertStatus(200);
        $response->assertSee('Statistik Pengunjung & Tren Pembaca Portal', false);
        $response->assertSee('Tren Kunjungan & Pembaca (14 Hari Terakhir)', false);
        $response->assertSee('Perangkat & Browser Pengunjung', false);
        $response->assertSee('Asal Lalu Lintas Pengunjung (Referrer)', false);
        $response->assertSee('Feed Kunjungan Terkini (Real-Time Live Logs)', false);
        $response->assertSee('Desktop', false);
        $response->assertSee('Google Chrome', false);
    }

    public function test_visitor_tracker_service_user_agent_and_referrer_parsing(): void
    {
        // 1. Mobile Android Chrome
        $androidUA = 'Mozilla/5.0 (Linux; Android 14; SM-S928B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36';
        $this->assertEquals('Mobile', VisitorTrackerService::detectDevice($androidUA));
        $this->assertEquals('Google Chrome', VisitorTrackerService::detectBrowser($androidUA));
        $this->assertEquals('Android', VisitorTrackerService::detectPlatform($androidUA));

        // 2. Desktop Windows Firefox
        $firefoxUA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:130.0) Gecko/20100101 Firefox/130.0';
        $this->assertEquals('Desktop', VisitorTrackerService::detectDevice($firefoxUA));
        $this->assertEquals('Mozilla Firefox', VisitorTrackerService::detectBrowser($firefoxUA));
        $this->assertEquals('Windows', VisitorTrackerService::detectPlatform($firefoxUA));

        // 3. Referrer categorization
        $this->assertEquals('Direct / Langsung', VisitorTrackerService::classifyReferrerType('Direct / Langsung', ''));
        $this->assertEquals('Mesin Pencari (Search)', VisitorTrackerService::classifyReferrerType('google.com', 'https://www.google.com/search?q=pwi+banyuasin'));
        $this->assertEquals('Media Sosial', VisitorTrackerService::classifyReferrerType('l.facebook.com', 'https://l.facebook.com/l.php?u=https://pwiba.or.id'));
        $this->assertEquals('Media Sosial', VisitorTrackerService::classifyReferrerType('instagram.com', 'https://instagram.com/'));
        $this->assertEquals('Media Sosial', VisitorTrackerService::classifyReferrerType('api.whatsapp.com', 'https://api.whatsapp.com/send'));
        $this->assertEquals('Situs Eksternal', VisitorTrackerService::classifyReferrerType('banyuasinkab.go.id', 'https://banyuasinkab.go.id/berita-pwi'));

        // 4. Real visitor stats calculation returns integer array
        $stats = VisitorTrackerService::getRealVisitorStats();
        $this->assertArrayHasKey('today', $stats);
        $this->assertArrayHasKey('yesterday', $stats);
        $this->assertArrayHasKey('this_month', $stats);
        $this->assertArrayHasKey('total_visitors', $stats);
        $this->assertArrayHasKey('total_hits', $stats);
        $this->assertArrayHasKey('online', $stats);
        $this->assertIsInt($stats['today']);
        $this->assertIsInt($stats['total_visitors']);
    }
}
