<?php

use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\VehicleAvailabilityApiController;
use App\Http\Controllers\Api\VehicleCategoryApiController;
use App\Http\Controllers\Api\VehicleApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::middleware('permission:view_users')->group(function () {
            Route::get('/', [UserApiController::class, 'index']);
            Route::get('/trash', [UserApiController::class, 'trashed']);
            Route::get('/{id}', [UserApiController::class, 'show'])
                ->whereNumber('id');
        });

        Route::middleware('permission:create_users')->group(function () {
            Route::post('/', [UserApiController::class, 'store']);
        });

        Route::middleware('permission:edit_users')->group(function () {
            Route::put('/{id}', [UserApiController::class, 'update'])
                ->whereNumber('id');
        });

        Route::middleware('permission:delete_users')->group(function () {
            Route::delete('/{id}', [UserApiController::class, 'destroy'])
                ->whereNumber('id');
            Route::patch('/trash/{id}/restore', [UserApiController::class, 'restore'])
                ->whereNumber('id');
            Route::delete('/trash/{id}/force-delete', [UserApiController::class, 'forceDelete'])
                ->whereNumber('id');
        });
    });

    Route::prefix('vehicle-categories')->group(function () {
        Route::middleware('permission:view_categories')->group(function () {
            Route::get('/', [VehicleCategoryApiController::class, 'index']);
            Route::get('/trash', [VehicleCategoryApiController::class, 'trashed']);
            Route::get('/{id}', [VehicleCategoryApiController::class, 'show'])
                ->whereNumber('id');
        });

        Route::middleware('permission:create_categories')->group(function () {
            Route::post('/', [VehicleCategoryApiController::class, 'store']);
        });

        Route::middleware('permission:edit_categories')->group(function () {
            Route::put('/{id}', [VehicleCategoryApiController::class, 'update'])
                ->whereNumber('id');
        });

        Route::middleware('permission:delete_categories')->group(function () {
            Route::delete('/{id}', [VehicleCategoryApiController::class, 'destroy'])
                ->whereNumber('id');
            Route::patch('/trash/{id}/restore', [VehicleCategoryApiController::class, 'restore'])
                ->whereNumber('id');
            Route::delete('/trash/{id}/force-delete', [VehicleCategoryApiController::class, 'forceDelete'])
                ->whereNumber('id');
        });
    });

    Route::prefix('vehicles')->group(function () {
        Route::middleware('permission:view_vehicles')->group(function () {
            Route::get('/', [VehicleApiController::class, 'index']);
            Route::get('/trash', [VehicleApiController::class, 'trashed']);
            Route::get('/{id}', [VehicleApiController::class, 'show'])
                ->whereNumber('id');
        });

        Route::middleware('permission:create_vehicles')->group(function () {
            Route::post('/', [VehicleApiController::class, 'store']);
        });

        Route::middleware('permission:edit_vehicles')->group(function () {
            Route::put('/{id}', [VehicleApiController::class, 'update'])
                ->whereNumber('id');
        });

        Route::middleware('permission:delete_vehicles')->group(function () {
            Route::delete('/{id}', [VehicleApiController::class, 'destroy'])
                ->whereNumber('id');
            Route::patch('/trash/{id}/restore', [VehicleApiController::class, 'restore'])
                ->whereNumber('id');
            Route::delete('/trash/{id}/force-delete', [VehicleApiController::class, 'forceDelete'])
                ->whereNumber('id');
        });
    });

    Route::prefix('vehicle-availabilities')->group(function () {
        Route::middleware('permission:view_availabilities')->group(function () {
            Route::get('/', [VehicleAvailabilityApiController::class, 'index']);
        });

        Route::middleware('permission:create_availabilities')->group(function () {
            Route::post('/', [VehicleAvailabilityApiController::class, 'store']);
        });

        Route::middleware('permission:edit_availabilities')->group(function () {
            Route::put('/{id}', [VehicleAvailabilityApiController::class, 'update'])
                ->whereNumber('id');
        });

        Route::middleware('permission:delete_availabilities')->group(function () {
            Route::delete('/{id}', [VehicleAvailabilityApiController::class, 'destroy'])
                ->whereNumber('id');
        });
    });

    Route::prefix('bookings')->group(function () {
        Route::middleware('permission:view_bookings')->group(function () {
            Route::get('/', [BookingApiController::class, 'index']);
            Route::get('/{id}', [BookingApiController::class, 'show'])
                ->whereNumber('id');
        });

        Route::middleware('permission:create_bookings')->group(function () {
            Route::post('/', [BookingApiController::class, 'store']);
        });

        Route::middleware('permission:edit_bookings')->group(function () {
            Route::put('/{id}', [BookingApiController::class, 'update'])
                ->whereNumber('id');
        });

        Route::middleware('permission:cancel_bookings')->group(function () {
            Route::delete('/{id}', [BookingApiController::class, 'destroy'])
                ->whereNumber('id');
        });
    });

    Route::prefix('bookings/{booking}/payments')->group(function () {
        Route::middleware('permission:view_bookings')->group(function () {
            Route::get('/create', [PaymentApiController::class, 'create'])
                ->whereNumber('booking');
        });

        Route::middleware('permission:create_bookings')->group(function () {
            Route::post('/', [PaymentApiController::class, 'store'])
                ->whereNumber('booking');
        });
    });
});
