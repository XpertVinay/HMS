<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Platform Default Theme
    |--------------------------------------------------------------------------
    |
    | These values are used as the ultimate fallback when no tenant theme
    | or legacy organization branding is configured.
    |
    */

    'defaults' => [
        'primary_color'      => '#2563eb',
        'secondary_color'    => '#64748b',
        'accent_color'       => '#10b981',
        'background_primary' => '#ffffff',
        'background_secondary' => '#f8fafc',
        'text_primary'       => '#0f172a',
        'text_secondary'     => '#475569',
        'font_primary'       => 'Inter',
        'font_secondary'     => 'Poppins',
        'font_size_base'     => '15px',
        'border_radius_sm'   => '6px',
        'border_radius_md'   => '10px',
        'border_radius_lg'   => '16px',
        'shadow_sm'          => '0 1px 2px rgba(0,0,0,0.05)',
        'shadow_md'          => '0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06)',
        'shadow_lg'          => '0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.04)',
        'theme_mode'         => 'light',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dark Mode Defaults
    |--------------------------------------------------------------------------
    */

    'dark_defaults' => [
        'background_primary'   => '#0f172a',
        'background_secondary' => '#1e293b',
        'text_primary'         => '#f1f5f9',
        'text_secondary'       => '#94a3b8',
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    */

    'cache_ttl'    => 3600,    // seconds (1 hour)
    'cache_driver' => 'file',  // Use 'redis' in production for better performance

    /*
    |--------------------------------------------------------------------------
    | Custom CSS Security
    |--------------------------------------------------------------------------
    */

    'custom_css_max_size' => 50000, // 50KB max for tenant custom CSS

    /*
    |--------------------------------------------------------------------------
    | Allowed Fonts
    |--------------------------------------------------------------------------
    |
    | Google Fonts that tenants are permitted to select.
    | Empty array = allow any font.
    |
    */

    'allowed_fonts' => [
        'Inter',
        'Poppins',
        'Outfit',
        'Roboto',
        'Open Sans',
        'Montserrat',
        'Lato',
        'Nunito',
        'Raleway',
        'Source Sans Pro',
        'Playfair Display',
        'DM Sans',
        'Plus Jakarta Sans',
        'Manrope',
        'Space Grotesk',
    ],
];
