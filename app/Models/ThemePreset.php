<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Reusable theme presets (system-defined or custom-created).
 *
 * System presets (is_system=true) are seeded at installation
 * and cannot be deleted by users.
 */
class ThemePreset extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'theme_data',
        'preview_image',
        'is_system',
    ];

    protected $casts = [
        'theme_data' => 'array',
        'is_system'  => 'boolean',
    ];

    /* ── Scopes ────────────────────────────────────── */

    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    public function scopeCustom($query)
    {
        return $query->where('is_system', false);
    }

    /* ── Helpers ───────────────────────────────────── */

    /**
     * Apply this preset's theme data to a TenantTheme model.
     */
    public function applyTo(TenantTheme $theme): TenantTheme
    {
        $data = $this->theme_data ?? [];

        $theme->fill(collect($data)->only([
            'primary_color', 'secondary_color', 'accent_color',
            'background_primary', 'background_secondary',
            'text_primary', 'text_secondary',
            'dark_bg_primary', 'dark_bg_secondary',
            'dark_text_primary', 'dark_text_secondary',
            'font_primary', 'font_secondary', 'font_size_base',
            'border_radius_sm', 'border_radius_md', 'border_radius_lg',
            'shadow_sm', 'shadow_md', 'shadow_lg',
            'theme_mode', 'component_tokens',
        ])->toArray());

        return $theme;
    }
}
