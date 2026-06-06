<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\ResponseFormatter;
use App\Services\QrAuthService;
use App\Services\TokenService;

class MobileAuthController
{
    private $qrAuthService;
    private $tokenService;

    public function __construct()
    {
        $this->qrAuthService = new QrAuthService();
        $this->tokenService = new TokenService();
    }

    public function qrLogin(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        
        $qrToken = $data['qrToken'] ?? null;
        $deviceUuid = $data['deviceUuid'] ?? null;
        $deviceModel = $data['deviceModel'] ?? 'Unknown';
        $osType = $data['os'] ?? 'android';

        if (!$qrToken || !$deviceUuid) {
            return ResponseFormatter::error($response, "qrToken and deviceUuid are required", 400);
        }

        $tokenData = $this->qrAuthService->validateAndConsumeToken($qrToken);

        if (!$tokenData) {
            return ResponseFormatter::error($response, "Invalid or expired QR Token", 401);
        }

        // Register device
        $deviceId = $this->qrAuthService->registerDevice(
            $tokenData['user_type'],
            $tokenData['user_id'],
            $tokenData['organization_id'],
            $deviceUuid,
            $osType,
            $deviceModel
        );

        // Generate JWT Tokens
        $payload = [
            'sub' => $tokenData['user_id'],
            'user_type' => $tokenData['user_type'],
            'tenant_id' => $tokenData['organization_id'], // Using tenant_id standard in JWT as requested
            'device_id' => $deviceId,
            'roles' => [$tokenData['user_type']]
        ];

        $tokens = $this->tokenService->generateTokens($payload);

        // Audit Log
        $this->logAction($tokenData, 'MOBILE_QR_LOGIN_SUCCESS', $deviceUuid);

        return ResponseFormatter::success($response, $tokens, "Login successful");
    }

    public function refresh(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $refreshToken = $data['refreshToken'] ?? null;

        if (!$refreshToken) {
            return ResponseFormatter::error($response, "Refresh token required", 400);
        }

        $decoded = $this->tokenService->validateToken($refreshToken);

        if (!$decoded || !isset($decoded->type) || $decoded->type !== 'refresh') {
            return ResponseFormatter::error($response, "Invalid refresh token", 401);
        }

        $payload = [
            'sub' => $decoded->sub,
            'user_type' => $decoded->user_type,
            'tenant_id' => $decoded->tenant_id,
            'device_id' => $decoded->device_id,
            'roles' => $decoded->roles
        ];

        // Denylist the old refresh token
        if (isset($decoded->jti) && isset($decoded->exp)) {
            $pdo = \Database::getInstance()->getPDO();
            $stmt = $pdo->prepare("INSERT INTO jwt_denylist (jti, expires_at, created_at, updated_at) VALUES (?, FROM_UNIXTIME(?), NOW(), NOW())");
            $stmt->execute([$decoded->jti, $decoded->exp]);
        }

        $tokens = $this->tokenService->generateTokens($payload);

        return ResponseFormatter::success($response, $tokens, "Token refreshed");
    }

    private function logAction($tokenData, $action, $ip = null)
    {
        $pdo = \Database::getInstance()->getPDO();
        $stmt = $pdo->prepare("INSERT INTO audit_logs (user_type, user_id, organization_id, action, ip_address, metadata) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $tokenData['user_type'],
            $tokenData['user_id'],
            $tokenData['organization_id'],
            $action,
            $ip, // Using deviceUuid here for simplicity
            json_encode(['method' => 'QR'])
        ]);
    }
}
