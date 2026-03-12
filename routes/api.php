<?php

use App\Http\Controllers\Api\VehicleCategoryApiController;
use App\Http\Controllers\Api\VehicleApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1/vehicle-categories')->group(function () {
    Route::middleware('permission:view_categories')->group(function () {
        Route::get('/', [VehicleCategoryApiController::class, 'index']);
        Route::get('/trash', [VehicleCategoryApiController::class, 'trashed']);
        Route::get('/{id}', [VehicleCategoryApiController::class, 'show']);
    });

    Route::middleware('permission:create_categories')->group(function () {
        Route::post('/', [VehicleCategoryApiController::class, 'store']);
    });

    Route::middleware('permission:edit_categories')->group(function () {
        Route::put('/{id}', [VehicleCategoryApiController::class, 'update']);
    });

    Route::middleware('permission:delete_categories')->group(function () {
        Route::delete('/{id}', [VehicleCategoryApiController::class, 'destroy']);
        Route::patch('/trash/{id}/restore', [VehicleCategoryApiController::class, 'restore']);
        Route::delete('/trash/{id}/force-delete', [VehicleCategoryApiController::class, 'forceDelete']);
    });
});

Route::middleware('auth:sanctum')->prefix('v1/vehicles')->group(function () {
    Route::middleware('permission:view_vehicles')->group(function () {
        Route::get('/', [VehicleApiController::class, 'index']);
        Route::get('/trash', [VehicleApiController::class, 'trashed']);
        Route::get('/{id}', [VehicleApiController::class, 'show']);
    });

    Route::middleware('permission:create_vehicles')->group(function () {
        Route::post('/', [VehicleApiController::class, 'store']);
    });

    Route::middleware('permission:edit_vehicles')->group(function () {
        Route::put('/{id}', [VehicleApiController::class, 'update']);
    });

    Route::middleware('permission:delete_vehicles')->group(function () {
        Route::delete('/{id}', [VehicleApiController::class, 'destroy']);
        Route::patch('/trash/{id}/restore', [VehicleApiController::class, 'restore']);
        Route::delete('/trash/{id}/force-delete', [VehicleApiController::class, 'forceDelete']);
    });
});
