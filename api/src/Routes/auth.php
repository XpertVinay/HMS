<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AuthController;
use App\Middleware\JwtAuthMiddleware;

$app->group('/api/v1/auth', function (RouteCollectorProxy $group) {
    $group->post('/login', [AuthController::class, 'login']);
    $group->post('/refresh', [AuthController::class, 'refresh']);
    $group->post('/logout', [AuthController::class, 'logout'])->add(new JwtAuthMiddleware());
});
