<?php

namespace App\Providers;

use App\Models\Promotion;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        View::composer(['layout.home', 'layout/home'], function ($view) {
            if (!Schema::hasTable('promotions')) {
                return;
            }

            $activePromotions = Promotion::displayable()
                ->orderByDesc('start_at')
                ->orderByDesc('created_at')
                ->get();

            $view->with('activePromotions', $activePromotions);
        });
    }
}
