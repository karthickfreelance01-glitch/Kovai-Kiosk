<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share site settings to all views
        View::composer('*', function ($view) {
            try {
                $settings = WebsiteSetting::all()->pluck('value', 'key');
                $navCategories = Category::where('is_active', true)->orderBy('sort_order')->get();
                $view->with('siteSettings', $settings);
                $view->with('navCategories', $navCategories);
            } catch (\Exception $e) {
                $view->with('siteSettings', collect());
                $view->with('navCategories', collect());
            }
        });
    }

    public function register(): void {}
}
