<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ThemePreset;
use App\Services\ThemeService;
use App\Services\TenantResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * REST API for the White-Label Theme Engine.
 *
 * Provides theme resolution, CSS delivery, and preset listing
 * for web and future mobile clients.
 */
class ThemeController extends Controller
{
    public function __construct(
        protected ThemeService $themeService,
        protected TenantResolver $tenantResolver,
    ) {}

    /**
     * GET /api/theme/resolve
     *
     * Resolves the theme based on the current request's domain/subdomain.
     */
    public function resolve(Request $request): JsonResponse
    {
        $org = $this->tenantResolver->resolve($request);

        if (!$org) {
            return response()->json([
                'error'   => 'tenant_not_found',
                'message' => 'No tenant could be resolved from the current domain.',
            ], 404);
        }

        $theme = $this->themeService->resolveTheme($org);

        return response()->json(array_merge(
            $theme->toApiResponse(),
            ['tenantSlug' => $org->subdomain, 'tenantName' => $org->name]
        ));
    }

    /**
     * GET /api/theme/{orgId}
     *
     * Get the active theme for a specific organization.
     */
    public function show(int $orgId): JsonResponse
    {
        $org = \App\Models\Organization::find($orgId);

        if (!$org) {
            return response()->json([
                'error'   => 'organization_not_found',
                'message' => 'Organization not found.',
            ], 404);
        }

        $theme = $this->themeService->resolveTheme($org);

        return response()->json(array_merge(
            $theme->toApiResponse(),
            ['tenantSlug' => $org->subdomain, 'tenantName' => $org->name]
        ));
    }

    /**
     * GET /api/theme/{orgId}/css
     *
     * Returns the raw generated CSS for an organization.
     * Supports ETag-based cache validation.
     */
    public function css(Request $request, int $orgId): Response
    {
        $org = \App\Models\Organization::find($orgId);

        if (!$org) {
            return response('/* Organization not found */', 404)
                ->header('Content-Type', 'text/css');
        }

        $theme = $this->themeService->resolveTheme($org);
        $etag = '"' . $theme->generateETag() . '"';

        // ETag validation: return 304 if client has current version
        if ($request->header('If-None-Match') === $etag) {
            return response('', 304)
                ->header('ETag', $etag)
                ->header('Cache-Control', 'public, max-age=3600');
        }

        $css = $this->themeService->getThemeCss($org);

        // Append custom CSS if present
        $customCss = $this->themeService->getCustomCss($theme);
        if ($customCss) {
            $css .= "\n\n/* ── Custom CSS ── */\n" . $customCss;
        }

        return response($css, 200)
            ->header('Content-Type', 'text/css; charset=UTF-8')
            ->header('ETag', $etag)
            ->header('Cache-Control', 'public, max-age=3600')
            ->header('X-Theme-Version', $theme->theme_version);
    }

    /**
     * GET /api/theme/presets
     *
     * List all available theme presets.
     */
    public function presets(): JsonResponse
    {
        $presets = ThemePreset::orderBy('is_system', 'desc')
                              ->orderBy('name')
                              ->get(['id', 'name', 'slug', 'description', 'preview_image', 'is_system']);

        return response()->json(['presets' => $presets]);
    }
}
