<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log; // Optional: For logging if a variable is missing
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the 'superadmin' role. This assumes RoleSeeder has run.
        $superadminRole = Role::where('name', 'superadmin')->first();
        $superadminEmail = env('SUPERADMIN_EMAIL', 'superadmin@default.com'); // Provide a default in case it's missing
        $superadminPassword = env('SUPERADMIN_PASSWORD', 'password'); // Provide a default in case it's missing

        // Optional: Basic validation to ensure values are not defaults in production
        if (app()->environment('production') && ($superadminEmail === 'superadmin@default.com' || $superadminPassword === 'password')) {
            Log::warning('Superadmin credentials in .env are using default values in production. Please update SUPERADMIN_EMAIL and SUPERADMIN_PASSWORD.');
        }

        // IMPORTANT: Check if the role exists. If not, inform the user.
        if (!$superadminRole) {
            $this->command->error('Superadmin role not found. Please ensure RoleSeeder runs before SuperAdminSeeder.');
            return; // Stop execution if the role isn't found
        }

        // Create the superadmin user only if an admin with this email doesn't already exist
        if (User::where('email', 'superadmin@example.com')->doesntExist()) {
            User::create([
                'name' => 'Super Admin',
                'email' => $superadminEmail,
                'password' => Hash::make($superadminPassword),
                'role_id' => $superadminRole->id, // Assign the ID of the superadmin role
            ]);
            $this->command->info('Super Admin user created successfully!');
        } else {
            $this->command->info('Super Admin user already exists. Skipping creation.');
        }
    }
}
