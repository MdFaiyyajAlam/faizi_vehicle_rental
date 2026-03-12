<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============ CREATE PERMISSIONS ============
        $permissions = [
            // User Management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            // Role Management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',

            // Permission Management
            'view_permissions',
            'assign_permissions',

            // Vehicle Management
            'view_vehicles',
            'create_vehicles',
            'edit_vehicles',
            'delete_vehicles',
            'verify_vehicles',
            'feature_vehicles',

            // Category Management
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',

            // Booking Management
            'view_bookings',
            'create_bookings',
            'edit_bookings',
            'cancel_bookings',
            'approve_bookings',
            'complete_bookings',

            // Availability Management
            'view_availabilities',
            'create_availabilities',
            'edit_availabilities',
            'delete_availabilities',

            // Payment Management
            'view_payments',
            'process_payments',
            'refund_payments',

            // Review Management
            'view_reviews',
            'create_reviews',
            'approve_reviews',
            'delete_reviews',



            // Dashboard Access
            'access_admin_dashboard',
            'access_vendor_dashboard',
            'access_customer_dashboard',
            'access_driver_dashboard',

            // Reports
            'view_reports',
            'generate_reports',
            'export_reports',

            // Settings
            'manage_settings',
            'manage_website_settings',
            'manage_payment_settings',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // ============ CREATE ROLES ============

        // Super Admin Role (All Permissions)
        $superAdminRole = Role::findOrCreate('super-admin', 'web');
        $superAdminRole->syncPermissions(Permission::all());

        // Admin Role
        $adminRole = Role::findOrCreate('admin', 'web');
        $adminRole->syncPermissions([
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_vehicles',
            'verify_vehicles',
            'feature_vehicles',
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            'view_availabilities',
            'create_availabilities',
            'edit_availabilities',
            'delete_availabilities',
            'view_bookings',
            'approve_bookings',
            'complete_bookings',
            'view_payments',
            'process_payments',
            'refund_payments',
            'view_reviews',
            'approve_reviews',
            'delete_reviews',
            'access_admin_dashboard',
            'view_reports',
            'generate_reports',
        ]);

        // Vendor Role
        $vendorRole = Role::findOrCreate('vendor', 'web');
        $vendorRole->syncPermissions([
            'view_vehicles',
            'create_vehicles',
            'edit_vehicles',
            'delete_vehicles',
            'view_availabilities',
            'create_availabilities',
            'edit_availabilities',
            'delete_availabilities',
            'view_bookings',
            'create_bookings',
            'edit_bookings',
            'cancel_bookings',
            'view_payments',
            'view_reviews',
            'access_vendor_dashboard',
            'view_reports',
        ]);

        // Customer Role
        $customerRole = Role::findOrCreate('customer', 'web');
        $customerRole->syncPermissions([
            'view_vehicles',
            'view_bookings',
            'create_bookings',
            'cancel_bookings',
            'view_payments',
            'create_reviews',
            'access_customer_dashboard',
        ]);

        // Driver Role
        $driverRole = Role::findOrCreate('driver', 'web');
        $driverRole->syncPermissions([
            'view_bookings',
            'edit_bookings',
            'complete_bookings',
            'access_driver_dashboard',
        ]);

        // ============ ASSIGN ROLES TO EXISTING USERS ============

        // Assign Super Admin to first user (if exists)
        $superAdmin = User::where('email', 'admin@example.com')->first();
        if ($superAdmin) {
            $superAdmin->assignRole('super-admin');
        }

        // Assign roles based on existing 'role' field
        $users = User::all();
        foreach ($users as $user) {
            // Skip if already has role
            if ($user->roles->count() > 0) {
                continue;
            }

            // Map your existing role field to spatie roles
            switch ($user->role) {
                case 'admin':
                    $user->assignRole('admin');
                    break;
                case 'vendor':
                    $user->assignRole('vendor');
                    break;
                case 'driver':
                    $user->assignRole('driver');
                    break;
                case 'customer':
                default:
                    $user->assignRole('customer');
                    break;
            }
        }
    }
}
