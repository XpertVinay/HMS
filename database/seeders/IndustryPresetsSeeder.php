<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Industry;

class IndustryPresetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platformSettings = [
            'title' => 'Platform Settings',
            'icon' => 'bx-cog',
            'visibility' => 'dashboard',
            'roles' => ['admin'],
            'type' => 'standard',
            'is_preset' => true,
            'children' => [
                ['title' => 'SOLID Approvals', 'route_name' => 'solid.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ['title' => 'Community Approvals', 'route_name' => 'community.approvals', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ['title' => 'Theme Settings', 'route_name' => 'theme_settings.edit', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ['title' => 'CMS / Pages', 'route_name' => 'cms.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ['title' => 'Portal Menus', 'route_name' => 'portal_menus.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ['title' => 'Roles & Permissions', 'route_name' => 'roles_permissions.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
            ]
        ];

        // 1. Real Estate
        $realEstate = Industry::firstOrCreate(
            ['name' => 'Real Estate'],
            ['base_fee' => 2499.00, 'is_active' => true]
        );

        $realEstate->features()->firstOrCreate(['name' => 'Payment Gateway', 'price' => 500.00, 'description' => 'Accept online payments from tenants.']);
        $realEstate->features()->firstOrCreate(['name' => 'Helpdesk Module', 'price' => 300.00, 'description' => 'Advanced ticketing for maintenance.']);

        $realEstateAdminPerms = [
            'properties.create', 'properties.read', 'properties.update', 'properties.delete',
            'customers.create', 'customers.read', 'customers.update', 'customers.delete',
            'brokers.create', 'brokers.read', 'brokers.update', 'brokers.delete',
            'payments.create', 'payments.read', 'payments.update', 'payments.delete',
            'helpdesk.create', 'helpdesk.read', 'helpdesk.update', 'helpdesk.delete',
            'listings.create', 'listings.read', 'listings.update', 'listings.delete'
        ];
        $realEstate->rolePresets()->updateOrCreate(['role_name' => 'Admin'], ['default_permissions' => $realEstateAdminPerms]);
        $realEstate->rolePresets()->updateOrCreate(['role_name' => 'Broker'], ['default_permissions' => ['listings.create', 'listings.read', 'listings.update', 'listings.delete', 'customers.read']]);
        $realEstate->rolePresets()->updateOrCreate(['role_name' => 'Owner'], ['default_permissions' => ['payments.read', 'properties.read']]);
        $realEstate->rolePresets()->updateOrCreate(['role_name' => 'Customer'], ['default_permissions' => ['listings.read', 'payments.read']]);

        $realEstateMenu = [
            [
                'title' => 'Property Management',
                'icon' => 'bx-building-house',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'staff'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Properties', 'route_name' => 'properties.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Listings', 'route_name' => 'properties.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'Financials',
                'icon' => 'bx-money',
                'visibility' => 'dashboard',
                'roles' => ['admin'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Payments', 'route_name' => 'maintenance.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            $platformSettings
        ];
        $realEstate->menuPreset()->updateOrCreate([], ['menu_hierarchy' => $realEstateMenu]);

        // 2. RWA (Resident Welfare Association)
        $rwa = Industry::firstOrCreate(
            ['name' => 'RWA (Resident Welfare Association)'],
            ['base_fee' => 1999.00, 'is_active' => true]
        );

        $rwa->features()->firstOrCreate(['name' => 'Vendor Management', 'price' => 400.00, 'description' => 'Onboard and manage local vendors.']);
        $rwa->features()->firstOrCreate(['name' => 'Visitor Management', 'price' => 600.00, 'description' => 'Gate security and visitor tracking.']);

        $rwaAdminPerms = [
            'members.create', 'members.read', 'members.update', 'members.delete',
            'staff.create', 'staff.read', 'staff.update', 'staff.delete',
            'vendors.create', 'vendors.read', 'vendors.update', 'vendors.delete',
            'visitors.create', 'visitors.read', 'visitors.update', 'visitors.delete',
            'announcements.create', 'announcements.read', 'announcements.update', 'announcements.delete',
            'maintenance.create', 'maintenance.read', 'maintenance.update', 'maintenance.delete',
            'helpdesk.create', 'helpdesk.read', 'helpdesk.update', 'helpdesk.delete',
            'facilities.create', 'facilities.read', 'facilities.update', 'facilities.delete',
            'accounting.create', 'accounting.read', 'accounting.update', 'accounting.delete'
        ];
        $rwa->rolePresets()->updateOrCreate(['role_name' => 'Admin'], ['default_permissions' => $rwaAdminPerms]);
        $rwa->rolePresets()->updateOrCreate(['role_name' => 'Treasurer'], ['default_permissions' => ['accounting.create', 'accounting.read', 'accounting.update', 'accounting.delete', 'maintenance.create', 'maintenance.read', 'maintenance.update', 'maintenance.delete']]);
        $rwa->rolePresets()->updateOrCreate(['role_name' => 'Member'], ['default_permissions' => ['announcements.read', 'helpdesk.create', 'helpdesk.read', 'facilities.read', 'maintenance.read']]);
        $rwa->rolePresets()->updateOrCreate(['role_name' => 'Vendor'], ['default_permissions' => ['helpdesk.read', 'helpdesk.update']]);
        $rwa->rolePresets()->updateOrCreate(['role_name' => 'Guard'], ['default_permissions' => ['visitors.create', 'visitors.read', 'visitors.update', 'visitors.delete']]);

        $rwaMenu = [
            // Public Menus
            ['title' => 'Home', 'url' => '/', 'visibility' => 'public', 'type' => 'standard', 'is_preset' => true],
            ['title' => 'Members', 'url' => '/members', 'visibility' => 'public', 'type' => 'standard', 'is_preset' => true],
            ['title' => 'Donors', 'url' => '/donors', 'visibility' => 'public', 'type' => 'standard', 'is_preset' => true],
            ['title' => 'Events', 'url' => '/events', 'visibility' => 'public', 'type' => 'standard', 'is_preset' => true],
            ['title' => 'Notices', 'url' => '/notices', 'visibility' => 'public', 'type' => 'standard', 'is_preset' => true],
            ['title' => 'Sponsors', 'url' => '/sponsors', 'visibility' => 'public', 'type' => 'standard', 'is_preset' => true],
            ['title' => 'Gallery', 'url' => '/gallery', 'visibility' => 'public', 'type' => 'standard', 'is_preset' => true],

            // Dashboard Menus
            [
                'title' => 'Announcements',
                'icon' => 'bx-bell',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'member'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Events', 'route_name' => 'events.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Notice', 'route_name' => 'announcements.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'member'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Gallery', 'route_name' => 'gallery.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'Support',
                'icon' => 'bx-support',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'member', 'staff'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'HelpDesk', 'route_name' => 'helpdesk.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'member', 'staff'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'User Management',
                'icon' => 'bx-user',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'staff'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Members', 'route_name' => 'members.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Residents', 'route_name' => 'residents.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Staff', 'route_name' => 'staff.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'Group Management',
                'icon' => 'bx-group',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'member'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Sponsors', 'route_name' => 'sponsors.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Vendors', 'route_name' => 'vendors.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Vendor Directory', 'route_name' => 'vendors.directory', 'visibility' => 'dashboard', 'roles' => ['member'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Donors', 'route_name' => 'donors.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'Properties',
                'icon' => 'bx-building-house',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'staff'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Listings', 'route_name' => 'properties.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            $platformSettings
        ];
        $rwa->menuPreset()->updateOrCreate([], ['menu_hierarchy' => $rwaMenu]);

        // 3. Healthcare
        $healthcare = Industry::firstOrCreate(
            ['name' => 'Healthcare'],
            ['base_fee' => 4999.00, 'is_active' => true]
        );
        $healthcareMenu = [
            [
                'title' => 'Patient Management',
                'icon' => 'bx-user',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'staff'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Patients', 'route_name' => 'members.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Appointments', 'route_name' => 'helpdesk.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'Clinical Staff',
                'icon' => 'bx-plus-medical',
                'visibility' => 'dashboard',
                'roles' => ['admin'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Doctors', 'route_name' => 'staff.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'Operations',
                'icon' => 'bx-buildings',
                'visibility' => 'dashboard',
                'roles' => ['admin'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Billing', 'route_name' => 'maintenance.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            $platformSettings
        ];
        $healthcare->menuPreset()->updateOrCreate([], ['menu_hierarchy' => $healthcareMenu]);

        // 4. Education
        $education = Industry::firstOrCreate(
            ['name' => 'Education'],
            ['base_fee' => 3999.00, 'is_active' => true]
        );
        $educationMenu = [
            [
                'title' => 'Academics',
                'icon' => 'bx-book',
                'visibility' => 'dashboard',
                'roles' => ['admin', 'staff'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Students', 'route_name' => 'members.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Teachers', 'route_name' => 'staff.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            [
                'title' => 'Administration',
                'icon' => 'bx-buildings',
                'visibility' => 'dashboard',
                'roles' => ['admin'],
                'type' => 'standard',
                'is_preset' => true,
                'children' => [
                    ['title' => 'Fees', 'route_name' => 'maintenance.index', 'visibility' => 'dashboard', 'roles' => ['admin'], 'type' => 'standard', 'is_preset' => true],
                    ['title' => 'Notices', 'route_name' => 'announcements.index', 'visibility' => 'dashboard', 'roles' => ['admin', 'staff'], 'type' => 'standard', 'is_preset' => true],
                ]
            ],
            $platformSettings
        ];
        $education->menuPreset()->updateOrCreate([], ['menu_hierarchy' => $educationMenu]);
    }
}

