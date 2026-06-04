<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the active organization from the subdomain or ?org= query param.
 * Binds the resolved Organization to the service container and shares it with all views.
 *
 * Replaces the legacy config/app.php subdomain resolution logic.
 */
class ResolveOrganization
{
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $this->resolveSubdomain($request);

        $org = Organization::where('subdomain', $subdomain)->first();

        if (!$org) {
            // Fallback to default organization
            $org = Organization::find(1) ?? $this->defaultOrganization();
        }

        // Bind to container so it can be injected anywhere
        app()->instance('active_org', $org);

        // Share with all Blade views
        view()->share('activeOrg', $org);

        // Store in session for backwards compatibility
        session(['active_org_id' => $org->id]);

        return $next($request);
    }

    /**
     * Extract the subdomain from the request host.
     * Supports override via ?org= query parameter for development.
     */
    private function resolveSubdomain(Request $request): string
    {
        // Development override via query parameter
        if ($request->has('org')) {
            $subdomain = $request->query('org');
            session(['dev_org' => $subdomain]);
            return $subdomain;
        }

        if (session()->has('dev_org')) {
            return session('dev_org');
        }

        // Extract subdomain from host (e.g., org1.rcms.businzo.com → org1)
        $host = $request->getHost();
        $parts = explode('.', $host);

        if (count($parts) >= 3 && $parts[0] !== 'www') {
            return $parts[0];
        }

        return 'default';
    }

    /**
     * Returns a fallback Organization object when no DB record is found.
     */
    private function defaultOrganization(): Organization
    {
        $org = new Organization();
        $org->id = 1;
        $org->name = 'Default RWA';
        $org->status = 'approved';
        $org->logo_url = null;
        $org->primary_color = null;
        $org->secondary_color = null;
        return $org;
    }
}
