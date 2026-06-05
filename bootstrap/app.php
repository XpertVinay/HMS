<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ResolveOrganization;
use App\Http\Middleware\EnsureAuthenticated;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware — runs on every web request
        $middleware->append(ResolveOrganization::class);
        
        // Trust all proxies for VPS deployments to respect HTTPS
        $middleware->trustProxies(at: '*');

        // Named middleware aliases for use in routes
        $middleware->alias([
            'auth.session' => EnsureAuthenticated::class,
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
