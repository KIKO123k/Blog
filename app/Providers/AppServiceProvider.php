<?php

namespace App\Providers;

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
        // Share footer links across all views using the layout
        View::composer('layouts.app', function ($view) {
            $footerLinks = FooterLink::orderBy('order')->get();
            $view->with('footerLinks', $footerLinks);
        });
    }
}
