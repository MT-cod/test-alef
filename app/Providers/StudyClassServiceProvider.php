<?php

namespace App\Providers;

use App\Services\StudyClassService;
use Illuminate\Support\ServiceProvider;

class StudyClassServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StudyClassService::class, function ($app) {
            return new StudyClassService();
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
