<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Organization;
use App\Models\TenantTheme;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Member;
use App\Models\Resident;
use App\Models\Property;
use App\Models\AppVendor;
use App\Models\VendorService;
use App\Models\ServiceBooking;
use App\Models\PlatformCommission;
use App\Models\CommunityPost;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Donor;
use App\Models\Sponsor;
use App\Models\Ticket;
use App\Models\Registry;
use Carbon\Carbon;

class MultiOrgDemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $password = Hash::make('password');

        $this->command->info('Starting Multi-Org Demo Data Generation...');

        // Create some default vendors to be shared or used randomly
        $this->command->info('Creating Vendors & Services...');
        $vendors = [];
        for ($i = 0; $i < 15; $i++) {
            $vendor = AppVendor::create([
                'business_name' => $faker->unique()->company,
                'email' => $faker->unique()->companyEmail,
                'password' => $password,
                'is_gst_verified_staff' => $faker->boolean(70),
                'is_gst_verified_admin' => $faker->boolean(70),
            ]);
            $vendors[] = $vendor;

            // Give them some services
            for ($s = 0; $s < 3; $s++) {
                VendorService::create([
                    'vendor_id' => $vendor->id,
                    'service_name' => $faker->randomElement(['Plumbing', 'Electrical Repair', 'Carpentry', 'Cleaning', 'Pest Control', 'Painting']) . ' - ' . $faker->word,
                    'description' => $faker->sentence,
                    'price' => $faker->randomFloat(2, 50, 500),
                ]);
            }
        }
        $vendorServices = VendorService::all();

        for ($orgIndex = 1; $orgIndex <= 10; $orgIndex++) {
            $this->command->info("Generating data for Organization #{$orgIndex}");
            
            // 1. Create Organization
            $organization = Organization::create([
                'name' => $faker->company . ' RWA',
                'address' => $faker->address,
                'registration_code' => 'ORG-' . strtoupper($faker->bothify('???-###')) . '-' . $orgIndex,
                'subdomain' => strtolower($faker->word) . '-' . $orgIndex,
                'status' => 'approved',
                'primary_color' => $faker->hexColor,
                'secondary_color' => $faker->hexColor,
                'logo_url' => 'https://via.placeholder.com/150x50?text=Org+' . $orgIndex,
            ]);
            $orgId = $organization->id;

            // 2. Create Theme Preset/Tenant Theme
            TenantTheme::create([
                'organization_id' => $orgId,
                'theme_slug' => 'theme-org-' . $orgIndex,
                'theme_name' => 'Custom Theme ' . $orgIndex,
                'is_active' => true,
                'primary_color' => $organization->primary_color,
                'secondary_color' => $organization->secondary_color,
                'background_primary' => '#ffffff',
                'text_primary' => '#0f172a',
                'theme_mode' => 'light',
                'theme_version' => '1.0.0',
            ]);

            // 3. Admins & Staff
            for ($i = 0; $i < 5; $i++) {
                Admin::create([
                    'username' => $faker->unique()->userName . $orgIndex,
                    'email' => "admin{$i}_org{$orgIndex}@example.com",
                    'password' => $password,
                    'mobile_number' => $faker->numerify('##########'),
                    'is_id_verified' => true,
                    'organization_id' => $orgId,
                    'role' => $i === 0 ? 'admin' : 'sub-admin',
                ]);

                Staff::create([
                    'username' => $faker->unique()->userName . $orgIndex,
                    'email' => "staff{$i}_org{$orgIndex}@example.com",
                    'password' => $password,
                    'mobile_number' => $faker->numerify('##########'),
                    'is_id_verified' => true,
                    'organization_id' => $orgId,
                ]);
            }

            // 4. Members, Residents, and Properties
            $members = [];
            $residents = [];
            
            for ($i = 0; $i < 20; $i++) {
                $address = 'Unit ' . $faker->numberBetween(100, 999) . ', ' . $faker->streetName;
                
                $member = Member::create([
                    'username' => $faker->unique()->userName . 'm' . $orgIndex,
                    'email' => "member{$i}_org{$orgIndex}@example.com",
                    'password' => $password,
                    'address' => $address, // Shared address with property
                    'phone' => $faker->numerify('##########'),
                    'is_deed_verified_staff' => true,
                    'is_deed_verified_admin' => true,
                    'organization_id' => $orgId,
                ]);
                $members[] = $member;

                $resident = null;
                // Sometimes member is also resident, sometimes different person is resident
                if ($faker->boolean(60)) {
                    $resident = Resident::create([
                        'username' => $faker->unique()->userName . 'r' . $orgIndex,
                        'email' => "resident{$i}_org{$orgIndex}@example.com",
                        'password' => $password,
                        'address' => $address, // Shared address
                        'mobile_number' => $faker->numerify('##########'),
                        'organization_id' => $orgId,
                        'is_rent_agreement_verified_staff' => true,
                        'is_rent_agreement_verified_admin' => true,
                    ]);
                    $residents[] = $resident;
                }

                // Property using the same address
                Property::create([
                    'address' => $address,
                    'type' => $faker->randomElement(['Flat', 'Villa', 'Penthouse']),
                    'owner_id' => $member->id,
                    'resident_id' => $resident ? $resident->id : null,
                    'organization_id' => $orgId,
                ]);
            }

            // 5. Community Posts
            foreach (array_rand($members, 5) as $idx) {
                CommunityPost::create([
                    'organization_id' => $orgId,
                    'member_id' => $members[$idx]->id,
                    'title' => $faker->sentence(4),
                    'content' => $faker->paragraph(3),
                    'status' => $faker->randomElement(['approved', 'approved', 'approved', 'rejected']), // Mostly approved
                ]);
            }

            // 6. Bookings & Commissions
            for ($i = 0; $i < 5; $i++) {
                $service = $faker->randomElement($vendorServices);
                $booking = ServiceBooking::create([
                    'organization_id' => $orgId,
                    'member_id' => $faker->randomElement($members)->id,
                    'vendor_service_id' => $service->id,
                    'start_date' => Carbon::now()->addDays($faker->numberBetween(1, 10)),
                    'end_date' => Carbon::now()->addDays($faker->numberBetween(11, 15)),
                    'status' => 'completed',
                    'payment_method' => 'online',
                    'total_amount' => $service->price,
                ]);

                // Platform Commission (10%)
                PlatformCommission::create([
                    'service_booking_id' => $booking->id,
                    'organization_id' => $orgId,
                    'vendor_id' => $service->vendor_id,
                    'total_booking_amount' => $service->price,
                    'commission_percentage' => 10.00,
                    'commission_amount' => $service->price * 0.10,
                    'status' => 'paid',
                ]);
            }

            // 7. Other entities (Donors, Events, Announcements, Sponsors, Gallery, Tickets)
            for ($i = 0; $i < 5; $i++) {
                Announcement::create([
                    'announcement_subject' => $faker->sentence(5),
                    'announcement_text' => $faker->paragraph(2),
                    'announcement_status' => 1,
                    'organization_id' => $orgId,
                ]);

                Event::create([
                    'title' => $faker->sentence(3),
                    'description' => $faker->paragraph,
                    'event_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                    'organization_id' => $orgId,
                ]);

                Gallery::create([
                    'title' => 'Gallery Item ' . $i,
                    'image_url' => 'https://via.placeholder.com/400x300?text=Org+'.$orgIndex.'+Image+'.$i,
                    'organization_id' => $orgId,
                ]);

                Donor::create([
                    'name' => $faker->name,
                    'email' => $faker->safeEmail,
                    'amount' => $faker->randomFloat(2, 50, 1000),
                    'donation_date' => Carbon::now()->subDays($faker->numberBetween(1, 30)),
                    'organization_id' => $orgId,
                ]);

                Sponsor::create([
                    'name' => $faker->company,
                    'logo_url' => 'https://via.placeholder.com/150x150?text=Sponsor',
                    'organization_id' => $orgId,
                ]);

                Ticket::create([
                    'organization_id' => $orgId,
                    'member_id' => $faker->randomElement($members)->id,
                    'subject' => 'Issue ' . $i,
                    'description' => $faker->sentence,
                    'category' => 'Maintenance',
                    'status' => $faker->randomElement(['pending', 'resolved']),
                ]);
            }
        }

        $this->command->info('Multi-Org Demo Data generation completed successfully.');
    }
}
