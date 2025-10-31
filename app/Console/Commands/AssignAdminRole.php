<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:assign-role {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign admin role to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@gmail.com';
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        $adminRole = Role::where('name', 'admin')->first();
        
        if (!$adminRole) {
            $this->error("Admin role not found! Please run php artisan db:seed --class=RoleSeeder first.");
            return 1;
        }

        if ($user->hasRole('admin')) {
            $this->info("User {$email} already has admin role.");
            return 0;
        }

        $user->assignRole('admin');
        $this->info("Admin role assigned successfully to {$email}!");
        
        return 0;
    }
}
