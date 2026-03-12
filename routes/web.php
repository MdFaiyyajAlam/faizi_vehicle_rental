<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleAvailabilityController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/vehicles/{vehicle}', [HomeController::class, 'showVehicle'])
    ->whereNumber('vehicle')
    ->name('home.vehicles.show');

Route::get('/book-now/{vehicle}', function (Vehicle $vehicle) {
    if (! auth()->check()) {
        return redirect()->guest(route('register'));
    }

    return redirect()->route('bookings.create', [
        'vehicle_id' => $vehicle->id,
        'vendor_id' => $vehicle->vendor_id,
    ]);
})->name('bookings.quick');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'permission:access_admin_dashboard|access_vendor_dashboard|access_customer_dashboard|access_driver_dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('users')
        ->name('users.')
        ->middleware('permission:view_users')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');

            Route::middleware('permission:create_users')->group(function () {
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
            });

            Route::middleware('permission:edit_users')->group(function () {
                Route::get('/{id}/edit', [UserController::class, 'edit'])
                    ->whereNumber('id')
                    ->name('edit');
                Route::put('/{id}', [UserController::class, 'update'])
                    ->whereNumber('id')
                    ->name('update');
            });

            Route::middleware('permission:delete_users')->group(function () {
                Route::delete('/{id}', [UserController::class, 'destroy'])
                    ->whereNumber('id')
                    ->name('destroy');
                Route::get('/trash/list', [UserController::class, 'trashed'])->name('trashed');
                Route::patch('/trash/{id}/restore', [UserController::class, 'restore'])
                    ->whereNumber('id')
                    ->name('restore');
                Route::delete('/trash/{id}/force-delete', [UserController::class, 'forceDelete'])
                    ->whereNumber('id')
                    ->name('force-delete');
            });

            Route::get('/{id}', [UserController::class, 'show'])
                ->whereNumber('id')
                ->name('show');
        });

    Route::prefix('vehicle-categories')
        ->name('vehicle-categories.')
        ->middleware('permission:view_categories')
        ->group(function () {
        Route::get('/', [VehicleCategoryController::class, 'index'])->name('index');

        Route::middleware('permission:create_categories')->group(function () {
            Route::get('/create', [VehicleCategoryController::class, 'create'])->name('create');
            Route::post('/', [VehicleCategoryController::class, 'store'])->name('store');
        });

        Route::middleware('permission:edit_categories')->group(function () {
            Route::get('/{id}/edit', [VehicleCategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [VehicleCategoryController::class, 'update'])->name('update');
        });

        Route::middleware('permission:delete_categories')->group(function () {
            Route::delete('/{id}', [VehicleCategoryController::class, 'destroy'])->name('destroy');
            Route::get('/trash/list', [VehicleCategoryController::class, 'trashed'])->name('trashed');
            Route::patch('/trash/{id}/restore', [VehicleCategoryController::class, 'restore'])->name('restore');
            Route::delete('/trash/{id}/force-delete', [VehicleCategoryController::class, 'forceDelete'])->name('force-delete');
        });

        Route::get('/{id}', [VehicleCategoryController::class, 'show'])
            ->whereNumber('id')
            ->name('show');
    });

    Route::prefix('vehicles')
        ->name('vehicles.')
        ->middleware('permission:view_vehicles')
        ->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('index');

        Route::middleware('permission:create_vehicles')->group(function () {
            Route::get('/create', [VehicleController::class, 'create'])->name('create');
            Route::post('/', [VehicleController::class, 'store'])->name('store');
        });

        Route::middleware('permission:edit_vehicles')->group(function () {
            Route::get('/{id}/edit', [VehicleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [VehicleController::class, 'update'])->name('update');
        });

        Route::middleware('permission:delete_vehicles')->group(function () {
            Route::delete('/{id}', [VehicleController::class, 'destroy'])->name('destroy');
            Route::get('/trash/list', [VehicleController::class, 'trashed'])->name('trashed');
            Route::patch('/trash/{id}/restore', [VehicleController::class, 'restore'])->name('restore');
            Route::delete('/trash/{id}/force-delete', [VehicleController::class, 'forceDelete'])->name('force-delete');
        });

        Route::get('/{id}', [VehicleController::class, 'show'])
            ->whereNumber('id')
            ->name('show');
    });

    Route::prefix('vehicle-availabilities')
        ->name('vehicle-availabilities.')
        ->middleware('permission:view_availabilities')
        ->group(function () {
            Route::get('/', [VehicleAvailabilityController::class, 'index'])->name('index');

            Route::middleware('permission:create_availabilities')->group(function () {
                Route::get('/create', [VehicleAvailabilityController::class, 'create'])->name('create');
                Route::post('/', [VehicleAvailabilityController::class, 'store'])->name('store');
            });

            Route::middleware('permission:edit_availabilities')->group(function () {
                Route::get('/{id}/edit', [VehicleAvailabilityController::class, 'edit'])
                    ->whereNumber('id')
                    ->name('edit');
                Route::put('/{id}', [VehicleAvailabilityController::class, 'update'])
                    ->whereNumber('id')
                    ->name('update');
            });

            Route::middleware('permission:delete_availabilities')->group(function () {
                Route::delete('/{id}', [VehicleAvailabilityController::class, 'destroy'])
                    ->whereNumber('id')
                    ->name('destroy');
            });
        });

    Route::prefix('bookings')
        ->name('bookings.')
        ->middleware('permission:view_bookings')
        ->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');

            Route::middleware('permission:create_bookings')->group(function () {
                Route::get('/create', [BookingController::class, 'create'])->name('create');
                Route::post('/', [BookingController::class, 'store'])->name('store');
            });

            Route::middleware('permission:edit_bookings')->group(function () {
                Route::get('/{id}/edit', [BookingController::class, 'edit'])
                    ->whereNumber('id')
                    ->name('edit');
                Route::put('/{id}', [BookingController::class, 'update'])
                    ->whereNumber('id')
                    ->name('update');
            });

            Route::middleware('permission:cancel_bookings')->group(function () {
                Route::delete('/{id}', [BookingController::class, 'destroy'])
                    ->whereNumber('id')
                    ->name('destroy');
            });

            Route::get('/{id}', [BookingController::class, 'show'])
                ->whereNumber('id')
                ->name('show');
        });

    Route::prefix('bookings/{booking}/payments')
        ->name('payments.')
        ->middleware('permission:view_bookings')
        ->group(function () {
            Route::get('/create', [PaymentController::class, 'create'])
                ->whereNumber('booking')
                ->name('create');

            Route::post('/', [PaymentController::class, 'store'])
                ->middleware('permission:create_bookings')
                ->whereNumber('booking')
                ->name('store');
        });
});

require __DIR__.'/auth.php';
