<?php

namespace App\Services;

use App\Models\FirebaseCredential;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class FirebaseCredentialsService
{
    private const CACHE_PREFIX = 'firebase.credentials.';

    /**
     * Load active Firebase service account credentials from the database.
     *
     * @return array<string, mixed>|null
     */
    public function getCredentials(?string $projectKey = null): ?array
    {
        $projectKey ??= (string) config('firebase.default', 'app');

        if (!Schema::hasTable('firebase_credentials')) {
            return null;
        }

        return Cache::remember(
            self::CACHE_PREFIX.$projectKey,
            now()->addHour(),
            function () use ($projectKey): ?array {
                $record = FirebaseCredential::query()
                    ->where('project_key', $projectKey)
                    ->where('is_active', true)
                    ->first();

                $credentials = $record?->credentials;

                return is_array($credentials) && $credentials !== [] ? $credentials : null;
            }
        );
    }

    /**
     * Store or replace Firebase credentials in the database.
     *
     * @param  array<string, mixed>  $credentials
     */
    public function store(array $credentials, string $projectKey = 'app', bool $isActive = true): FirebaseCredential
    {
        $record = FirebaseCredential::query()->updateOrCreate(
            ['project_key' => $projectKey],
            [
                'credentials' => $credentials,
                'is_active' => $isActive,
            ],
        );

        $this->clearCache($projectKey);

        return $record;
    }

    public function clearCache(?string $projectKey = null): void
    {
        if ($projectKey !== null) {
            Cache::forget(self::CACHE_PREFIX.$projectKey);

            return;
        }

        $projectKey = (string) config('firebase.default', 'app');
        Cache::forget(self::CACHE_PREFIX.$projectKey);
    }

    /**
     * Apply database credentials to the runtime Firebase config.
     */
    public function applyToConfig(?string $projectKey = null): bool
    {
        $projectKey ??= (string) config('firebase.default', 'app');
        $credentials = $this->getCredentials($projectKey);

        if ($credentials === null) {
            return false;
        }

        config(["firebase.projects.{$projectKey}.credentials" => $credentials]);

        return true;
    }
}
