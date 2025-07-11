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
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('merchant')
                ->as('merchant.')
                ->group(base_path('routes/merchant.php'));
            Route::middleware('web')
                ->prefix('user')
                ->as('customer.')
                ->group(base_path('routes/user.php'));

            // Route::middleware('web')
            //     ->prefix('seller')
            //     ->as('seller.')
            //     // ->middleware('sellers')
            //     ->group(base_path('routes/seller.php'));

            // Route::middleware('web')
            //     ->prefix('restaurant')
            //     ->as('restaurant.')
            //     // ->middleware('sellers')
            //     ->group(base_path('routes/seller.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->as('admin.')
                ->group(base_path('routes/admin.php'));

            // Route::middleware('web')
            //     ->prefix('checker')
            //     ->as('checker.')
            //     ->group(base_path('routes/checker.php'));
            // Route::middleware('web')->prefix('employee')->as('employee.')->group(base_path('routes/employee.php'));
        });
    }
}
