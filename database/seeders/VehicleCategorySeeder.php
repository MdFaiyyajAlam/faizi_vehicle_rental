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
                'name' => 'Hatchback',
                'description' => 'Compact city-friendly cars suitable for daily commuting.',
                'icon' => 'bi-car-front',
                'features' => ['AC', '5 Seater', 'Petrol', 'City Drive'],
                'base_price_per_hour' => 149.00,
                'base_price_per_day' => 1499.00,
                'base_price_per_week' => 8999.00,
                'security_deposit' => 3000.00,
                'min_booking_hours' => 2,
                'max_booking_days' => 30,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Sedan',
                'description' => 'Comfortable mid-size cars ideal for family and office trips.',
                'icon' => 'bi-car-front-fill',
                'features' => ['AC', '5 Seater', 'Petrol/Diesel', 'Comfort Ride'],
                'base_price_per_hour' => 199.00,
                'base_price_per_day' => 1999.00,
                'base_price_per_week' => 11999.00,
                'security_deposit' => 4000.00,
                'min_booking_hours' => 2,
                'max_booking_days' => 30,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'SUV',
                'description' => 'Spacious vehicles for long distance travel and rough roads.',
                'icon' => 'bi-truck',
                'features' => ['AC', '7 Seater', 'Diesel', 'High Ground Clearance'],
                'base_price_per_hour' => 299.00,
                'base_price_per_day' => 2999.00,
                'base_price_per_week' => 17999.00,
                'security_deposit' => 6000.00,
                'min_booking_hours' => 3,
                'max_booking_days' => 30,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Luxury',
                'description' => 'Premium vehicles for business class and special occasions.',
                'icon' => 'bi-stars',
                'features' => ['Premium Interior', 'Automatic', 'Top Safety', 'Chauffeur Optional'],
                'base_price_per_hour' => 699.00,
                'base_price_per_day' => 6999.00,
                'base_price_per_week' => 41999.00,
                'security_deposit' => 15000.00,
                'min_booking_hours' => 4,
                'max_booking_days' => 15,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Commercial Van',
                'description' => 'Useful for goods transport and business logistics needs.',
                'icon' => 'bi-truck-front',
                'features' => ['Large Cargo Space', 'Diesel', 'Heavy Duty', 'GPS Tracking'],
                'base_price_per_hour' => 349.00,
                'base_price_per_day' => 3499.00,
                'base_price_per_week' => 20999.00,
                'security_deposit' => 8000.00,
                'min_booking_hours' => 4,
                'max_booking_days' => 20,
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            VehicleCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category + ['slug' => Str::slug($category['name'])]
            );
        }
    }
}
