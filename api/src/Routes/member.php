<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\MemberController;
use App\Middleware\JwtAuthMiddleware;
use App\Middleware\RbacMiddleware;

$app->group('/api/v1/member', function (RouteCollectorProxy $group) {
    $group->get('/notices', [MemberController::class, 'getNotices']);
    $group->get('/bills', [MemberController::class, 'getBills']);
})->add(new RbacMiddleware(['member', 'admin', 'super_admin']))
  ->add(new JwtAuthMiddleware());
