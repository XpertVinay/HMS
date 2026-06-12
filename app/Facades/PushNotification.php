<?php

namespace App\Facades;

use App\Services\PushNotificationService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled()
 * @method static void send(object $notifiable, string $title, string $body, array $data = [], ?string $image = null, array $custom = [])
 * @method static void sendToMany(iterable $notifiables, string $title, string $body, array $data = [], ?string $image = null, array $custom = [])
 * @method static void sendToTopic(string $topic, string $title, string $body, array $data = [], ?string $image = null, array $custom = [])
 * @method static void notify(object $notifiable, \Illuminate\Notifications\Notification $notification)
 * @method static \App\Models\UserDevice registerDevice(\Illuminate\Database\Eloquent\Model $user, string $deviceUuid, string $fcmToken, string $osType = 'android', ?string $deviceModel = null, ?int $organizationId = null)
 * @method static bool revokeDevice(\Illuminate\Database\Eloquent\Model $user, string $deviceUuid)
 * @method static string orgTopic(int $organizationId, string $segment)
 *
 * @see PushNotificationService
 */
class PushNotification extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PushNotificationService::class;
    }
}
