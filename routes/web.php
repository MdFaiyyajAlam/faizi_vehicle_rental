<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('vehicle-categories')->name('vehicle-categories.')->group(function () {
        Route::get('/', [VehicleCategoryController::class, 'index'])->name('index');
        Route::get('/create', [VehicleCategoryController::class, 'create'])->name('create');
        Route::post('/', [VehicleCategoryController::class, 'store'])->name('store');
        Route::get('/trash/list', [VehicleCategoryController::class, 'trashed'])->name('trashed');
        Route::patch('/trash/{id}/restore', [VehicleCategoryController::class, 'restore'])->name('restore');
        Route::delete('/trash/{id}/force-delete', [VehicleCategoryController::class, 'forceDelete'])->name('force-delete');
        Route::get('/{id}', [VehicleCategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [VehicleCategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VehicleCategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [VehicleCategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('index');
        Route::get('/create', [VehicleController::class, 'create'])->name('create');
        Route::post('/', [VehicleController::class, 'store'])->name('store');
        Route::get('/trash/list', [VehicleController::class, 'trashed'])->name('trashed');
        Route::patch('/trash/{id}/restore', [VehicleController::class, 'restore'])->name('restore');
        Route::delete('/trash/{id}/force-delete', [VehicleController::class, 'forceDelete'])->name('force-delete');
        Route::get('/{id}', [VehicleController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [VehicleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VehicleController::class, 'update'])->name('update');
        Route::delete('/{id}', [VehicleController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
