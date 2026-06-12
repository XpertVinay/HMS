<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Organization;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $organizationId = $request->get('organization_id', 'global');

        if ($organizationId === 'global') {
            $roles = Role::whereNull('organization_id')->with('permissions')->get();
        } else {
            $roles = Role::where('organization_id', $organizationId)->with('permissions')->get();
        }

        // Always show global permissions in the matrix
        $permissions = Permission::whereNull('organization_id')->get();
        
        // Fetch all organizations for the dropdown filter
        $organizations = Organization::all();

        return view('super_admin.roles_permissions.index', compact('roles', 'permissions', 'organizations', 'organizationId'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('roles', 'name')->where(function ($query) use ($request) {
                    return $query->where('guard_name', 'web')
                                 ->where('organization_id', $request->organization_id);
                }),
            ],
            'organization_id' => 'nullable|exists:organizations,id',
        ], [
            'name.unique' => 'A role with this name already exists for the selected context.'
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
                'organization_id' => $request->organization_id,
            ]);
        } catch (\Spatie\Permission\Exceptions\RoleAlreadyExists $e) {
            return redirect()->back()->withErrors(['name' => 'A role with this name already exists for the selected context.']);
        }

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('permissions', 'name')->where(function ($query) {
                    return $query->where('guard_name', 'web')
                                 ->whereNull('organization_id');
                }),
            ],
        ], [
            'name.unique' => 'A global permission with this name already exists.'
        ]);

        try {
            Permission::create([
                'name' => $request->name,
                'guard_name' => 'web',
                'organization_id' => null, // Super admin created permissions are global
            ]);
        } catch (\Spatie\Permission\Exceptions\PermissionAlreadyExists $e) {
            return redirect()->back()->withErrors(['name' => 'A global permission with this name already exists.']);
        }

        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    public function updateMatrix(Request $request)
    {
        $request->validate([
            'permissions' => 'array',
            'organization_id' => 'required|string',
        ]);

        $organizationId = $request->input('organization_id');

        if ($organizationId === 'global') {
            $roles = Role::whereNull('organization_id')->get();
        } else {
            $roles = Role::where('organization_id', $organizationId)->get();
        }
        
        foreach ($roles as $role) {
            $assignedPermissions = $request->input("permissions.{$role->id}", []);
            // Sync permissions for this role
            // assignedPermissions will contain the permission IDs. Cast to int so Spatie resolves by ID.
            $role->syncPermissions(array_map('intval', $assignedPermissions));
        }

        return redirect()->back()->with('success', 'Roles and Permissions updated successfully.');
    }
}
