<?php

use App\Http\Controllers\Api\VehicleCategoryApiController;
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
