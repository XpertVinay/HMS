<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    private $secretKey;

    public function __construct()
    {
        $secret = getenv('JWT_SECRET');
        if (empty($secret)) {
            throw new \RuntimeException('FATAL: JWT_SECRET environment variable is not set.');
        }
        $this->secretKey = $secret;
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
            return ['valid' => true, 'payload' => JWT::decode($token, new Key($this->secretKey, 'HS256'))];
        } catch (\Firebase\JWT\ExpiredException $e) {
            return ['valid' => false, 'error' => 'expired'];
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return ['valid' => false, 'error' => 'invalid_signature'];
        } catch (\Exception $e) {
            return ['valid' => false, 'error' => 'malformed'];
        }
    }
}
