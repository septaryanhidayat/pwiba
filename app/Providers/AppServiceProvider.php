<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\VisitorTrackerService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') && ! str_ends_with(request()->getHost(), '.test') && ! in_array(request()->getHost(), ['localhost', '127.0.0.1'])) {
            URL::forceScheme('https');
        }

        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');

        View::composer('*', function ($view) {
            static $globalSettings = null;
            if ($globalSettings === null) {
                try {
                    if (Schema::hasTable('settings')) {
                        $globalSettings = Setting::pluck('value', 'key')->all();
                        $customLogo = $globalSettings['logo'] ?? null;
                        $globalSettings['logo_url'] = ($customLogo && Storage::disk('public')->exists($customLogo))
                            ? Storage::disk('public')->url($customLogo)
                            : asset('assets/images/pwi-logo.webp');
                    } else {
                        $globalSettings = [
                            'logo_url' => asset('assets/images/pwi-logo.webp'),
                        ];
                    }
                } catch (\Throwable) {
                    $globalSettings = [
                        'logo_url' => asset('assets/images/pwi-logo.webp'),
                    ];
                }
            }

            $currentData = $view->getData();
            $existing = $currentData['settings'] ?? [];
            $merged = array_merge($globalSettings, is_array($existing) ? $existing : []);
            if (empty($merged['logo_url'])) {
                $merged['logo_url'] = asset('assets/images/pwi-logo.webp');
            }

            $view->with('settings', $merged);
        });

        View::composer('layouts.public', function ($view) {
            try {
                $stats = VisitorTrackerService::getRealVisitorStats();
                $view->with('visitorStats', $stats);
            } catch (\Throwable) {
                $view->with('visitorStats', [
                    'today' => 1,
                    'yesterday' => 0,
                    'total_visitors' => 1,
                    'total_hits' => 1,
                    'online' => 1,
                ]);
            }
        });
    }
}
