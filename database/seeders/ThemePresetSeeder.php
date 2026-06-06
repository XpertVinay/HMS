<?php

namespace Database\Seeders;

use App\Models\ThemePreset;
use Illuminate\Database\Seeder;

/**
 * Seeds 5 built-in system theme presets:
 *   Corporate, Modern, Luxury, Minimal, Community
 *
 * These are starting points that admins can apply to any organization.
 */
class ThemePresetSeeder extends Seeder
{
    public function run(): void
    {
        $presets = [
            [
                'name'        => 'Corporate',
                'slug'        => 'corporate',
                'description' => 'Professional navy and slate palette with sharp corners and clean typography. Ideal for formal housing societies and corporate townships.',
                'is_system'   => true,
                'theme_data'  => [
                    'primary_color'      => '#1e40af',
                    'secondary_color'    => '#334155',
                    'accent_color'       => '#0ea5e9',
                    'background_primary' => '#ffffff',
                    'background_secondary' => '#f8fafc',
                    'text_primary'       => '#0f172a',
                    'text_secondary'     => '#475569',
                    'dark_bg_primary'    => '#0f172a',
                    'dark_bg_secondary'  => '#1e293b',
                    'dark_text_primary'  => '#f1f5f9',
                    'dark_text_secondary' => '#94a3b8',
                    'font_primary'       => 'Inter',
                    'font_secondary'     => 'Inter',
                    'font_size_base'     => '15px',
                    'border_radius_sm'   => '4px',
                    'border_radius_md'   => '6px',
                    'border_radius_lg'   => '8px',
                    'shadow_sm'          => '0 1px 2px rgba(0,0,0,0.05)',
                    'shadow_md'          => '0 4px 6px -1px rgba(0,0,0,0.08)',
                    'shadow_lg'          => '0 10px 15px -3px rgba(0,0,0,0.08)',
                    'theme_mode'         => 'light',
                    'component_tokens'   => [
                        'button'  => ['border-radius' => '6px'],
                        'card'    => ['border-radius' => '8px', 'shadow' => '0 1px 3px rgba(0,0,0,0.08)'],
                        'sidebar' => ['background' => '#1e293b'],
                        'navbar'  => ['background' => 'rgba(255,255,255,0.95)'],
                    ],
                ],
            ],
            [
                'name'        => 'Modern',
                'slug'        => 'modern',
                'description' => 'Vibrant blue and teal with generous rounded corners and glassmorphism effects. Perfect for tech-forward communities.',
                'is_system'   => true,
                'theme_data'  => [
                    'primary_color'      => '#2563eb',
                    'secondary_color'    => '#0d9488',
                    'accent_color'       => '#8b5cf6',
                    'background_primary' => '#ffffff',
                    'background_secondary' => '#f0f9ff',
                    'text_primary'       => '#0f172a',
                    'text_secondary'     => '#475569',
                    'dark_bg_primary'    => '#0c1222',
                    'dark_bg_secondary'  => '#162032',
                    'dark_text_primary'  => '#e2e8f0',
                    'dark_text_secondary' => '#94a3b8',
                    'font_primary'       => 'Outfit',
                    'font_secondary'     => 'Inter',
                    'font_size_base'     => '15px',
                    'border_radius_sm'   => '8px',
                    'border_radius_md'   => '12px',
                    'border_radius_lg'   => '20px',
                    'shadow_sm'          => '0 1px 3px rgba(0,0,0,0.04)',
                    'shadow_md'          => '0 4px 12px rgba(0,0,0,0.08)',
                    'shadow_lg'          => '0 12px 32px rgba(0,0,0,0.12)',
                    'theme_mode'         => 'light',
                    'component_tokens'   => [
                        'button'  => ['border-radius' => '12px'],
                        'card'    => ['border-radius' => '20px', 'shadow' => '0 4px 16px rgba(0,0,0,0.06)'],
                        'sidebar' => ['background' => 'linear-gradient(180deg, #0d9488 0%, #0c1222 100%)'],
                        'navbar'  => ['background' => 'rgba(255,255,255,0.7)'],
                    ],
                ],
            ],
            [
                'name'        => 'Luxury',
                'slug'        => 'luxury',
                'description' => 'Elegant gold and charcoal with premium typography and deep shadows. Designed for upscale residential communities.',
                'is_system'   => true,
                'theme_data'  => [
                    'primary_color'      => '#b8860b',
                    'secondary_color'    => '#1c1c1e',
                    'accent_color'       => '#d4af37',
                    'background_primary' => '#fdfcfa',
                    'background_secondary' => '#f5f3ef',
                    'text_primary'       => '#1c1c1e',
                    'text_secondary'     => '#6b6b6b',
                    'dark_bg_primary'    => '#121212',
                    'dark_bg_secondary'  => '#1e1e1e',
                    'dark_text_primary'  => '#f5f3ef',
                    'dark_text_secondary' => '#a0a0a0',
                    'font_primary'       => 'Playfair Display',
                    'font_secondary'     => 'Inter',
                    'font_size_base'     => '16px',
                    'border_radius_sm'   => '6px',
                    'border_radius_md'   => '10px',
                    'border_radius_lg'   => '16px',
                    'shadow_sm'          => '0 2px 4px rgba(0,0,0,0.06)',
                    'shadow_md'          => '0 6px 16px rgba(0,0,0,0.1)',
                    'shadow_lg'          => '0 16px 48px rgba(0,0,0,0.14)',
                    'theme_mode'         => 'light',
                    'component_tokens'   => [
                        'button'  => ['border-radius' => '8px', 'background' => 'linear-gradient(135deg, #b8860b 0%, #d4af37 100%)'],
                        'card'    => ['border-radius' => '16px', 'shadow' => '0 8px 24px rgba(0,0,0,0.08)'],
                        'sidebar' => ['background' => 'linear-gradient(180deg, #1c1c1e 0%, #000000 100%)'],
                        'navbar'  => ['background' => 'rgba(253,252,250,0.95)'],
                    ],
                ],
            ],
            [
                'name'        => 'Minimal',
                'slug'        => 'minimal',
                'description' => 'Clean monochrome palette with system fonts, flat design, and minimal shadows. For communities that prefer simplicity.',
                'is_system'   => true,
                'theme_data'  => [
                    'primary_color'      => '#18181b',
                    'secondary_color'    => '#3f3f46',
                    'accent_color'       => '#71717a',
                    'background_primary' => '#ffffff',
                    'background_secondary' => '#fafafa',
                    'text_primary'       => '#18181b',
                    'text_secondary'     => '#71717a',
                    'dark_bg_primary'    => '#18181b',
                    'dark_bg_secondary'  => '#27272a',
                    'dark_text_primary'  => '#fafafa',
                    'dark_text_secondary' => '#a1a1aa',
                    'font_primary'       => 'DM Sans',
                    'font_secondary'     => 'DM Sans',
                    'font_size_base'     => '15px',
                    'border_radius_sm'   => '4px',
                    'border_radius_md'   => '6px',
                    'border_radius_lg'   => '8px',
                    'shadow_sm'          => '0 1px 2px rgba(0,0,0,0.03)',
                    'shadow_md'          => '0 1px 3px rgba(0,0,0,0.06)',
                    'shadow_lg'          => '0 2px 6px rgba(0,0,0,0.08)',
                    'theme_mode'         => 'light',
                    'component_tokens'   => [
                        'button'  => ['border-radius' => '6px'],
                        'card'    => ['border-radius' => '8px', 'shadow' => 'none', 'border-color' => '#e4e4e7'],
                        'sidebar' => ['background' => '#18181b'],
                        'navbar'  => ['background' => '#ffffff'],
                    ],
                ],
            ],
            [
                'name'        => 'Community',
                'slug'        => 'community',
                'description' => 'Warm green and earth tones with friendly rounded corners. Ideal for neighborhood and community-focused organizations.',
                'is_system'   => true,
                'theme_data'  => [
                    'primary_color'      => '#059669',
                    'secondary_color'    => '#064e3b',
                    'accent_color'       => '#fbbf24',
                    'background_primary' => '#ffffff',
                    'background_secondary' => '#f0fdf4',
                    'text_primary'       => '#1a2e05',
                    'text_secondary'     => '#4d7c0f',
                    'dark_bg_primary'    => '#052e16',
                    'dark_bg_secondary'  => '#064e3b',
                    'dark_text_primary'  => '#ecfdf5',
                    'dark_text_secondary' => '#86efac',
                    'font_primary'       => 'Poppins',
                    'font_secondary'     => 'Nunito',
                    'font_size_base'     => '15px',
                    'border_radius_sm'   => '8px',
                    'border_radius_md'   => '14px',
                    'border_radius_lg'   => '20px',
                    'shadow_sm'          => '0 1px 3px rgba(5,150,105,0.08)',
                    'shadow_md'          => '0 4px 12px rgba(5,150,105,0.1)',
                    'shadow_lg'          => '0 12px 28px rgba(5,150,105,0.12)',
                    'theme_mode'         => 'light',
                    'component_tokens'   => [
                        'button'  => ['border-radius' => '14px'],
                        'card'    => ['border-radius' => '20px', 'shadow' => '0 4px 12px rgba(5,150,105,0.08)'],
                        'sidebar' => ['background' => 'linear-gradient(180deg, #064e3b 0%, #022c22 100%)'],
                        'navbar'  => ['background' => 'rgba(240,253,244,0.9)'],
                    ],
                ],
            ],
        ];

        foreach ($presets as $data) {
            ThemePreset::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
