<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Checks if the authenticated user has the required role(s).
 * Usage in routes: ->middleware('role:admin') or ->middleware('role:admin,staff')
 */
class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $userRole = session('account');

        if (!$userRole || !in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            abort(403, 'You do not have permission to access this page.');
        }

        // Check organization status for non-super_admins
        if ($userRole !== 'super_admin') {
            $org = app('active_org');
            if ($org && $org->status !== 'approved') {
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => "Your organization is currently {$org->status} and cannot access the platform."
                    ], 403);
                }

                return redirect()->route('login')
                    ->with('error', "Your organization is currently {$org->status} and cannot access the platform.");
            }
        }

        return $next($request);
    }
}
