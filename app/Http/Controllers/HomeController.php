<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        if (! Schema::hasTable('vehicle_categories') || ! Schema::hasTable('vehicles')) {
            return view('welcome', [
                'categories' => collect(),
                'featuredVehicles' => collect(),
            ]);
        }

        $categories = VehicleCategory::query()
            ->where('is_active', true)
            ->with(['vehicles' => function ($query) {
                $query->where('status', 'available')
                    ->orderByDesc('is_featured')
                    ->orderBy('price_per_day')
                    ->take(8);
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredVehicles = Vehicle::query()
            ->with('category:id,name')
            ->where('status', 'available')
            ->where('is_featured', true)
            ->orderBy('price_per_day')
            ->take(6)
            ->get();

        return view('welcome', compact('categories', 'featuredVehicles'));
    }
}
