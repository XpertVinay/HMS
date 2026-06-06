<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Middleware\CorsMiddleware;
use App\Middleware\SecurityMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\ResponseFormatter;

// Load DB Environment variables if necessary (Database singleton handles it internally via `.env` but we can ensure it's loaded)
require_once __DIR__ . '/../../Includes/Database.php';

$app = AppFactory::create();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$app->addErrorMiddleware(true, true, true);

// Add Global Security & CORS Middlewares
$app->add(new SecurityMiddleware());
$app->add(new CorsMiddleware());

// Health Check
$app->get('/api/v1/health', function (Request $request, Response $response) {
    return ResponseFormatter::success($response, null, "API is running securely!");
});

// Auth Routes
require __DIR__ . '/../src/Routes/auth.php';

// Member Routes
require __DIR__ . '/../src/Routes/member.php';

// Staff Routes
require __DIR__ . '/../src/Routes/staff.php';

$app->run();
