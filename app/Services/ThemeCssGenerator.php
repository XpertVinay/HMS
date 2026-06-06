<?php

namespace App\Services;

use App\Models\TenantTheme;

/**
 * Generates CSS from TenantTheme models.
 *
 * Produces:
 *  - :root { } block with all CSS variables
 *  - .dark { } block with dark-mode overrides
 *  - Component-scoped variables
 *  - Sanitized custom CSS
 *  - Google Fonts @import directives
 */
class ThemeCssGenerator
{
    /**
     * Generate the complete CSS output for a theme.
     */
    public function generateFullCss(TenantTheme $theme): string
    {
        $parts = [];

        // Google Fonts import
        $fontsImport = $this->generateFontImport($theme);
        if ($fontsImport) {
            $parts[] = $fontsImport;
        }

        // :root variables
        $parts[] = $this->generateRootCss($theme);

        // Dark mode overrides
        $parts[] = $this->generateDarkModeCss($theme);

        // Component token overrides
        $componentCss = $this->generateComponentCss($theme);
        if ($componentCss) {
            $parts[] = $componentCss;
        }

        return implode("\n\n", array_filter($parts));
    }

    /**
     * Generate the :root { } CSS block from theme variables.
     */
    public function generateRootCss(TenantTheme $theme): string
    {
        $variables = $theme->toCssVariableMap();

        // Add derived/computed variables
        $variables = array_merge($variables, $this->getDerivedVariables($variables));

        // Add component defaults
        $variables = array_merge($variables, $this->getComponentDefaults());

        // Add component overrides
        $componentVars = $theme->toComponentCssVariableMap();
        if (!empty($componentVars)) {
            $variables = array_merge($variables, $componentVars);
        }

        return $this->formatCssBlock(':root', $variables);
    }

    /**
     * Generate the .dark { } CSS block for dark mode overrides.
     */
    public function generateDarkModeCss(TenantTheme $theme): string
    {
        $darkVariables = $theme->toDarkCssVariableMap();

        return $this->formatCssBlock('.dark, [data-theme="dark"]', $darkVariables);
    }

    /**
     * Generate component-specific CSS from component_tokens.
     */
    public function generateComponentCss(TenantTheme $theme): string
    {
        $tokens = $theme->component_tokens ?? [];

        if (empty($tokens)) {
            return '';
        }

        // Component tokens are already merged into :root via toComponentCssVariableMap()
        // This method generates any additional component-specific class rules

        $css = "/* ── Component Token Overrides ── */\n";
        $hasRules = false;

        foreach ($tokens as $component => $properties) {
            $rules = [];
            foreach ($properties as $property => $value) {
                $rules[] = "    {$property}: var(--{$component}-{$property}, {$value});";
            }

            if (!empty($rules)) {
                $hasRules = true;
            }
        }

        return $hasRules ? $css : '';
    }

    /**
     * Sanitize tenant-provided custom CSS.
     *
     * Strips potentially dangerous constructs:
     *  - @import directives
     *  - url() pointing to external domains
     *  - javascript: protocol
     *  - expression() (legacy IE XSS)
     *  - behavior: property (legacy IE)
     */
    public function sanitizeCustomCss(string $css): string
    {
        $maxSize = config('theme.custom_css_max_size', 50000);

        // Enforce max size
        $css = mb_substr($css, 0, $maxSize);

        // Strip @import
        $css = preg_replace('/@import\s+[^;]+;/i', '/* @import removed */', $css);

        // Strip url() with external domains (keep relative and data: URIs)
        $css = preg_replace_callback(
            '/url\s*\(\s*[\'"]?(https?:\/\/[^)]+)[\'"]?\s*\)/i',
            fn($m) => '/* external url removed */',
            $css
        );

        // Strip javascript: protocol
        $css = preg_replace('/javascript\s*:/i', '/* blocked */', $css);

        // Strip expression() (IE legacy)
        $css = preg_replace('/expression\s*\(/i', '/* blocked */(', $css);

        // Strip behavior: property (IE legacy)
        $css = preg_replace('/behavior\s*:/i', '/* blocked */', $css);

        // Strip -moz-binding (Firefox legacy)
        $css = preg_replace('/-moz-binding\s*:/i', '/* blocked */', $css);

        return trim($css);
    }

