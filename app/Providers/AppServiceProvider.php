<?php

namespace App\Providers;

use App\Listeners\DeleteExpiredFcmTokens;
use App\Services\FirebaseCredentialsService;
use App\Services\PushNotificationService;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PushNotificationService::class);
        $this->app->singleton(FirebaseCredentialsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for all asset URLs to resolve Mixed Content issues
        // We use a direct host check to bypass all proxy header and .env issues
        if (request()->getHost() !== 'localhost' && request()->getHost() !== '127.0.0.1') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Event::listen(NotificationFailed::class, DeleteExpiredFcmTokens::class);

        $this->app->booted(function (): void {
            try {
                app(FirebaseCredentialsService::class)->applyToConfig();
            } catch (\Throwable) {
                // Database may be unavailable during install/migrate.
            }
        });
    }
}
