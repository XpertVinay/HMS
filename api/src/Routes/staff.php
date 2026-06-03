<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\StaffController;
use App\Middleware\JwtAuthMiddleware;
use App\Middleware\RbacMiddleware;

$app->group('/api/v1/staff', function (RouteCollectorProxy $group) {
    $group->get('/registry', [StaffController::class, 'getRegistry']);
    $group->post('/registry', [StaffController::class, 'addRegistry']);
})->add(new RbacMiddleware(['staff', 'admin', 'super_admin']))
  ->add(new JwtAuthMiddleware());
