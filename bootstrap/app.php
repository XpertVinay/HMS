<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ResolveOrganization;
use App\Http\Middleware\EnsureAuthenticated;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckDomain;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Theme Engine API routes (stateless, no session middleware)
            require __DIR__ . '/../routes/api.php';
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware — runs on every web request
        $middleware->append(ResolveOrganization::class);

        // Named middleware aliases for use in routes
        $middleware->alias([
            'auth.session' => EnsureAuthenticated::class,
            'role' => CheckRole::class,
            'domain' => CheckDomain::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
