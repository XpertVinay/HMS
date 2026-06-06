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

        if (!$user || (!isset($user->roles) && !isset($user->user_type))) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Forbidden: Missing role information', null, 403);
        }

        $userRoles = isset($user->roles) ? (array)$user->roles : [$user->user_type];
        
        $hasRole = false;
        foreach ($userRoles as $role) {
            if (in_array($role, $this->requiredRoles)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Forbidden: Insufficient permissions', null, 403);
        }

        return $handler->handle($request);
    }
}
