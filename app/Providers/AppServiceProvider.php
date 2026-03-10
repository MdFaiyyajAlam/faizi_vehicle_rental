<?php

namespace App\Providers;

use App\Repositories\Contracts\VehicleCategoryRepositoryInterface;
use App\Repositories\Eloquent\VehicleCategoryRepository;
use App\Services\Contracts\VehicleCategoryServiceInterface;
use App\Services\VehicleCategoryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VehicleCategoryRepositoryInterface::class, VehicleCategoryRepository::class);
        $this->app->bind(VehicleCategoryServiceInterface::class, VehicleCategoryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
