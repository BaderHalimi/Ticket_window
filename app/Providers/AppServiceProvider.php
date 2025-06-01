<?php

namespace App\Providers;

use Carbon\Carbon;
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
        // $timezone = config('app.timezone');

        // // مثال: لو المستخدم مسجل دخوله
        // if (auth()->check() && auth()->user()->timezone) {
        //     $timezone = auth()->user()->timezone;
        // }

        // // أو لو جاي من الـ Session (لو أنت بتمررها من الـ frontend مثلاً)
        // elseif (session()->has('client_timezone')) {
        //     $timezone = session('client_timezone');
        // }

        // // ضبط التايمزون للـ Laravel كله
        // date_default_timezone_set($timezone);
        // Carbon::setTimeZone($timezone);
    }
}
