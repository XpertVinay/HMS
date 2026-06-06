<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationMenuConfig;
use Illuminate\Http\Request;

class MenuConfigController extends Controller
{
    /**
     * List all organizations with their menu configuration status.
     */
    public function index(Request $request)
    {
        $query = Organization::with('menuConfig')
            ->withCount(['admins', 'members']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subdomain', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Residential type filter
        if ($request->filled('type')) {
            $query->where('residential_type', $request->input('type'));
        }

        $organizations = $query->orderBy('name')->get();
        $menuItems = config('menu_items', []);
        $residentialTypes = config('menu_presets', []);

        return view('super_admin.menu-config.index', compact(
            'organizations', 'menuItems', 'residentialTypes'
        ));
    }

    /**
     * Show the menu configuration form for a specific organization.
     */
    public function edit(int $id)
    {
        $organization = Organization::with('menuConfig')->findOrFail($id);
        $menuItems = config('menu_items', []);
        $residentialTypes = config('menu_presets', []);
        $enabledMenus = $organization->enabledMenus;

        return view('super_admin.menu-config.edit', compact(
            'organization', 'menuItems', 'residentialTypes', 'enabledMenus'
        ));
    }

    /**
     * Save the menu configuration for a specific organization.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'location'         => 'nullable|string|max:255',
            'residential_type' => 'nullable|string|in:apartment,villa,independent_house,township,commercial',
            'enabled_menus'    => 'nullable|array',
            'enabled_menus.*'  => 'string|in:' . implode(',', array_keys(config('menu_items', []))),
        ]);

        $organization = Organization::findOrFail($id);

        // Update org metadata
        $organization->update([
            'location'         => $request->input('location'),
            'residential_type' => $request->input('residential_type'),
        ]);

        // Upsert menu config
        OrganizationMenuConfig::updateOrCreate(
            ['organization_id' => $organization->id],
            ['enabled_menus' => $request->input('enabled_menus', [])]
        );

        return redirect()
            ->route('super_admin.menu_config.index')
            ->with('success', "Menu configuration updated for \"{$organization->name}\".");
    }

    /**
     * Show bulk edit form — apply a menu template to multiple organizations.
     */
    public function bulkEdit(Request $request)
    {
        $organizations = Organization::with('menuConfig')
            ->orderBy('name')
            ->get();

        $menuItems = config('menu_items', []);
        $residentialTypes = config('menu_presets', []);

        // Pre-select orgs if IDs passed via query param
        $selectedIds = $request->input('ids', []);

        return view('super_admin.menu-config.bulk-edit', compact(
            'organizations', 'menuItems', 'residentialTypes', 'selectedIds'
        ));
    }

    /**
     * Apply a menu configuration template to multiple organizations.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'organization_ids'   => 'required|array|min:1',
            'organization_ids.*' => 'integer|exists:organizations,id',
            'enabled_menus'      => 'nullable|array',
            'enabled_menus.*'    => 'string|in:' . implode(',', array_keys(config('menu_items', []))),
            'residential_type'   => 'nullable|string|in:apartment,villa,independent_house,township,commercial',
            'update_type'        => 'nullable|boolean',
        ]);

        $orgIds = $request->input('organization_ids');
        $enabledMenus = $request->input('enabled_menus', []);
        $updateCount = 0;

        foreach ($orgIds as $orgId) {
            $org = Organization::find($orgId);
            if (!$org) continue;

            // Optionally update residential type
            if ($request->boolean('update_type') && $request->filled('residential_type')) {
                $org->update(['residential_type' => $request->input('residential_type')]);
            }

            OrganizationMenuConfig::updateOrCreate(
                ['organization_id' => $org->id],
                ['enabled_menus' => $enabledMenus]
            );

            $updateCount++;
        }

        return redirect()
            ->route('super_admin.menu_config.index')
            ->with('success', "Menu configuration applied to {$updateCount} organization(s).");
    }

    /**
     * API endpoint: return preset menus for a residential type (AJAX).
     */
    public function presetMenus(string $type)
    {
        $presets = config('menu_presets', []);

        if (!isset($presets[$type])) {
            return response()->json(['menus' => array_keys(config('menu_items', []))]);
        }

        return response()->json(['menus' => $presets[$type]['menus']]);
    }
}
