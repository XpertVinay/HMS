<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call(SuperAdminSeeder::class);
        $this->call(IndustryPresetsSeeder::class);
        $this->call(RolePermissionSeeder::class);

        // Suppressed old demo data seeder
        // $this->call(DemoDataSeeder::class);

        // Run the new MultiOrg Demo Data seeder
        $this->call(MultiOrgDemoDataSeeder::class);
    }
}
