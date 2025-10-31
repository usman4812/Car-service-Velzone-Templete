<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Get all permissions
        $allPermissions = Permission::all();

        // Admin: Assign all permissions
        $adminRole->syncPermissions($allPermissions);

        // Manager: Assign most permissions except user management and roles
        $managerPermissions = $allPermissions->reject(function ($permission) {
            return in_array($permission->name, [
                'view-user',
                'create-user',
                'edit-user',
                'delete-user',
                'view-role',
                'create-role',
                'edit-role',
                'delete-role',
                'view-permission',
                'assign-role',
                'assign-permission',
            ]);
        });
        $managerRole->syncPermissions($managerPermissions);

        // User: Assign view permissions only
        $userPermissions = $allPermissions->filter(function ($permission) {
            return str_starts_with($permission->name, 'view-');
        });
        $userRole->syncPermissions($userPermissions);

        $this->command->info('Roles created and permissions assigned successfully!');
        $this->command->info('- Admin: All permissions');
        $this->command->info('- Manager: All except user & role management');
        $this->command->info('- User: View permissions only');
    }
}
