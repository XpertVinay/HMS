<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Organization;

class RolePermissionController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();

        // Admin sees global roles (org_id = null) + their org's roles, but NOT super_admin
        $roles = Role::with('permissions')
            ->where(function($query) use ($orgId) {
                $query->whereNull('organization_id')
                      ->orWhere('organization_id', $orgId);
            })
            ->where('name', '!=', 'super_admin')
            ->get();

        // Only fetch permissions that apply to this Organization's Industry, plus any custom org permissions
        $org = Organization::find($orgId);
        $industryId = $org->industry_id ?? null;
        
        $validPresetPermissions = [];
        if ($industryId) {
            $validPresetPermissions = \App\Models\IndustryRolePreset::where('industry_id', $industryId)
                                        ->pluck('default_permissions')
                                        ->flatten()
                                        ->unique()
                                        ->filter()
                                        ->toArray();
        } else {
            // Fallback for demo orgs without an industry
            $validPresetPermissions = \App\Models\IndustryRolePreset::pluck('default_permissions')
                                        ->flatten()
                                        ->unique()
                                        ->filter()
                                        ->toArray();
        }
        
        // Themes are allowed for Admins (with consent/audit logged in the actual theme controller)
        $validPresetPermissions = array_merge($validPresetPermissions, [
            'themes.create', 'themes.read', 'themes.update', 'themes.delete'
        ]);

        // Admin sees their industry's global permissions + their org's custom permissions
        $permissions = Permission::where(function($query) use ($validPresetPermissions) {
                $query->whereIn('name', $validPresetPermissions)
                      ->whereNull('organization_id');
            })
            ->orWhere('organization_id', $orgId)
            ->get();

        return view('admin.roles_permissions.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $orgId = $this->orgId();

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'organization_id' => $orgId,
        ]);

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $orgId = $this->orgId();

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'organization_id' => $orgId,
        ]);

        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    public function updateMatrix(Request $request)
    {
        $request->validate([
            'permissions' => 'array',
        ]);

        $orgId = $this->orgId();

        $roles = Role::where(function($query) use ($orgId) {
                $query->whereNull('organization_id')
                      ->orWhere('organization_id', $orgId);
            })
            ->where('name', '!=', 'super_admin')
            ->get();
            
        // Security check: Only allow assigning permissions that are valid for this org's industry
        $org = Organization::find($orgId);
        $industryId = $org->industry_id ?? null;
        
        $validPresetPermissions = [];
        if ($industryId) {
            $validPresetPermissions = \App\Models\IndustryRolePreset::where('industry_id', $industryId)
                                        ->pluck('default_permissions')
                                        ->flatten()
                                        ->unique()
                                        ->filter()
                                        ->toArray();
        } else {
            $validPresetPermissions = \App\Models\IndustryRolePreset::pluck('default_permissions')
                                        ->flatten()
                                        ->unique()
                                        ->filter()
                                        ->toArray();
        }

        // Themes are allowed for Admins (with consent/audit logged in the actual theme controller)
        $validPresetPermissions = array_merge($validPresetPermissions, [
            'themes.create', 'themes.read', 'themes.update', 'themes.delete'
        ]);

        $validPermissionIds = Permission::where(function($query) use ($validPresetPermissions) {
                $query->whereIn('name', $validPresetPermissions)
                      ->whereNull('organization_id');
            })
            ->orWhere('organization_id', $orgId)
            ->pluck('id')
            ->toArray();

        foreach ($roles as $role) {
            $assignedPermissions = $request->input("permissions.{$role->id}", []);
            
            // Filter out any permission IDs not valid for this org
            $filteredPermissions = array_intersect($assignedPermissions, $validPermissionIds);

            // Sync permissions (cast to int so Spatie searches by ID instead of Name)
            $role->syncPermissions(array_map('intval', $filteredPermissions));
        }

        return redirect()->back()->with('success', 'Roles and Permissions updated successfully.');
    }
}
