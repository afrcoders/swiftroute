<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('booking', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        $deliveriesDomain = config('app.deliveries_domain', 'deliveries.experienceterranova.test');

        $this->routes(function () use ($deliveriesDomain) {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Deliveries subdomain — admin routes
            Route::middleware('web')
                ->domain($deliveriesDomain)
                ->group(base_path('routes/admin.php'));

            // Deliveries subdomain — public booking routes
            Route::middleware('web')
                ->domain($deliveriesDomain)
                ->group(base_path('routes/deliveries.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
