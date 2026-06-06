<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Caching layer for generated theme CSS.
 *
 * Uses file-based cache by default (upgradeable to Redis).
 * Cache keys incorporate org ID + theme version for automatic
 * invalidation on version bumps.
 */
class ThemeCacheService
{
    /**
     * Get cached CSS for an organization + version.
     */
    public function getCachedCss(int $orgId, string $version): ?string
    {
        $key = $this->cacheKey($orgId, $version);

        return Cache::store($this->driver())->get($key);
    }

    /**
     * Cache generated CSS.
     */
    public function cacheThemeCss(int $orgId, string $version, string $css): void
    {
        $key = $this->cacheKey($orgId, $version);
        $ttl = config('theme.cache_ttl', 3600);

        Cache::store($this->driver())->put($key, $css, $ttl);
    }

    /**
     * Invalidate all cached CSS for an organization.
     *
     * Since cache keys include the version, we use a "bust key" pattern:
     * store a bust timestamp that causes version-based keys to miss.
     */
    public function invalidateCache(int $orgId): void
    {
        $bustKey = "theme_bust_{$orgId}";
        Cache::store($this->driver())->put($bustKey, now()->timestamp, 86400);

        // Also try to forget common version keys
        for ($i = 0; $i < 10; $i++) {
            Cache::store($this->driver())->forget("theme_css_{$orgId}_*");
        }
    }

    /**
     * Warm the cache for a specific org + version.
     */
    public function warmCache(int $orgId, string $version, string $css): void
    {
        $this->cacheThemeCss($orgId, $version, $css);
    }

    /**
     * Generate a cache key incorporating org ID and theme version.
     */
    private function cacheKey(int $orgId, string $version): string
    {
        return "theme_css_{$orgId}_{$version}";
    }

    /**
     * Get the configured cache driver.
     */
    private function driver(): string
    {
        return config('theme.cache_driver', 'file');
    }
}
