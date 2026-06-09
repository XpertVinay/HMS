<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Checks if the authenticated user has the required role(s).
 * Usage in routes: ->middleware('role:admin') or ->middleware('role:admin,staff')
 */
class CheckDomain
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $blockedDomains = [
            'businzo.local.com',
            'www.businzo.local.com',
        ];

        if (in_array($request->getHost(), $blockedDomains)) {
            return redirect($request->getSchemeAndHttpHost()); // or abort(404);
        }

        return $next($request);
    }
}
