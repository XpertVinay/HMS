<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    private $secretKey;

    public function __construct()
    {
        // In production, this should come from environment variables.
        $this->secretKey = getenv('JWT_SECRET') ?: 'default_super_secret_key_change_in_prod';
    }

    public function generateTokens(array $payload)
    {
        $issuedAt = time();
        $accessExpires = $issuedAt + 900; // 15 minutes
        $refreshExpires = $issuedAt + 604800; // 7 days

        $accessPayload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $accessExpires,
            'type' => 'access',
            'jti' => bin2hex(random_bytes(16))
        ]);

        $refreshPayload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $refreshExpires,
            'type' => 'refresh',
            'jti' => bin2hex(random_bytes(16))
        ]);

        $accessToken = JWT::encode($accessPayload, $this->secretKey, 'HS256');
        $refreshToken = JWT::encode($refreshPayload, $this->secretKey, 'HS256');

        return [
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
            'expiresIn' => 900
        ];
    }

    public function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
