<?php

namespace App\Providers;

use App\Services\LectureService;
use Illuminate\Support\ServiceProvider;

class LectureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LectureService::class, function ($app) {
            return new LectureService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
