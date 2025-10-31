<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions for all modules
        $permissions = [
            // Dashboard
            'view-dashboard',

            // Job Cards
            'view-job-card',
            'create-job-card',
            'edit-job-card',
            'delete-job-card',
            'view-job-card-invoice',

            // Customers
            'view-customer',
            'create-customer',
            'edit-customer',
            'delete-customer',

            // Categories
            'view-category',
            'create-category',
            'edit-category',
            'delete-category',

            // Sub Categories
            'view-sub-category',
            'create-sub-category',
            'edit-sub-category',
            'delete-sub-category',

            // Car Manufactures
            'view-car-manufacture',
            'create-car-manufacture',
            'edit-car-manufacture',
            'delete-car-manufacture',

            // Blog
            'view-blog',
            'create-blog',
            'edit-blog',
            'delete-blog',

            // Products
            'view-product',
            'create-product',
            'edit-product',
            'delete-product',

            // Reports
            'view-report',

            // Replacements
            'view-replacement',
            'create-replacement',
            'edit-replacement',
            'delete-replacement',

            // Contacts
            'view-contact',
            'create-contact',
            'edit-contact',
            'delete-contact',

            // Services
            'view-service',
            'create-service',
            'edit-service',
            'delete-service',

            // Workers
            'view-worker',
            'create-worker',
            'edit-worker',
            'delete-worker',

            // Works
            'view-work',
            'create-work',
            'edit-work',
            'delete-work',

            // Sales Persons
            'view-sales-person',
            'create-sales-person',
            'edit-sales-person',
            'delete-sales-person',

            // Users
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',

            // Roles & Permissions
            'view-role',
            'create-role',
            'edit-role',
            'delete-role',
            'view-permission',
            'assign-role',
            'assign-permission',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        $this->command->info('Permissions created successfully!');
    }
}