    /**
     * Generate @import for Google Fonts based on theme font selections.
     */
    public function generateFontImport(TenantTheme $theme): string
    {
        $fonts = [];
        $allowedFonts = config('theme.allowed_fonts', []);
        $defaults = config('theme.defaults', []);

        $primary = $theme->font_primary ?? $defaults['font_primary'] ?? 'Inter';
        $secondary = $theme->font_secondary ?? $defaults['font_secondary'] ?? 'Poppins';

        if (in_array($primary, $allowedFonts) || empty($allowedFonts)) {
            $fonts[] = str_replace(' ', '+', $primary) . ':wght@300;400;500;600;700;800';
        }

        if ($secondary !== $primary && (in_array($secondary, $allowedFonts) || empty($allowedFonts))) {
            $fonts[] = str_replace(' ', '+', $secondary) . ':wght@400;500;600;700';
        }

        if (empty($fonts)) {
            return '';
        }

        $familyParam = implode('&family=', $fonts);
        return "@import url('https://fonts.googleapis.com/css2?family={$familyParam}&display=swap');";
    }

    /* ══════════════════════════════════════════════════
     *  Private Helpers
     * ══════════════════════════════════════════════════ */

    /**
     * Derived/computed variables from core theme values.
     */
    private function getDerivedVariables(array $vars): array
    {
        return [
            '--color-danger'      => '#ef4444',
            '--color-warning'     => '#f59e0b',
            '--color-success'     => '#22c55e',
            '--color-info'        => '#3b82f6',

            '--background-tertiary' => '#f1f5f9',

            '--text-tertiary'       => '#94a3b8',
            '--text-inverse'        => '#ffffff',

            '--font-size-sm'        => '13px',
            '--font-size-lg'        => '18px',
            '--font-size-xl'        => '24px',
            '--font-size-2xl'       => '32px',

            '--border-radius-xl'    => '24px',
            '--border-radius-full'  => '9999px',
            '--border-color'        => '#e2e8f0',
            '--border-color-light'  => '#f1f5f9',

            '--shadow-xl'           => '0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.04)',

            '--spacing-xs'          => '4px',
            '--spacing-sm'          => '8px',
            '--spacing-md'          => '16px',
            '--spacing-lg'          => '24px',
            '--spacing-xl'          => '32px',
            '--spacing-2xl'         => '48px',
        ];
    }

    /**
     * Default component token variables.
     */
    private function getComponentDefaults(): array
    {
        return [
            '--button-bg'        => 'var(--color-primary)',
            '--button-text'      => 'var(--text-inverse)',
            '--button-radius'    => 'var(--border-radius-md)',
            '--button-padding'   => '10px 24px',

            '--card-bg'          => 'var(--background-primary)',
            '--card-shadow'      => 'var(--shadow-md)',
            '--card-radius'      => 'var(--border-radius-lg)',
            '--card-border'      => 'var(--border-color-light)',

            '--sidebar-bg'       => 'var(--color-secondary)',
            '--sidebar-text'     => 'rgba(255,255,255,0.6)',
            '--sidebar-active-bg' => 'var(--color-primary)',
            '--sidebar-width'    => '260px',

            '--navbar-bg'        => 'rgba(255,255,255,0.8)',
            '--navbar-shadow'    => 'var(--shadow-sm)',
            '--navbar-height'    => '72px',

            '--input-bg'         => 'var(--background-secondary)',
            '--input-border'     => '#cbd5e1',
            '--input-focus-border' => 'var(--color-primary)',
            '--input-radius'     => 'var(--border-radius-md)',

            '--table-header-bg'  => 'var(--background-secondary)',
            '--table-header-text' => 'var(--text-secondary)',
            '--table-border'     => 'var(--border-color-light)',
            '--table-hover-bg'   => 'var(--background-secondary)',

            '--modal-overlay-bg' => 'rgba(0,0,0,0.5)',
            '--modal-bg'         => 'var(--background-primary)',
            '--modal-radius'     => 'var(--border-radius-lg)',

            '--badge-radius'     => '30px',
            '--badge-font-size'  => '12px',
        ];
    }

    /**
     * Format a CSS block from variable map.
     */
    private function formatCssBlock(string $selector, array $variables): string
    {
        $lines = [];
        foreach ($variables as $name => $value) {
            $lines[] = "    {$name}: {$value};";
        }

        return "{$selector} {\n" . implode("\n", $lines) . "\n}";
    }
}
