<?php

namespace App\Providers;

use App\Services\CourseService;
use App\Services\FileService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FileService::class);
        
        $this->app->singleton(CourseService::class, function ($app) {
           return new CourseService($app->make(FileService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
