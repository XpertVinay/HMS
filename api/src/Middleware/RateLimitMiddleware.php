<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Helpers\ResponseFormatter;

class RateLimitMiddleware
{
    private $maxRequests;
    private $timeWindowSeconds;

    public function __construct($maxRequests = 5, $timeWindowSeconds = 60)
    {
        $this->maxRequests = $maxRequests;
        $this->timeWindowSeconds = $timeWindowSeconds;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $ip = $request->getServerParams()['REMOTE_ADDR'] ?? '127.0.0.1';
        $key = 'rate_limit_' . md5($ip . $request->getUri()->getPath());
        
        // This is a simple file-based or array-based rate limiter for demo purposes.
        // In production, you would use Redis or Memcached.
        $cacheDir = __DIR__ . '/../../cache';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0777, true);
        }
        
        $cacheFile = $cacheDir . '/' . $key;
        
        $data = [];
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile), true) ?: [];
        }
        
        // Filter out old requests
        $currentTime = time();
        $data = array_filter($data, function($timestamp) use ($currentTime) {
            return ($currentTime - $timestamp) < $this->timeWindowSeconds;
        });
        
        if (count($data) >= $this->maxRequests) {
            $response = new Response();
            return ResponseFormatter::error($response, 'Too Many Requests', null, 429);
        }
        
        $data[] = $currentTime;
        file_put_contents($cacheFile, json_encode(array_values($data)));

        return $handler->handle($request);
    }
}
