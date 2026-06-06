<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Organization;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Member;
use App\Models\Resident;
use App\Models\Property;
use App\Models\Ticket;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\AppVendor;
use App\Models\Gallery;
use App\Models\Donor;
use App\Models\Sponsor;
use App\Models\Registry;
use App\Models\Maintenance;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Create Organization (RWA)
        $organization = Organization::create([
            'name' => 'Green Valley Resident Welfare Association',
            'address' => $faker->address,
            'registration_code' => 'GV-RWA-001',
            'subdomain' => 'greenvalley',
            'status' => 'approved',
            'primary_color' => '#2e7d32',
            'secondary_color' => '#81c784',
            'logo_url' => 'https://via.placeholder.com/150x50?text=Green+Valley+RWA',
        ]);

        $orgId = $organization->id;
        $password = Hash::make('password');

        $this->command->info('Creating 20 Admins...');
        for ($i = 0; $i < 20; $i++) {
            Admin::create([
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => $password,
                'mobile_number' => $faker->numerify('##########'),
                'is_id_verified' => $faker->boolean(80),
                'organization_id' => $orgId,
                'role' => $i === 0 ? 'admin' : 'sub-admin',
            ]);
        }

        $this->command->info('Creating 20 Staff...');
        for ($i = 0; $i < 20; $i++) {
            Staff::create([
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => $password,
                'mobile_number' => $faker->numerify('##########'),
                'is_id_verified' => $faker->boolean(80),
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Members...');
        $members = [];
        for ($i = 0; $i < 20; $i++) {
            $members[] = Member::create([
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => $password,
                'address' => $faker->streetAddress,
                'phone' => $faker->numerify('##########'),
                'is_deed_verified_staff' => $faker->boolean(90),
                'is_deed_verified_admin' => $faker->boolean(90),
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Residents...');
        $residents = [];
        for ($i = 0; $i < 20; $i++) {
            $residents[] = Resident::create([
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => $password,
                'address' => $faker->streetAddress,
                'mobile_number' => $faker->numerify('##########'),
                'organization_id' => $orgId,
                'is_rent_agreement_verified_staff' => $faker->boolean(90),
                'is_rent_agreement_verified_admin' => $faker->boolean(90),
            ]);
        }

        $this->command->info('Creating 20 Vendors...');
        for ($i = 0; $i < 20; $i++) {
            AppVendor::create([
                'business_name' => $faker->unique()->company,
                'email' => $faker->unique()->companyEmail,
                'password' => $password,
                'is_gst_verified_staff' => $faker->boolean(70),
                'is_gst_verified_admin' => $faker->boolean(70),
            ]);
        }

        $this->command->info('Creating 20 Properties...');
        for ($i = 0; $i < 20; $i++) {
            Property::create([
                'address' => 'A-' . $faker->unique()->numberBetween(100, 9999),
                'type' => $faker->randomElement(['Flat', 'Villa', 'Penthouse']),
                'owner_id' => $faker->randomElement($members)->id,
                'resident_id' => $faker->boolean(70) ? $faker->randomElement($residents)->id : null,
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Announcements (Notices)...');
        for ($i = 0; $i < 20; $i++) {
            Announcement::create([
                'announcement_subject' => $faker->sentence(6),
                'announcement_text' => $faker->paragraph(3),
                'announcement_status' => $faker->boolean(80) ? 1 : 0,
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Events...');
        for ($i = 0; $i < 20; $i++) {
            Event::create([
                'title' => $faker->sentence(4),
                'description' => $faker->paragraph(2),
                'event_date' => $faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
                'event_time' => $faker->time('H:i:s'),
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Gallery Images...');
        for ($i = 0; $i < 20; $i++) {
            Gallery::create([
                'title' => $faker->words(3, true),
                'image_url' => 'https://via.placeholder.com/600x400?text=Event+' . $i,
                'description' => $faker->sentence,
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Donors...');
        for ($i = 0; $i < 20; $i++) {
            Donor::create([
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'amount' => $faker->randomFloat(2, 100, 5000),
                'donation_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Sponsors...');
        for ($i = 0; $i < 20; $i++) {
            Sponsor::create([
                'name' => $faker->company,
                'logo_url' => 'https://via.placeholder.com/150x150?text=Sponsor+' . $i,
                'description' => $faker->catchPhrase,
                'website_url' => $faker->url,
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Creating 20 Tickets (Helpdesk)...');
        for ($i = 0; $i < 20; $i++) {
            Ticket::create([
                'organization_id' => $orgId,
                'member_id' => $faker->randomElement($members)->id,
                'subject' => $faker->sentence(4),
                'description' => $faker->paragraph(2),
                'category' => $faker->randomElement(['Plumbing', 'Electrical', 'Maintenance', 'Security']),
                'status' => $faker->randomElement(['pending', 'in_progress', 'resolved']),
                'response' => $faker->boolean(50) ? $faker->sentence : null,
            ]);
        }

        $this->command->info('Creating 20 Visitor Registries...');
        for ($i = 0; $i < 20; $i++) {
            Registry::create([
                'visitor_name' => $faker->name,
                'host_id' => $faker->randomElement($members)->id,
                'visitor_contact' => $faker->numerify('##########'),
                'purpose' => $faker->sentence(3),
                'status' => $faker->randomElement(['Pending', 'Approved', 'Completed']),
                'organization_id' => $orgId,
            ]);
        }

        $this->command->info('Demo Data generation via Faker completed successfully.');
    }
}
