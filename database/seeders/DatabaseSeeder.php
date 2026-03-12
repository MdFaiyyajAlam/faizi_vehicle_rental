<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            VehicleCategorySeeder::class,
        ]);

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'role' => 'admin',
                'spatie_role' => 'super-admin',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'spatie_role' => 'admin',
            ],
            [
                'name' => 'Vendor User',
                'email' => 'vendor@example.com',
                'role' => 'vendor',
                'spatie_role' => 'vendor',
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'role' => 'customer',
                'spatie_role' => 'customer',
            ],
            [
                'name' => 'Driver User',
                'email' => 'driver@example.com',
                'role' => 'driver',
                'spatie_role' => 'driver',
            ],
        ];

        foreach ($users as $seedUser) {
            $user = User::updateOrCreate(
                ['email' => $seedUser['email']],
                [
                    'name' => $seedUser['name'],
                    'role' => $seedUser['role'],
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ]
            );

            $user->syncRoles([$seedUser['spatie_role']]);
        }
    }
}
