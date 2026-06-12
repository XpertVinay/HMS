<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\IndustryRolePreset;

class SyncPresetPermissions extends Command
{
    protected $signature = 'hms:sync-permissions';
    protected $description = 'Syncs Spatie permissions with Industry Presets for all existing roles.';

    public function handle()
    {
        $this->info('Starting permission synchronization...');

        $roles = Role::whereNotNull('organization_id')->get();
        $presets = IndustryRolePreset::all()->groupBy('role_name');

        foreach ($roles as $role) {
            $roleName = $role->name;
            
            // For migrating legacy roles like sub-admin -> Admin preset
            if ($roleName === 'sub-admin') $roleName = 'Admin';
            
            if (isset($presets[$roleName])) {
                // Get the first matching preset (assuming role names are mostly consistent across industries for now)
                $preset = $presets[$roleName]->first();
                $permissionsToAssign = $preset->default_permissions ?? [];
                
                // Find IDs of these permissions
                $permissionIds = Permission::whereIn('name', $permissionsToAssign)
                                    ->where(function($q) use ($role) {
                                        $q->whereNull('organization_id')
                                          ->orWhere('organization_id', $role->organization_id);
                                    })
                                    ->pluck('id')
                                    ->toArray();
                
                $role->syncPermissions($permissionIds);
                $this->info("Synced " . count($permissionIds) . " permissions for role '{$role->name}' in Org ID {$role->organization_id}.");
            }
        }

        // Also sync Super Admin
        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $globalPerms = Permission::whereNull('organization_id')->pluck('id')->toArray();
            $superAdmin->syncPermissions($globalPerms);
            $this->info('Synced global permissions for Super Admin.');
        }

        $this->info('Done!');
    }
}
