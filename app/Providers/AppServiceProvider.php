<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Club;
use App\Models\Comment;
use App\Models\Major;
use App\Models\MajorComment;
use App\Models\Post;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\ClubPolicy;
use App\Policies\CommentPolicy;
use App\Policies\MajorPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\FooterLink;

class AppServiceProvider extends \Illuminate\Support\ServiceProvider
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
        // Register policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Major::class, MajorPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Club::class, ClubPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
        Gate::policy(MajorComment::class, CommentPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        // Share footer links across all views (Blade layouts + Inertia root)
        $shareFooter = function ($view) {
            $footerLinks = FooterLink::orderBy('order')->get();
            $view->with('footerLinks', $footerLinks);
        };
        View::composer('layouts.app', $shareFooter);
        View::composer('app', $shareFooter);

        // Pagination personnalisée (sans Tailwind) pour tout le site
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');

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
