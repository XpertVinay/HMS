<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the global Super Admin
        // Super Admins are global and do NOT belong to any specific organization.
        SuperAdmin::updateOrCreate(
            ['email' => 'sa@businzo.com'],
            [
                'username' => 'superadmin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // 2. (Optional) Create the master Businzo organization
        // Since you included organization fields in your DatabaseSeeder attempt, 
        // I have created the main organization here just in case you need it.
        Organization::updateOrCreate(
            ['subdomain' => 'businzo'],
            [
                'name' => 'Businzo Master',
                'address' => 'Businzo HQ',
                'registration_code' => 'REG-1234',
                'status' => 'approved',
                'primary_color' => '#2e7d32',
                'secondary_color' => '#81c784',
                'logo_url' => '/assets/images/businzo_logo.png',
            ]
        );
    }
}
