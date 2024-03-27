<?php

namespace App\Providers;



use App\Events\ProductUpdated;
use App\Listeners\SendProductUpdatedNotification;
use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\Event;
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
        //
    }
}
