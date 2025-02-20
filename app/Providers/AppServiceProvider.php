<?php

namespace App\Providers;

use App\Repositories;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Repositories\UserRepositoryInterface::class, Repositories\UserRepository::class);
        $this->app->bind(Repositories\SizeRepositoryInterface::class, Repositories\SizeRepository::class);
        $this->app->bind(Repositories\CategoryRepositoryInterface::class, Repositories\CategoryRepository::class);
        $this->app->bind(Repositories\ColorRepositoryInterface::class, Repositories\ColorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
