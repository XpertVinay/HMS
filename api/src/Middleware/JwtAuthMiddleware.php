<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Helpers\ResponseFormatter;
use Database;

class JwtAuthMiddleware
{
    private $secretKey = 'YOUR_SUPER_SECRET_KEY'; // In production, move to .env

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $header = $request->getHeaderLine('Authorization');
        if (empty($header) || !preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Missing or invalid Authorization header', null, 401);
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            
            // Optional: Check if JTI is in denylist (for strict logout enforcement even on access tokens)
            $pdo = Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("SELECT jti FROM jwt_denylist WHERE jti = ?");
            $stmt->execute([$decoded->jti]);
            if ($stmt->fetch()) {
                throw new \Exception('Token has been revoked.');
            }

            // Append decoded token to request attributes for downstream controllers
            $request = $request->withAttribute('user', $decoded);

        } catch (\Exception $e) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Unauthorized: ' . $e->getMessage(), null, 401);
        }

        return $handler->handle($request);
    }
}
