<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Skripsi;
use App\Observers\SkripsiObserver;

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
        Skripsi::observe(SkripsiObserver::class);
    }
}
