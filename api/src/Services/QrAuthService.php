<?php
namespace App\Services;

use Database;

class QrAuthService
{
    public function validateAndConsumeToken($qrToken)
    {
        $pdo = Database::getInstance()->getPDO();
        
        // Find valid token
        $stmt = $pdo->prepare("SELECT * FROM qr_auth_tokens WHERE token = ? AND expires_at > NOW() AND used_at IS NULL");
        $stmt->execute([$qrToken]);
        $tokenData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$tokenData) {
            return false;
        }

        // Consume token
        $updateStmt = $pdo->prepare("UPDATE qr_auth_tokens SET used_at = NOW() WHERE token = ?");
        $updateStmt->execute([$qrToken]);

        return $tokenData;
    }

    public function registerDevice($userType, $userId, $orgId, $deviceUuid, $osType, $deviceModel)
    {
        $pdo = Database::getInstance()->getPDO();

        // Check if device already exists for this user
        $stmt = $pdo->prepare("SELECT id FROM user_devices WHERE device_uuid = ? AND user_id = ? AND user_type = ?");
        $stmt->execute([$deviceUuid, $userId, $userType]);
        $device = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($device) {
            $update = $pdo->prepare("UPDATE user_devices SET status = 'active', last_login_at = NOW() WHERE id = ?");
            $update->execute([$device['id']]);
            return $device['id'];
        }

        $insert = $pdo->prepare("INSERT INTO user_devices (user_type, user_id, organization_id, device_uuid, os_type, device_model, status, last_login_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 'active', NOW(), NOW(), NOW())");
        $insert->execute([$userType, $userId, $orgId, $deviceUuid, $osType, $deviceModel]);
        
        return $pdo->lastInsertId();
    }
}
