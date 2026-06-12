<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Organization;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily unguard to allow mass assignment of organization_id if needed
        Permission::unguard();
        Role::unguard();

        $globalPermissions = [
            'organizations.create', 'organizations.read', 'organizations.update', 'organizations.delete',
            'industries.create', 'industries.read', 'industries.update', 'industries.delete',
            'themes.create', 'themes.read', 'themes.update', 'themes.delete',
            'global_roles.create', 'global_roles.read', 'global_roles.update', 'global_roles.delete',
            'global_permissions.create', 'global_permissions.read', 'global_permissions.update', 'global_permissions.delete',
            'cms.create', 'cms.read', 'cms.update', 'cms.delete',
        ];

        // Fetch all preset permissions from IndustryRolePreset and merge
        $presetPermissions = \App\Models\IndustryRolePreset::pluck('default_permissions')->flatten()->unique()->filter()->toArray();
        $globalPermissions = array_unique(array_merge($globalPermissions, $presetPermissions));

        // Create global permissions
        foreach ($globalPermissions as $permissionName) {
            Permission::updateOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
                'organization_id' => null,
            ]);
        }

        // Super Admin Role (Global)
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web',
            'organization_id' => null,
        ]);
        
        $superAdminRole->syncPermissions(Permission::whereNull('organization_id')->get());

        Permission::reguard();
        Role::reguard();
        
        $this->command->info('Roles and Permissions seeded successfully.');
    }
}
