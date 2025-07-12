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
        $this->call([
            RoleSeeder::class,      // This MUST run first to create the roles
            SuperAdminSeeder::class, // This can then assign roles to users
            ModalidadSeeder::class
        ]);
    }
}
