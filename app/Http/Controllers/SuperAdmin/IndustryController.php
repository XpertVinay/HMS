<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industry;
use App\Models\IndustryFeature;
use App\Models\IndustryRolePreset;
use Spatie\Permission\Models\Permission;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::withCount('features', 'rolePresets')->get();
        return view('super_admin.industries.index', compact('industries'));
    }

    public function create()
    {
        return view('super_admin.industries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industries,name',
            'base_fee' => 'required|numeric|min:0',
        ]);

        Industry::create($request->only('name', 'base_fee'));

        return redirect()->route('super_admin.industries.index')->with('success', 'Industry created successfully.');
    }

    public function edit(Industry $industry)
    {
        return view('super_admin.industries.edit', compact('industry'));
    }

    public function update(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industries,name,' . $industry->id,
            'base_fee' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $industry->update($request->only('name', 'base_fee', 'is_active'));

        return redirect()->route('super_admin.industries.index')->with('success', 'Industry updated successfully.');
    }

    public function destroy(Industry $industry)
    {
        $industry->delete();
        return redirect()->route('super_admin.industries.index')->with('success', 'Industry deleted successfully.');
    }

    // --- Features Management ---
    public function features(Industry $industry)
    {
        $features = $industry->features;
        return view('super_admin.industries.features', compact('industry', 'features'));
    }

    public function storeFeature(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $industry->features()->create($request->only('name', 'description', 'price'));

        return redirect()->back()->with('success', 'Feature added successfully.');
    }

    public function destroyFeature(Industry $industry, IndustryFeature $feature)
    {
        if ($feature->industry_id === $industry->id) {
            $feature->delete();
        }
        return redirect()->back()->with('success', 'Feature removed successfully.');
    }

    // --- Role Presets Management ---
    public function rolePresets(Industry $industry)
    {
        $presets = $industry->rolePresets;
        $globalPermissions = Permission::whereNull('organization_id')->get();
        return view('super_admin.industries.role_presets', compact('industry', 'presets', 'globalPermissions'));
    }

    public function storeRolePreset(Request $request, Industry $industry)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'default_permissions' => 'nullable|array',
        ]);

        $industry->rolePresets()->create([
            'role_name' => $request->role_name,
            'default_permissions' => $request->default_permissions ?? [],
        ]);

        return redirect()->back()->with('success', 'Role Preset added successfully.');
    }

    public function updateRolePreset(Request $request, Industry $industry, IndustryRolePreset $preset)
    {
        if ($preset->industry_id !== $industry->id) abort(403);

        $request->validate([
            'default_permissions' => 'nullable|array',
        ]);

        $preset->update([
            'default_permissions' => $request->default_permissions ?? [],
        ]);

        return redirect()->back()->with('success', 'Role Preset updated successfully.');
    }

    public function destroyRolePreset(Industry $industry, IndustryRolePreset $preset)
    {
        if ($preset->industry_id === $industry->id) {
            $preset->delete();
        }
        return redirect()->back()->with('success', 'Role Preset removed successfully.');
    }
}
