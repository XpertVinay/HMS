<?php
namespace App\Helpers;

use Psr\Http\Message\ResponseInterface as Response;

class ResponseFormatter {
    public static function success(Response $response, $data = null, $message = "Operation completed successfully", $status = 200) {
        $payload = [
            "success" => true,
            "message" => $message,
            "data" => $data,
            "errors" => null
        ];
        
        $response->getBody()->write(json_encode($payload));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    public static function error(Response $response, $message = "An error occurred", $errors = null, $status = 400) {
        $payload = [
            "success" => false,
            "message" => $message,
            "data" => null,
            "errors" => $errors
        ];
        
        $response->getBody()->write(json_encode($payload));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
