<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\TenantDomain;
use Illuminate\Http\Request;

/**
 * Resolves the active tenant (Organization) from the incoming HTTP request.
 *
 * Supports:
 *  1. Custom domains  → myrwa.com, community.network.com
 *  2. Subdomains      → org1.businzo.com
 *  3. Query param     → ?org=slug (dev mode only)
 *  4. Session fallback → sticky dev override
 */
class TenantResolver
{
    /**
     * Resolve the organization from the request.
     */
    public function resolve(Request $request): ?Organization
    {
        // 1. Dev mode override via ?org= query parameter
        $org = $this->resolveByQueryParam($request);
        if ($org) return $org;

        // 2. Session-based dev override (sticky)
        $org = $this->resolveBySession($request);
        if ($org) return $org;

        $host = $request->getHost();

        // 3. Try custom domain lookup (e.g., myrwa.com, community.network.com)
        $org = $this->resolveByCustomDomain($host);
        if ($org) return $org;

        // 4. Try subdomain extraction (e.g., org1.businzo.com → org1)
        $org = $this->resolveBySubdomain($host);
        if ($org) return $org;

        return null;
    }

    /**
     * Resolve via ?org= query parameter (development only).
     */
    private function resolveByQueryParam(Request $request): ?Organization
    {
        if (!$request->has('org')) {
            return null;
        }

        $slug = $request->query('org');
        session(['dev_org' => $slug]);

        return Organization::where('subdomain', $slug)->first();
    }

    /**
     * Resolve via session-stored dev override.
     */
    private function resolveBySession(Request $request): ?Organization
    {
        if (!session()->has('dev_org')) {
            return null;
        }

        return Organization::where('subdomain', session('dev_org'))->first();
    }

    /**
     * Resolve via full custom domain lookup in tenant_domains table.
     */
    private function resolveByCustomDomain(string $host): ?Organization
    {
        $tenantDomain = TenantDomain::resolveByDomain($host);

        if ($tenantDomain) {
            return $tenantDomain->organization;
        }

        return null;
    }

    /**
     * Resolve via subdomain extraction from the host.
     *
     * Extracts the first segment from hosts like:
     *   org1.businzo.com → org1
     *   green-valley.platform.com → green-valley
     *
     * Also checks tenant_domains.subdomain for explicit mappings.
     */
    private function resolveBySubdomain(string $host): ?Organization
    {
        $parts = explode('.', $host);

        // Need at least 3 parts for a subdomain (sub.domain.tld)
        if (count($parts) < 3 || $parts[0] === 'www') {
            return null;
        }

        $subdomain = $parts[0];

        // First check tenant_domains for explicit subdomain mapping
        $tenantDomain = TenantDomain::resolveBySubdomain($subdomain);
        if ($tenantDomain) {
            return $tenantDomain->organization;
        }

        // Fallback: check organizations.subdomain directly (legacy)
        return Organization::where('subdomain', $subdomain)->first();
    }
}
