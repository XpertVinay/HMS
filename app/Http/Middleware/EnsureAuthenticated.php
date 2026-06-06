<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the user is authenticated via session.
 * Replaces the legacy Includes/session.php auth check.
 */
class EnsureAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('logged') || session('logged') !== true) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        // Share auth data with all views
        view()->share('username', session('username'));
        view()->share('accountType', session('account'));
        view()->share('userId', session('uid') ?? session('aid') ?? session('rid') ?? session('vid'));

        return $next($request);
    }
}
