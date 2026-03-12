<?php

namespace App\Providers;

use App\Repositories\Contracts\VehicleCategoryRepositoryInterface;
use App\Repositories\Contracts\VehicleAvailabilityRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\VehicleCategoryRepository;
use App\Repositories\Eloquent\VehicleAvailabilityRepository;
use App\Repositories\Eloquent\VehicleRepository;
use App\Services\BookingService;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\VehicleCategoryServiceInterface;
use App\Services\Contracts\VehicleAvailabilityServiceInterface;
use App\Services\Contracts\VehicleServiceInterface;
use App\Services\VehicleCategoryService;
use App\Services\VehicleAvailabilityService;
use App\Services\VehicleService;
use Illuminate\Support\Facades\Gate;
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
        $this->app->bind(VehicleAvailabilityRepositoryInterface::class, VehicleAvailabilityRepository::class);
        $this->app->bind(VehicleAvailabilityServiceInterface::class, VehicleAvailabilityService::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(BookingServiceInterface::class, BookingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, string $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
