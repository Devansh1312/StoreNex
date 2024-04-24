<?php

namespace App\Providers;

use App\Models\SystemSetting;
use App\Models\ProductCategory;
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
    

    public function boot()
    {
        View::composer('*', function ($view) {
            $systemSetting = SystemSetting::first();
            $view->with('SystemSetting', $systemSetting);
            $categoriesWithSubcategories = ProductCategory::with('subcategories')->get();
            $view->with('categoriesWithSubcategories', $categoriesWithSubcategories);
        });
    }
}