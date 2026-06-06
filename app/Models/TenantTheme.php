<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Full theme configuration for a tenant/organization.
 *
 * Stores colors, typography, spacing, assets, dark-mode overrides,
 * component-level token overrides, custom CSS, and versioning.
 */
class TenantTheme extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'theme_slug',
        'theme_name',
        'is_active',
        // Colors
        'primary_color',
        'secondary_color',
        'accent_color',
        'background_primary',
        'background_secondary',
        'text_primary',
        'text_secondary',
        // Dark mode
        'dark_bg_primary',
        'dark_bg_secondary',
        'dark_text_primary',
        'dark_text_secondary',
        // Typography
        'font_primary',
        'font_secondary',
        'font_size_base',
        // Spacing & Borders
        'border_radius_sm',
        'border_radius_md',
        'border_radius_lg',
        'shadow_sm',
        'shadow_md',
        'shadow_lg',
        // Assets
        'logo_light',
        'logo_dark',
        'favicon',
        'app_icon',
        'splash_image',
        'email_header_image',
        'email_footer_image',
        // Mode
        'theme_mode',
        // Overrides
        'component_tokens',
        'custom_css',
        // Versioning
        'theme_version',
        'published_at',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'component_tokens' => 'array',
        'published_at'     => 'datetime',
    ];

    /* ── Relationships ─────────────────────────────── */

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /* ── Scopes ────────────────────────────────────── */

    /**
     * Returns the active theme for a given organization.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForOrg($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    /* ── Component Token Resolution ────────────────── */

    /**
     * Get a specific component token value with fallback.
     *
     * Usage: $theme->getComponentToken('button', 'background')
     */
    public function getComponentToken(string $component, string $property, ?string $fallback = null): ?string
    {
        $tokens = $this->component_tokens ?? [];

        return $tokens[$component][$property] ?? $fallback;
    }

    /**
     * Get all tokens for a specific component.
     */
    public function getComponentTokens(string $component): array
    {
        $tokens = $this->component_tokens ?? [];

        return $tokens[$component] ?? [];
    }

    /* ── CSS Generation Helpers ────────────────────── */

    /**
     * Build an associative array of CSS variable name => value
     * for all theme properties (excluding component tokens).
     */
    public function toCssVariableMap(): array
    {
        $defaults = config('theme.defaults', []);
        $map = [];

        // Core colors
        $map['--color-primary']   = $this->primary_color   ?? $defaults['primary_color']   ?? '#2563eb';
        $map['--color-secondary'] = $this->secondary_color ?? $defaults['secondary_color'] ?? '#64748b';
        $map['--color-accent']    = $this->accent_color    ?? $defaults['accent_color']    ?? '#10b981';

        // Backgrounds
        $map['--background-primary']   = $this->background_primary   ?? $defaults['background_primary']   ?? '#ffffff';
        $map['--background-secondary'] = $this->background_secondary ?? $defaults['background_secondary'] ?? '#f8fafc';

        // Text
        $map['--text-primary']   = $this->text_primary   ?? $defaults['text_primary']   ?? '#0f172a';
        $map['--text-secondary'] = $this->text_secondary ?? $defaults['text_secondary'] ?? '#475569';

        // Typography
        $map['--font-primary']   = "'" . ($this->font_primary   ?? $defaults['font_primary']   ?? 'Inter') . "', sans-serif";
        $map['--font-secondary'] = "'" . ($this->font_secondary ?? $defaults['font_secondary'] ?? 'Poppins') . "', sans-serif";
        $map['--font-size-base'] = $this->font_size_base ?? $defaults['font_size_base'] ?? '15px';

        // Borders
        $map['--border-radius-sm'] = $this->border_radius_sm ?? $defaults['border_radius_sm'] ?? '6px';
        $map['--border-radius-md'] = $this->border_radius_md ?? $defaults['border_radius_md'] ?? '10px';
        $map['--border-radius-lg'] = $this->border_radius_lg ?? $defaults['border_radius_lg'] ?? '16px';

        // Shadows
        $map['--shadow-sm'] = $this->shadow_sm ?? $defaults['shadow_sm'] ?? '0 1px 2px rgba(0,0,0,0.05)';
        $map['--shadow-md'] = $this->shadow_md ?? $defaults['shadow_md'] ?? '0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06)';
        $map['--shadow-lg'] = $this->shadow_lg ?? $defaults['shadow_lg'] ?? '0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.04)';

        // Legacy compatibility aliases
        $map['--primary']   = $map['--color-primary'];
        $map['--secondary'] = $map['--color-secondary'];
        $map['--primary-color']   = $map['--color-primary'];
        $map['--secondary-color'] = $map['--color-secondary'];

        return $map;
    }

    /**
     * Build CSS variable map for dark mode overrides.
     */
    public function toDarkCssVariableMap(): array
    {
        $darkDefaults = config('theme.dark_defaults', []);
        $map = [];

        $map['--background-primary']   = $this->dark_bg_primary    ?? $darkDefaults['background_primary']   ?? '#0f172a';
        $map['--background-secondary'] = $this->dark_bg_secondary  ?? $darkDefaults['background_secondary'] ?? '#1e293b';
        $map['--text-primary']         = $this->dark_text_primary  ?? $darkDefaults['text_primary']         ?? '#f1f5f9';
        $map['--text-secondary']       = $this->dark_text_secondary ?? $darkDefaults['text_secondary']      ?? '#94a3b8';

        // Derived dark-mode tokens
        $map['--border-color']       = '#334155';
        $map['--border-color-light'] = '#1e293b';
        $map['--card-bg']            = $map['--background-secondary'];
        $map['--navbar-bg']          = 'rgba(15,23,42,0.8)';
        $map['--sidebar-bg']         = '#0c1222';
        $map['--input-bg']           = $map['--background-secondary'];
        $map['--input-border']       = '#334155';
        $map['--table-header-bg']    = $map['--background-secondary'];

        return $map;
    }

    /**
     * Build CSS variable map for component token overrides.
     */
    public function toComponentCssVariableMap(): array
    {
        $tokens = $this->component_tokens ?? [];
        $map = [];

        foreach ($tokens as $component => $properties) {
            foreach ($properties as $property => $value) {
                $varName = "--{$component}-{$property}";
                $map[$varName] = $value;
            }
        }

        return $map;
    }

    /**
     * Format the theme for API response consumption.
     */
    public function toApiResponse(): array
    {
        return [
            'tenantId'   => $this->organization_id,
            'themeSlug'  => $this->theme_slug,
            'themeName'  => $this->theme_name,
            'branding'   => [
                'logo'              => $this->logo_light,
                'logoDark'          => $this->logo_dark,
                'favicon'           => $this->favicon,
                'primaryColor'      => $this->primary_color,
                'secondaryColor'    => $this->secondary_color,
                'accentColor'       => $this->accent_color,
                'backgroundPrimary' => $this->background_primary,
                'backgroundSecondary' => $this->background_secondary,
                'textPrimary'       => $this->text_primary,
                'textSecondary'     => $this->text_secondary,
                'fontFamily'        => $this->font_primary,
                'fontSecondary'     => $this->font_secondary,
                'borderRadius'      => $this->border_radius_md,
                'themeMode'         => $this->theme_mode,
                'themeVersion'      => $this->theme_version,
                'components'        => $this->component_tokens ?? [],
            ],
            'assets' => [
                'logo'         => $this->logo_light,
                'logoDark'     => $this->logo_dark,
                'favicon'      => $this->favicon,
                'appIcon'      => $this->app_icon,
                'splashScreen' => $this->splash_image,
                'emailHeader'  => $this->email_header_image,
                'emailFooter'  => $this->email_footer_image,
            ],
        ];
    }

    /**
     * Generate an ETag for cache validation based on version + timestamp.
     */
    public function generateETag(): string
    {
        return md5($this->theme_version . '|' . ($this->updated_at ?? now())->timestamp);
    }
}
