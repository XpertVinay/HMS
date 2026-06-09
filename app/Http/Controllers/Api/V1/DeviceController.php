<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\PushNotification;
use App\Http\Requests\Api\V1\RegisterDeviceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends BaseApiController
{
    public function register(RegisterDeviceRequest $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Unauthenticated.', [], 401);
        }

        $device = PushNotification::registerDevice(
            user: $user,
            deviceUuid: $request->input('device_uuid'),
            fcmToken: $request->input('fcm_token'),
            osType: $request->input('os_type'),
            deviceModel: $request->input('device_model'),
            organizationId: $user->organization_id ?? null,
        );

        return $this->sendResponse([
            'device' => [
                'id' => $device->id,
                'device_uuid' => $device->device_uuid,
                'os_type' => $device->os_type,
                'status' => $device->status,
            ],
        ], 'Device registered for push notifications');
    }

    public function revoke(Request $request, string $deviceUuid): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Unauthenticated.', [], 401);
        }

        $revoked = PushNotification::revokeDevice($user, $deviceUuid);

        if (!$revoked) {
            return $this->sendError('Device not found.', [], 404);
        }

        return $this->sendResponse([], 'Device revoked successfully');
    }
}
