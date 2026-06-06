<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\TenantTheme;
use App\Models\ThemePreset;
use Illuminate\Support\Facades\Cache;

/**
 * Central orchestration service for the White-Label Theme Engine.
 *
 * Handles theme resolution (with hierarchy fallbacks), CSS generation,
 * caching, publishing, and rollback.
 */
class ThemeService
{
    protected ThemeCssGenerator $cssGenerator;
    protected ThemeCacheService $cacheService;

    public function __construct(ThemeCssGenerator $cssGenerator, ThemeCacheService $cacheService)
    {
        $this->cssGenerator = $cssGenerator;
        $this->cacheService = $cacheService;
    }

    /* ══════════════════════════════════════════════════
     *  Theme Resolution (with hierarchy)
     * ══════════════════════════════════════════════════ */

    /**
     * Resolve the active theme for an organization.
     *
     * Hierarchy: Active TenantTheme → Legacy org columns → Platform defaults
     */
    public function resolveTheme(Organization $org): TenantTheme
    {
        return $org->resolved_theme;
    }

    /* ══════════════════════════════════════════════════
     *  CSS Generation
     * ══════════════════════════════════════════════════ */

    /**
     * Get the full compiled CSS for a theme (cached when possible).
     */
    public function getThemeCss(Organization $org): string
    {
        $theme = $this->resolveTheme($org);
        $version = $theme->theme_version;

        // Try cache first
        $cached = $this->cacheService->getCachedCss($org->id, $version);
        if ($cached !== null) {
            return $cached;
        }

        // Generate and cache
        $css = $this->cssGenerator->generateFullCss($theme);
        $this->cacheService->cacheThemeCss($org->id, $version, $css);

        return $css;
    }

    /**
     * Get the sanitized custom CSS for a theme.
     */
    public function getCustomCss(TenantTheme $theme): string
    {
        if (empty($theme->custom_css)) {
            return '';
        }

        return $this->cssGenerator->sanitizeCustomCss($theme->custom_css);
    }

    /**
     * Generate the default platform CSS variables.
     */
    public function getDefaultCssVariables(): string
    {
        $defaults = config('theme.defaults', []);

        $fallbackTheme = new TenantTheme();
        $fallbackTheme->fill($defaults);

        return $this->cssGenerator->generateFullCss($fallbackTheme);
    }

    /* ══════════════════════════════════════════════════
     *  Theme Management
     * ══════════════════════════════════════════════════ */

    /**
     * Create a new theme for an organization.
     */
    public function createTheme(Organization $org, array $data): TenantTheme
    {
        // Deactivate existing active themes if this one is active
        if ($data['is_active'] ?? true) {
            TenantTheme::forOrg($org->id)->active()->update(['is_active' => false]);
        }

        $data['organization_id'] = $org->id;
        $data['theme_version'] = $data['theme_version'] ?? '1.0.0';

        $theme = TenantTheme::create($data);

        $this->cacheService->invalidateCache($org->id);

        return $theme;
    }

    /**
     * Update an existing theme.
     */
    public function updateTheme(TenantTheme $theme, array $data): TenantTheme
    {
        $theme->update($data);

        $this->cacheService->invalidateCache($theme->organization_id);

        return $theme->fresh();
    }

    /**
     * Publish a theme (set it as active and stamp published_at).
     */
    public function publishTheme(TenantTheme $theme): void
    {
        // Deactivate other themes for this org
        TenantTheme::forOrg($theme->organization_id)
                   ->where('id', '!=', $theme->id)
                   ->active()
                   ->update(['is_active' => false]);

        // Bump version
        $theme->is_active = true;
        $theme->published_at = now();
        $theme->theme_version = $this->bumpVersion($theme->theme_version);
        $theme->save();

        $this->cacheService->invalidateCache($theme->organization_id);
    }

    /**
     * Rollback to the previous theme version (restores the last soft-deleted theme).
     */
    public function rollbackTheme(Organization $org): ?TenantTheme
    {
        $previousTheme = TenantTheme::forOrg($org->id)
                                     ->onlyTrashed()
                                     ->orderByDesc('deleted_at')
                                     ->first();

        if (!$previousTheme) {
            return null;
        }

        // Deactivate current active theme
        TenantTheme::forOrg($org->id)->active()->update(['is_active' => false]);

        // Restore and activate the previous theme
        $previousTheme->restore();
        $previousTheme->update([
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $this->cacheService->invalidateCache($org->id);

        return $previousTheme;
    }

    /**
     * Apply a preset to an organization's active theme (or create a new one).
     */
    public function applyPreset(Organization $org, ThemePreset $preset): TenantTheme
    {
        $theme = TenantTheme::forOrg($org->id)->active()->first();

        if (!$theme) {
            $theme = new TenantTheme([
                'organization_id' => $org->id,
                'is_active'       => true,
            ]);
        }

        $preset->applyTo($theme);
        $theme->theme_name = $preset->name . ' (Customized)';
        $theme->theme_version = $this->bumpVersion($theme->theme_version ?? '0.0.0');
        $theme->published_at = now();
        $theme->save();

        $this->cacheService->invalidateCache($org->id);

        return $theme;
    }

    /* ══════════════════════════════════════════════════
     *  Preview (without saving)
     * ══════════════════════════════════════════════════ */

    /**
     * Generate a preview CSS from unsaved theme data.
     */
    public function generatePreviewCss(array $themeData): string
    {
        $previewTheme = new TenantTheme();
        $previewTheme->fill($themeData);

        return $this->cssGenerator->generateFullCss($previewTheme);
    }

    /* ══════════════════════════════════════════════════
     *  Helpers
     * ══════════════════════════════════════════════════ */

    /**
     * Bump a semantic version string (patch increment).
     */
    private function bumpVersion(string $version): string
    {
        $parts = explode('.', $version);
        $parts = array_pad($parts, 3, '0');
        $parts[2] = (int) $parts[2] + 1;

        return implode('.', $parts);
    }
}
