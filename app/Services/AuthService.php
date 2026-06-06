<?php

namespace App\Services;

use App\Models\SuperAdmin;
use App\Models\Admin;
use App\Models\Member;
use App\Models\Staff;
use App\Models\Resident;
use App\Models\AppVendor;
use Illuminate\Support\Facades\Hash;

/**
 * Centralized authentication service.
 * Replaces the legacy multi-table login logic from Includes/session.php.
 */
class AuthService
{
    /**
     * Map of role → [model class, session key for user ID, dashboard route].
     */
    private const ROLE_CONFIG = [
        'super_admin' => [
            'model' => SuperAdmin::class,
            'id_key' => 'aid',
            'dashboard' => 'super_admin.dashboard',
            'org_scoped' => false,
        ],
        'admin' => [
            'model' => Admin::class,
            'id_key' => 'aid',
            'dashboard' => 'admin.dashboard',
            'org_scoped' => true,
        ],
        'staff' => [
            'model' => Staff::class,
            'id_key' => 'aid',
            'dashboard' => 'staff.dashboard',
            'org_scoped' => true,
        ],
        'member' => [
            'model' => Member::class,
            'id_key' => 'uid',
            'dashboard' => 'member.dashboard',
            'org_scoped' => true,
        ],
        'resident' => [
            'model' => Resident::class,
            'id_key' => 'rid',
            'dashboard' => 'resident.dashboard',
            'org_scoped' => true,
        ],
        'vendor' => [
            'model' => AppVendor::class,
            'id_key' => 'vid',
            'dashboard' => 'vendor.dashboard',
            'org_scoped' => false,
        ],
    ];

    /**
     * Attempt login across all user tables.
     *
     * @return array{success: bool, redirect?: string, error?: string}
     */
    public function attempt(string $username, string $password, int $orgId): array
    {
        foreach (self::ROLE_CONFIG as $role => $config) {
            $user = $this->findUser($config['model'], $username, $orgId, $config['org_scoped']);

            if (!$user) {
                continue;
            }

            $validation = $this->validatePassword($password, $user->password);

            if (!$validation['valid']) {
                continue;
            }

            // Rehash legacy plaintext passwords
            if ($validation['needs_rehash']) {
                $user->password = Hash::make($password);
                $user->save();
            }

            // Set session data
            $this->setSession($user, $role, $config, $orgId);

            return [
                'success' => true,
                'redirect' => $config['dashboard'],
            ];
        }

        return [
            'success' => false,
            'error' => 'Invalid username or password.',
        ];
    }

    /**
     * Attempt API login across all user tables using JWT.
     *
     * @return array{success: bool, token?: string, role?: string, user?: mixed, error?: string}
     */
    public function attemptApi(string $username, string $password, int $orgId): array
    {
        foreach (self::ROLE_CONFIG as $role => $config) {
            $user = $this->findUser($config['model'], $username, $orgId, $config['org_scoped']);

            if (!$user) {
                continue;
            }

            $validation = $this->validatePassword($password, $user->password);

            if (!$validation['valid']) {
                continue;
            }

            if ($validation['needs_rehash']) {
                $user->password = Hash::make($password);
                $user->save();
            }

            $guardName = 'api_' . $role;
            $token = auth($guardName)->login($user);

            return [
                'success' => true,
                'token' => $token,
                'role' => $role,
                'user' => $user,
            ];
        }

        return [
            'success' => false,
            'error' => 'Invalid credentials.',
        ];
    }

    /**
     * Find a user by username or email, optionally scoped to organization.
     */
    private function findUser(string $modelClass, string $username, int $orgId, bool $orgScoped)
    {
        $query = $modelClass::where(function ($q) use ($username) {
            // Vendor uses business_name instead of username
            if (method_exists($q->getModel(), 'getUsernameAttribute')) {
                $q->where('business_name', $username)->orWhere('email', $username);
            } else {
                $q->where('username', $username)->orWhere('email', $username);
            }
        });

        if ($orgScoped) {
            $query->where('organization_id', $orgId);
        }

        return $query->first();
    }

    /**
     * Validate password supporting both bcrypt hashes and legacy plaintext.
     */
    private function validatePassword(string $input, string $stored): array
    {
        // Check if stored password is a bcrypt hash
        if (str_starts_with($stored, '$2y$') || str_starts_with($stored, '$2a$')) {
            return [
                'valid' => Hash::check($input, $stored),
                'needs_rehash' => false,
            ];
        }

        // Legacy plaintext comparison
        return [
            'valid' => $input === $stored,
            'needs_rehash' => true,
        ];
    }

    /**
     * Set all session variables for the authenticated user.
     */
    private function setSession($user, string $role, array $config, int $orgId): void
    {
        $displayName = $user->name ?? $user->contact_name ?? $user->business_name ?? $user->username ?? 'User';

        session([
            'logged' => true,
            'username' => $user->username ?? $user->business_name ?? '',
            'display_name' => $displayName,
            'account' => $role,
            $config['id_key'] => $user->id,
        ]);

        if ($config['org_scoped']) {
            session(['organization_id' => $orgId]);
        }

        if ($role === 'member') {
            session(['member' => $user->name ?? 'Member']);
        }
    }

    /**
     * Clear the session (logout).
     */
    public function logout(): void
    {
        session()->flush();
    }

    /**
     * Get the dashboard route name for the current session role.
     */
    public function getDashboardRoute(): string
    {
        $role = session('account', 'member');
        return self::ROLE_CONFIG[$role]['dashboard'] ?? 'login';
    }
}
