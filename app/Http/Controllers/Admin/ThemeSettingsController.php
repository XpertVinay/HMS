<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\TenantTheme;
use App\Models\ThemeConsentLog;
use App\Services\ThemeService;

class ThemeSettingsController extends Controller
{
    public function __construct(protected ThemeService $themeService)
    {
    }

    /**
     * Show the theme settings edit form for the current organization.
     */
    public function edit(Request $request)
    {
        $organization = $this->activeOrg();

        if (!$organization) {
            return redirect()->route('admin.dashboard')->with('error', 'Organization not found.');
        }

        $organization->load('activeTheme', 'themes');
        $theme = $organization->resolved_theme;

        $allowedFonts = config('theme.allowed_fonts', [
            'Inter',
            'Roboto',
            'Outfit',
            'Poppins',
            'Open Sans',
            'Lato',
            'Montserrat',
            'Nunito'
        ]);

        $defaults = config('theme.defaults', [
            'primary_color' => '#2563eb',
            'secondary_color' => '#64748b',
            'accent_color' => '#f59e0b',
            'background_primary' => '#ffffff',
            'background_secondary' => '#f8fafc',
            'text_primary' => '#0f172a',
            'text_secondary' => '#475569',
        ]);

        return view('admin.theme-settings.edit', compact(
            'organization',
            'theme',
            'allowedFonts',
            'defaults'
        ));
    }

    /**
     * Update the theme settings and log consent.
     */
    public function update(Request $request)
    {
        $organization = $this->activeOrg();

        if (!$organization) {
            return redirect()->route('admin.dashboard')->with('error', 'Organization not found.');
        }

        $validated = $request->validate([
            'consent_confirmed' => 'required|accepted',
            'theme_mode' => 'nullable|in:light,dark,auto,custom',

            // Basic Colors
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'accent_color' => 'nullable|string|max:20',
            'background_primary' => 'nullable|string|max:20',
            'background_secondary' => 'nullable|string|max:20',
            'text_primary' => 'nullable|string|max:20',
            'text_secondary' => 'nullable|string|max:20',

            // Fonts
            'font_primary' => 'nullable|string|max:100',
            'font_secondary' => 'nullable|string|max:100',
            'font_size_base' => 'nullable|string|max:10',

            // Assets
            'logo_light' => 'nullable|image|max:2048',
            'logo_dark' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
        ]);

        // Validate consent (redundant but explicit)
        if (!$request->has('consent_confirmed')) {
            return back()->with('error', 'You must confirm your consent to update theme settings.');
        }

        $existingTheme = TenantTheme::forOrg($organization->id)->active()->first();

        // Handle file uploads
        foreach (['logo_light', 'logo_dark', 'favicon'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('themes', 'public');
                $validated[$field] = $path;
            } else {
                // Ensure we don't accidentally overwrite existing assets with null 
                // because the file wasn't re-uploaded
                unset($validated[$field]);
            }
        }

        if ($existingTheme) {
            $this->themeService->updateTheme($existingTheme, $validated);
        } else {
            // Assign a default name if creating
            $validated['theme_name'] = $organization->name . ' Custom Theme';
            $this->themeService->createTheme($organization, $validated);
        }

        $adminId = session('aid');
        if (!\App\Models\Admin::where('id', $adminId)->exists()) {
            $adminId = null;
        }

        // Log the consent for dispute resolution
        ThemeConsentLog::create([
            'organization_id' => $organization->id,
            'admin_id' => $adminId,
            'action' => 'Theme Settings Updated',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'theme_data' => collect($validated)->except(['logo_light', 'logo_dark', 'favicon', 'consent_confirmed'])->toArray(),
        ]);

        return redirect()->route('admin.theme_settings.edit')
            ->with('success', 'Theme settings updated and consent recorded successfully.');
    }
}
