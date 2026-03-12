<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor = User::query()->where('role', 'vendor')->first()
            ?? User::query()->updateOrCreate(
                ['email' => 'seedvendor@example.com'],
                [
                    'name' => 'Seed Vendor',
                    'phone' => '9000000000',
                    'password' => Hash::make('password'),
                    'role' => 'vendor',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

        $categories = VehicleCategory::query()->orderBy('id')->get();

        if ($categories->isEmpty()) {
            return;
        }

        $featurePool = ['AC', 'GPS', 'Music System', 'Airbags', 'ABS', 'Power Steering', 'Fast Charging', 'Reverse Camera'];
        $cityStatePool = [
            ['Patna', 'Bihar'],
            ['Ranchi', 'Jharkhand'],
            ['Kolkata', 'West Bengal'],
            ['Lucknow', 'Uttar Pradesh'],
            ['Jaipur', 'Rajasthan'],
            ['Bhubaneswar', 'Odisha'],
            ['Mumbai', 'Maharashtra'],
            ['Delhi', 'Delhi'],
        ];

        foreach ($categories as $category) {
            $profile = $this->categoryProfile($category->name);

            for ($i = 1; $i <= 10; $i++) {
                [$brand, $model] = $profile['brands'][($i - 1) % count($profile['brands'])];
                [$city, $state] = $cityStatePool[($i + $category->id) % count($cityStatePool)];

                $seedBase = 'vehicles/seeder/category-'.$category->id.'/vehicle-'.$i;
                $thumbnail = $this->createSeedImage($seedBase.'/thumb.svg', $brand.' '.$model);
                $images = [
                    $this->createSeedImage($seedBase.'/image-1.svg', $brand.' Front'),
                    $this->createSeedImage($seedBase.'/image-2.svg', $brand.' Side'),
                    $this->createSeedImage($seedBase.'/image-3.svg', $brand.' Interior'),
                ];

                $documents = [
                    $this->createSeedTextFile($seedBase.'/rc.txt', 'RC copy for '.$brand.' '.$model),
                    $this->createSeedTextFile($seedBase.'/insurance.txt', 'Insurance copy for '.$brand.' '.$model),
                ];

                $registration = strtoupper(sprintf(
                    'BR%02d%s%04d',
                    ($category->id % 90) + 10,
                    Str::upper(Str::substr(Str::slug($category->name, ''), 0, 2)),
                    $i
                ));

                Vehicle::query()->updateOrCreate(
                    ['registration_number' => $registration],
                    [
                        'vendor_id' => $vendor->id,
                        'category_id' => $category->id,
                        'brand' => $brand,
                        'model' => $model.' '.$i,
                        'year' => 2016 + ($i % 10),
                        'chassis_number' => strtoupper('CHS'.$category->id.$i.Str::random(6)),
                        'engine_number' => strtoupper('ENG'.$category->id.$i.Str::random(5)),
                        'color' => ['White', 'Black', 'Silver', 'Blue', 'Red'][($i + $category->id) % 5],
                        'seating_capacity' => $this->seedSeatCount($profile['seat_min'], $profile['seat_max'], $i),
                        'fuel_type' => $profile['fuels'][($i - 1) % count($profile['fuels'])],
                        'transmission' => $profile['transmissions'][($i - 1) % count($profile['transmissions'])],
                        'price_per_hour' => (float) ($category->base_price_per_hour + ($i * 10)),
                        'price_per_day' => (float) ($category->base_price_per_day + ($i * 100)),
                        'price_per_week' => (float) ($category->base_price_per_week + ($i * 400)),
                        'security_deposit' => (float) ($category->security_deposit + ($i * 50)),
                        'features' => array_values(array_unique(array_merge($category->features ?? [], [
                            $featurePool[$i % count($featurePool)],
                            $featurePool[($i + 2) % count($featurePool)],
                        ]))),
                        'images' => $images,
                        'thumbnail' => $thumbnail,
                        'description' => $brand.' '.$model.' '.$i.' is a seeded vehicle for '.$category->name.' category.',
                        'documents' => $documents,
                        'status' => $i % 7 === 0 ? 'maintenance' : ($i % 5 === 0 ? 'booked' : 'available'),
                        'location_coordinates' => [
                            'lat' => 25.0 + (($category->id + $i) / 10),
                            'lng' => 85.0 + (($category->id + $i) / 10),
                        ],
                        'city' => $city,
                        'state' => $state,
                        'address' => 'Seed address '.$i.', '.$city.', '.$state,
                        'total_bookings' => $i * 3,
                        'average_rating' => min(5, 3.5 + ($i / 10)),
                        'total_reviews' => $i * 2,
                        'is_verified' => $i % 2 === 0,
                        'is_featured' => $i % 3 === 0,
                    ]
                );
            }
        }
    }

    private function createSeedImage(string $path, string $label): string
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="700" viewBox="0 0 1200 700">
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#1d4ed8"/>
      <stop offset="100%" stop-color="#0f172a"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="700" fill="url(#g)"/>
  <text x="50%" y="50%" text-anchor="middle" fill="#ffffff" font-size="48" font-family="Arial, sans-serif">{$label}</text>
</svg>
SVG;

            $disk->put($path, $svg);
        }

        return $path;
    }

    private function createSeedTextFile(string $path, string $content): string
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            $disk->put($path, $content);
        }

        return $path;
    }

    private function seedSeatCount(int $min, int $max, int $index): int
    {
        if ($max <= $min) {
            return $min;
        }

        $range = $max - $min + 1;

        return $min + (($index - 1) % $range);
    }

    private function categoryProfile(string $categoryName): array
    {
        return match (Str::lower(trim($categoryName))) {
            'truck' => [
                'brands' => [
                    ['Tata', 'Signa'], ['Ashok Leyland', 'Boss'], ['Eicher', 'Pro'], ['Mahindra', 'Blazo'],
                ],
                'fuels' => ['Diesel', 'CNG'],
                'transmissions' => ['Manual'],
                'seat_min' => 2,
                'seat_max' => 3,
            ],
            'bus' => [
                'brands' => [
                    ['Tata', 'Starbus'], ['Ashok Leyland', 'Viking'], ['Eicher', 'Skyline'], ['BharatBenz', 'Tourer'],
                ],
                'fuels' => ['Diesel', 'CNG'],
                'transmissions' => ['Manual', 'Automatic'],
                'seat_min' => 20,
                'seat_max' => 50,
            ],
            'car' => [
                'brands' => [
                    ['Maruti', 'Swift'], ['Hyundai', 'Verna'], ['Honda', 'City'], ['Toyota', 'Innova'], ['Kia', 'Seltos'],
                ],
                'fuels' => ['Petrol', 'Diesel', 'CNG', 'Hybrid', 'Electric'],
                'transmissions' => ['Manual', 'Automatic'],
                'seat_min' => 4,
                'seat_max' => 8,
            ],
            'auto' => [
                'brands' => [
                    ['Bajaj', 'RE'], ['TVS', 'King'], ['Piaggio', 'Ape'], ['Mahindra', 'Alfa'],
                ],
                'fuels' => ['CNG', 'Petrol', 'Electric'],
                'transmissions' => ['Manual'],
                'seat_min' => 3,
                'seat_max' => 4,
            ],
            'motorcycle' => [
                'brands' => [
                    ['Hero', 'Splendor'], ['Honda', 'Shine'], ['Bajaj', 'Pulsar'], ['TVS', 'Apache'], ['Yamaha', 'FZ'],
                ],
                'fuels' => ['Petrol', 'Electric'],
                'transmissions' => ['Manual'],
                'seat_min' => 2,
                'seat_max' => 2,
            ],
            'by cycle', 'bicycle', 'cycle' => [
                'brands' => [
                    ['Hero', 'Sprint'], ['Firefox', 'Road Runner'], ['Montra', 'Downtown'], ['Btwin', 'Riverside'],
                ],
                'fuels' => ['Electric'],
                'transmissions' => ['Manual'],
                'seat_min' => 1,
                'seat_max' => 1,
            ],
            default => [
                'brands' => [
                    ['Tata', 'Mover'], ['Mahindra', 'Transit'], ['Toyota', 'Mobility'], ['Honda', 'Drive'],
                ],
                'fuels' => ['Petrol', 'Diesel', 'Electric'],
                'transmissions' => ['Manual', 'Automatic'],
                'seat_min' => 2,
                'seat_max' => 6,
            ],
        };
    }
}
