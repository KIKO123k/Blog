<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\FooterLink;

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
        // Share footer links across all views (Blade layouts + Inertia root)
        $shareFooter = function ($view) {
            $footerLinks = FooterLink::orderBy('order')->get();
            $view->with('footerLinks', $footerLinks);
        };
        View::composer('layouts.app', $shareFooter);
        View::composer('app', $shareFooter);

        // Configure rate limiters
        $this->configureRateLimiting();
    }

    /**
     * Configure rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Global API rate limit: 60 requests per minute
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Auth routes: 5 attempts per minute (login, register, forgot-password)
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Comments: 10 per hour per user
        RateLimiter::for('comments', function (Request $request) {
            $user = $request->user();
            return Limit::perHour(10)->by($user?->id ?: $request->ip());
        });

        // Ratings: 20 per hour per user
        RateLimiter::for('ratings', function (Request $request) {
            $user = $request->user();
            return Limit::perHour(20)->by($user?->id ?: $request->ip());
        });

        // Search: 30 requests per minute
        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });
    }
}
