<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Helpers\ResponseFormatter;

class TenantResolutionMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $user = $request->getAttribute('user');

        if (!$user || !isset($user->tenant_id)) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Tenant context is missing from token', 403);
        }

        // Add tenant to request attributes
        $request = $request->withAttribute('tenant_id', $user->tenant_id);

        return $handler->handle($request);
    }
}
