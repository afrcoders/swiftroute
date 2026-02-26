<?php

namespace App\Providers;

use App\Repositories\Contracts\DeliveryRepositoryInterface;
use App\Repositories\DeliveryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DeliveryRepositoryInterface::class, DeliveryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
