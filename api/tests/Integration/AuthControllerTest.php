<?php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use App\Controllers\AuthController;
use Slim\Psr7\Factory\ResponseFactory;

class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // For a real integration test, we would seed the test database here.
    }

    public function testLoginFailsWithoutCredentials()
    {
        $controller = new AuthController();
        
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('POST', '/api/login');
        $request = $request->withParsedBody([]);

        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();

        $result = $controller->login($request, $response);
        $result->getBody()->rewind();
        $body = json_decode($result->getBody()->getContents(), true);

        $this->assertEquals(422, $result->getStatusCode());
        $this->assertEquals('Validation failed', $body['message']);
        $this->assertArrayHasKey('username', $body['errors']);
        $this->assertArrayHasKey('password', $body['errors']);
        $this->assertArrayHasKey('role', $body['errors']);
    }
}
