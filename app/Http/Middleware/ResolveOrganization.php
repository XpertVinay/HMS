<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use App\Services\TenantResolver;
use App\Services\ThemeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the active organization from the request domain/subdomain,
 * loads the active theme, and shares both with the application.
 *
 * Replaces the legacy subdomain-only resolution with full support for:
 *  - Custom domains (myrwa.com)
 *  - Subdomains (org1.businzo.com)
 *  - Query param override (?org=slug)
 *  - Theme CSS injection into Blade views
 */
class ResolveOrganization
{
    public function __construct(
        protected TenantResolver $tenantResolver,
        protected ThemeService $themeService,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $businzoDomains = array_filter(explode(' ', (string) env('BUSINZO_DOMAIN', 'businzo.local.com www.businzo.local.com')));

        if (in_array($request->getHost(), $businzoDomains, true)) {
            return $next($request);
        }

        // ── 1. Resolve Organization ──────────────────────
        $org = $this->tenantResolver->resolve($request);

        if (!$org) {
            $host = strtolower($request->getHost());
            $baseHost = strtolower(parse_url(config('app.url'), PHP_URL_HOST) ?? 'localhost');
            
            $cleanHost = preg_replace('/^www\./', '', $host);
            $cleanBaseHost = preg_replace('/^www\./', '', $baseHost);
            
            $isIp = filter_var($cleanHost, FILTER_VALIDATE_IP);
            
            // If the host is not the base domain, not an IP, and not localhost, then it's an unrecognized
            // subdomain or custom domain. We must throw a 404 instead of showing the default portal.
            if (!$isIp && $cleanHost !== $cleanBaseHost && $cleanHost !== 'localhost') {
                abort(404, "Organization not found for this domain/subdomain.");
            }

            // Fallback to default organization for the main portal
            $org = Organization::find(1) ?? $this->defaultOrganization();
        }

        if ($org->status !== 'approved') {
            abort(403, "This organization is currently {$org->status} and cannot be accessed.");
        }

        // Eager-load the active theme to avoid N+1
        if ($org->exists && !$org->relationLoaded('activeTheme')) {
            $org->load('activeTheme');
        }

        // ── 2. Resolve Theme ─────────────────────────────
        $theme = $this->themeService->resolveTheme($org);
        $themeCss = $this->themeService->getThemeCss($org);
        $themeCustomCss = $this->themeService->getCustomCss($theme);

        // ── 3. Bind to Container ─────────────────────────
        app()->instance('active_org', $org);
        app()->instance('active_theme', $theme);

        // ── 4. Share with Blade Views ────────────────────
        view()->share('activeOrg', $org);
        view()->share('theme', $theme);
        view()->share('themeCss', $themeCss);
        view()->share('themeCustomCss', $themeCustomCss);
        view()->share('themeMode', $theme->theme_mode ?? 'light');

        // ── 5. Session for Backward Compatibility ────────
        session(['active_org_id' => $org->id]);

        return $next($request);
    }

    /**
     * Returns a fallback Organization object when no DB record is found.
     */
    private function defaultOrganization(): Organization
    {
        $org = new Organization();
        $org->id = 1;
        $org->name = 'Businzo Technologies';
        $org->status = 'approved';
        $org->logo_url = null;
        $org->primary_color = null;
        $org->secondary_color = null;
        return $org;
    }
}
