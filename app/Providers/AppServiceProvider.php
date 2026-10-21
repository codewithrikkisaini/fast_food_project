<?php

namespace App\Providers;

use App\Services\RestaurantDataService;
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
        View::composer('*', function ($view) {
            try {
                $siteSettings = app(RestaurantDataService::class)->getSiteSettings();
                $view->with('siteSettings', $siteSettings);
            } catch (\Throwable $e) {
                $view->with('siteSettings', [
                    'restaurant_name' => 'Fast Food',
                    'phone' => '+1 (800) 123-4567',
                    'email' => 'hello@fastfood.com',
                    'address' => '42 Flavor Street, Manhattan, NY 10001',
                    'hours' => 'Wed - Sun: 09 AM - 11 PM',
                    'announcement' => 'Free Delivery Today on Orders Over $25!',
                    'facebook' => 'https://facebook.com',
                    'instagram' => 'https://instagram.com',
                    'twitter' => 'https://twitter.com',
                    'youtube' => 'https://youtube.com',
                    'tiktok' => 'https://tiktok.com',
                    'footer_desc' => "We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love."
                ]);
            }
        });
    }
}
