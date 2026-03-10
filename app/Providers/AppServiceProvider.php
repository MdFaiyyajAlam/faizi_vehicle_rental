<?php

namespace App\Providers;

use App\Repositories\Contracts\VehicleCategoryRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use App\Repositories\Eloquent\VehicleCategoryRepository;
use App\Repositories\Eloquent\VehicleRepository;
use App\Services\Contracts\VehicleCategoryServiceInterface;
use App\Services\Contracts\VehicleServiceInterface;
use App\Services\VehicleCategoryService;
use App\Services\VehicleService;
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
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(VehicleServiceInterface::class, VehicleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
