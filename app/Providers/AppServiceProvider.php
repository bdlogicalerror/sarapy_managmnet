<?php

namespace App\Providers;

use App\Option;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        date_default_timezone_set('Asia/Dhaka');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
