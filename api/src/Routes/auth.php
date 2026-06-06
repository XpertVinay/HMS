<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AuthController;
use App\Middleware\JwtAuthMiddleware;

$app->group('/api/v1/auth', function (RouteCollectorProxy $group) {
    $group->post('/login', [AuthController::class, 'login']);
    $group->post('/refresh', [AuthController::class, 'refresh']);
    $group->post('/logout', [AuthController::class, 'logout'])->add(new JwtAuthMiddleware());
});

$app->group('/api/v1/mobile/auth', function (RouteCollectorProxy $group) {
    $group->post('/qr-login', [\App\Controllers\MobileAuthController::class, 'qrLogin']);
    $group->post('/refresh', [\App\Controllers\MobileAuthController::class, 'refresh']);
})->add(new \App\Middleware\RateLimitMiddleware(5, 60)); // Max 5 requests per 60 seconds

$app->group('/api/v1/mobile', function (RouteCollectorProxy $group) {
    $group->get('/navigation', [\App\Controllers\NavigationController::class, 'getNavigation']);
})->add(new \App\Middleware\TenantResolutionMiddleware())
  ->add(new \App\Middleware\JwtAuthMiddleware());

