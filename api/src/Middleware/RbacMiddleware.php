<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Helpers\ResponseFormatter;

class RbacMiddleware
{
    private $requiredRoles;

    public function __construct(array $requiredRoles)
    {
        $this->requiredRoles = $requiredRoles;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $user = $request->getAttribute('user');

        if (!$user || !isset($user->role)) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Forbidden: Missing role information', null, 403);
        }

        if (!in_array($user->role, $this->requiredRoles)) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Forbidden: Insufficient permissions', null, 403);
        }

        return $handler->handle($request);
    }
}
