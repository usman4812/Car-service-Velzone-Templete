<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Permissions First
        $this->call(PermissionSeeder::class);

        // Then Seed Roles (which will assign permissions)
        $this->call(RoleSeeder::class);

        // Then seed admin user
        $this->call(adminSeeder::class);

        $this->call(CarManufactureSeeder::class);
    }
}
