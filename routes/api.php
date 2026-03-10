<?php

use App\Http\Controllers\Api\VehicleCategoryApiController;
use App\Http\Controllers\Api\VehicleApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/vehicle-categories')->group(function () {
    Route::get('/', [VehicleCategoryApiController::class, 'index']);
    Route::get('/trash', [VehicleCategoryApiController::class, 'trashed']);
    Route::get('/{id}', [VehicleCategoryApiController::class, 'show']);
    Route::post('/', [VehicleCategoryApiController::class, 'store']);
    Route::put('/{id}', [VehicleCategoryApiController::class, 'update']);
    Route::delete('/{id}', [VehicleCategoryApiController::class, 'destroy']);
    Route::patch('/trash/{id}/restore', [VehicleCategoryApiController::class, 'restore']);
    Route::delete('/trash/{id}/force-delete', [VehicleCategoryApiController::class, 'forceDelete']);
});

Route::prefix('v1/vehicles')->group(function () {
    Route::get('/', [VehicleApiController::class, 'index']);
    Route::get('/trash', [VehicleApiController::class, 'trashed']);
    Route::get('/{id}', [VehicleApiController::class, 'show']);
    Route::post('/', [VehicleApiController::class, 'store']);
    Route::put('/{id}', [VehicleApiController::class, 'update']);
    Route::delete('/{id}', [VehicleApiController::class, 'destroy']);
    Route::patch('/trash/{id}/restore', [VehicleApiController::class, 'restore']);
    Route::delete('/trash/{id}/force-delete', [VehicleApiController::class, 'forceDelete']);
});
