<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\TenantTheme;
use App\Models\ThemePreset;
use App\Services\ThemeService;
use Illuminate\Http\Request;

/**
 * Theme Builder for Super Admin and Organization Admin.
 *
 * Provides a visual interface for managing themes across all
 * organizations, including color pickers, font selectors,
 * component token editors, live preview, and preset application.
 */
class ThemeBuilderController extends Controller
{
    public function __construct(protected ThemeService $themeService) {}

    /**
     * List all organizations with their current theme status.
     */
    public function index()
    {
        $organizations = Organization::with('activeTheme')
                                     ->where('status', 'approved')
                                     ->orderBy('name')
                                     ->get();

        $presets = ThemePreset::orderBy('is_system', 'desc')
                              ->orderBy('name')
                              ->get();

        return view('super_admin.theme-builder.index', compact('organizations', 'presets'));
    }

    /**
     * Edit the theme for a specific organization.
     */
    public function edit(int $orgId)
    {
        $organization = Organization::with('activeTheme', 'themes')->findOrFail($orgId);
        $theme = $organization->resolved_theme;
        $presets = ThemePreset::orderBy('is_system', 'desc')->orderBy('name')->get();
        $allowedFonts = config('theme.allowed_fonts', []);
        $defaults = config('theme.defaults', []);

        return view('super_admin.theme-builder.edit', compact(
            'organization', 'theme', 'presets', 'allowedFonts', 'defaults'
        ));
    }

    /**
     * Save theme changes for an organization.
     */
    public function store(Request $request, int $orgId)
    {
        $organization = Organization::findOrFail($orgId);

        $validated = $request->validate([
            'theme_name'          => 'nullable|string|max:150',
            'primary_color'       => 'nullable|string|max:30',
            'secondary_color'     => 'nullable|string|max:30',
            'accent_color'        => 'nullable|string|max:30',
            'background_primary'  => 'nullable|string|max:30',
            'background_secondary' => 'nullable|string|max:30',
            'text_primary'        => 'nullable|string|max:30',
            'text_secondary'      => 'nullable|string|max:30',
            'dark_bg_primary'     => 'nullable|string|max:30',
            'dark_bg_secondary'   => 'nullable|string|max:30',
            'dark_text_primary'   => 'nullable|string|max:30',
            'dark_text_secondary' => 'nullable|string|max:30',
            'font_primary'        => 'nullable|string|max:100',
            'font_secondary'      => 'nullable|string|max:100',
            'font_size_base'      => 'nullable|string|max:20',
            'border_radius_sm'    => 'nullable|string|max:20',
            'border_radius_md'    => 'nullable|string|max:20',
            'border_radius_lg'    => 'nullable|string|max:20',
            'theme_mode'          => 'nullable|in:light,dark,auto,custom',
            'custom_css'          => 'nullable|string|max:50000',
            'component_tokens'    => 'nullable|json',
        ]);

        // Handle logo uploads
        if ($request->hasFile('logo_light')) {
            $validated['logo_light'] = $request->file('logo_light')->store('logos', 'public');
        }
        if ($request->hasFile('logo_dark')) {
            $validated['logo_dark'] = $request->file('logo_dark')->store('logos', 'public');
        }
        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('favicons', 'public');
        }

        // Parse component tokens from JSON string
        if (isset($validated['component_tokens']) && is_string($validated['component_tokens'])) {
            $validated['component_tokens'] = json_decode($validated['component_tokens'], true);
        }

        $existingTheme = TenantTheme::forOrg($orgId)->active()->first();

        if ($existingTheme) {
            $this->themeService->updateTheme($existingTheme, $validated);
        } else {
            $validated['is_active'] = true;
            $this->themeService->createTheme($organization, $validated);
        }

        return redirect()
            ->route('super_admin.theme_builder.edit', $orgId)
            ->with('success', 'Theme saved successfully!');
    }

    /**
     * Generate a preview CSS (AJAX endpoint).
     */
    public function preview(Request $request, int $orgId)
    {
        $themeData = $request->all();
        $css = $this->themeService->generatePreviewCss($themeData);

        return response()->json(['css' => $css]);
    }

    /**
     * Publish the current theme (bump version and set published_at).
     */
    public function publish(int $orgId)
    {
        $organization = Organization::findOrFail($orgId);
        $theme = TenantTheme::forOrg($orgId)->active()->firstOrFail();

        $this->themeService->publishTheme($theme);

        return redirect()
            ->route('super_admin.theme_builder.edit', $orgId)
            ->with('success', "Theme published! Version: {$theme->theme_version}");
    }

    /**
     * Rollback to the previous theme version.
     */
    public function rollback(int $orgId)
    {
        $organization = Organization::findOrFail($orgId);
        $previousTheme = $this->themeService->rollbackTheme($organization);

        if (!$previousTheme) {
            return redirect()
                ->route('super_admin.theme_builder.edit', $orgId)
                ->with('error', 'No previous theme version found to rollback to.');
        }

        return redirect()
            ->route('super_admin.theme_builder.edit', $orgId)
            ->with('success', 'Theme rolled back successfully!');
    }

    /**
     * List available presets.
     */
    public function presets()
    {
        $presets = ThemePreset::orderBy('is_system', 'desc')
                              ->orderBy('name')
                              ->get();

        return view('super_admin.theme-builder.presets', compact('presets'));
    }

    /**
     * Apply a preset to an organization.
     */
    public function applyPreset(Request $request, int $orgId)
    {
        $organization = Organization::findOrFail($orgId);
        $preset = ThemePreset::findOrFail($request->input('preset_id'));

        $this->themeService->applyPreset($organization, $preset);

        return redirect()
            ->route('super_admin.theme_builder.edit', $orgId)
            ->with('success', "Preset '{$preset->name}' applied successfully!");
    }
}
