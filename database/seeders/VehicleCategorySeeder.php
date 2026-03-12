<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [

            [
                'name' => 'Truck',
                'description' => 'Heavy vehicles used for goods transport and logistics.',
                'icon' => 'bi-truck',
                'features' => ['Heavy Load', 'Diesel', 'Commercial Use'],
                'base_price_per_hour' => 499,
                'base_price_per_day' => 4999,
                'base_price_per_week' => 29999,
                'security_deposit' => 15000,
                'min_booking_hours' => 4,
                'max_booking_days' => 15,
                'sort_order' => 1,
            ],

            [
                'name' => 'Bus',
                'description' => 'Passenger buses for group travel and tourism.',
                'icon' => 'bi-bus-front',
                'features' => ['30+ Seats', 'Diesel', 'Long Distance'],
                'base_price_per_hour' => 699,
                'base_price_per_day' => 6999,
                'base_price_per_week' => 41999,
                'security_deposit' => 20000,
                'min_booking_hours' => 6,
                'max_booking_days' => 10,
                'sort_order' => 2,
            ],

            [
                'name' => 'Car',
                'description' => 'Cars for personal travel and family trips.',
                'icon' => 'bi-car-front',
                'features' => ['AC', '5 Seater', 'Petrol/Diesel'],
                'base_price_per_hour' => 199,
                'base_price_per_day' => 1999,
                'base_price_per_week' => 11999,
                'security_deposit' => 5000,
                'min_booking_hours' => 2,
                'max_booking_days' => 30,
                'sort_order' => 3,
            ],

            [
                'name' => 'Auto',
                'description' => 'Three wheeler auto rickshaw for short city rides.',
                'icon' => 'bi-truck-front',
                'features' => ['3 Seater', 'City Ride', 'Low Fuel Cost'],
                'base_price_per_hour' => 99,
                'base_price_per_day' => 999,
                'base_price_per_week' => 5999,
                'security_deposit' => 2000,
                'min_booking_hours' => 2,
                'max_booking_days' => 30,
                'sort_order' => 4,
            ],

            [
                'name' => 'Motorcycle',
                'description' => 'Two wheelers for quick travel and delivery services.',
                'icon' => 'bi-bicycle',
                'features' => ['2 Seater', 'Petrol', 'Fast Mobility'],
                'base_price_per_hour' => 49,
                'base_price_per_day' => 499,
                'base_price_per_week' => 2499,
                'security_deposit' => 1500,
                'min_booking_hours' => 1,
                'max_booking_days' => 30,
                'sort_order' => 5,
            ],

            [
                'name' => 'By Cycle',
                'description' => 'Eco friendly bicycles for short distance travel.',
                'icon' => 'bi-bicycle',
                'features' => ['Single Rider', 'Eco Friendly'],
                'base_price_per_hour' => 10,
                'base_price_per_day' => 100,
                'base_price_per_week' => 500,
                'security_deposit' => 500,
                'min_booking_hours' => 1,
                'max_booking_days' => 30,
                'sort_order' => 6,
            ]

        ];

        foreach ($categories as $category) {

            VehicleCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category + [
                    'slug' => Str::slug($category['name']),
                    'is_active' => true
                ]
            );
        }
    }
}
