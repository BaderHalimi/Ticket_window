<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SecurityHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Load the security helper functions
        require_once app_path('Helpers/SecurityHelper.php');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
