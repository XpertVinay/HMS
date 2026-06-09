<?php

namespace App\Services;

use App\Models\UserDevice;
use App\Notifications\GenericFcmNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use NotificationChannels\Fcm\FcmTopicChannel;

class PushNotificationService
{
    public function isEnabled(): bool
    {
        return (bool) config('push.enabled', true);
    }

    /**
     * Send a push notification to a single notifiable user.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $custom
     */
    public function send(
        object $notifiable,
        string $title,
        string $body,
        array $data = [],
        ?string $image = null,
        array $custom = [],
    ): void {
        if (!$this->isEnabled()) {
            return;
        }

        $notifiable->notify(new GenericFcmNotification($title, $body, $data, $image, $custom));
    }

    /**
     * Send a push notification to multiple users.
     *
     * @param  iterable<object>  $notifiables
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $custom
     */
    public function sendToMany(
        iterable $notifiables,
        string $title,
        string $body,
        array $data = [],
        ?string $image = null,
        array $custom = [],
    ): void {
        if (!$this->isEnabled()) {
            return;
        }

        $notification = new GenericFcmNotification($title, $body, $data, $image, $custom);

        foreach (Collection::make($notifiables) as $notifiable) {
            $notifiable->notify(clone $notification);
        }
    }

    /**
     * Send a push notification to an FCM topic.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $custom
     */
    public function sendToTopic(
        string $topic,
        string $title,
        string $body,
        array $data = [],
        ?string $image = null,
        array $custom = [],
    ): void {
        if (!$this->isEnabled()) {
            return;
        }

        $notification = new GenericFcmNotification($title, $body, $data, $image, $custom);

        NotificationFacade::route(FcmTopicChannel::class, $topic)->notify($notification);
    }

    /**
     * Send using a custom notification class.
     */
    public function notify(object $notifiable, Notification $notification): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $notifiable->notify($notification);
    }

    /**
     * Register or update an FCM token for a user's device.
     */
    public function registerDevice(
        Model $user,
        string $deviceUuid,
        string $fcmToken,
        string $osType = 'android',
        ?string $deviceModel = null,
        ?int $organizationId = null,
    ): UserDevice {
        $userType = method_exists($user, 'pushUserType')
            ? $user->pushUserType()
            : ($user->account_type ?? class_basename($user));

        return UserDevice::query()->updateOrCreate(
            ['device_uuid' => $deviceUuid],
            [
                'user_type' => $userType,
                'user_id' => $user->getKey(),
                'organization_id' => $organizationId ?? $user->organization_id ?? 0,
                'os_type' => $osType,
                'device_model' => $deviceModel,
                'fcm_token' => $fcmToken,
                'status' => 'active',
                'last_login_at' => now(),
            ],
        );
    }

    /**
     * Revoke a device and clear its FCM token.
     */
    public function revokeDevice(Model $user, string $deviceUuid): bool
    {
        $userType = method_exists($user, 'pushUserType')
            ? $user->pushUserType()
            : ($user->account_type ?? class_basename($user));

        return (bool) UserDevice::query()
            ->where('device_uuid', $deviceUuid)
            ->where('user_type', $userType)
            ->where('user_id', $user->getKey())
            ->update([
                'status' => 'revoked',
                'fcm_token' => null,
            ]);
    }

    /**
     * Build an organization-scoped topic name.
     */
    public function orgTopic(int $organizationId, string $segment): string
    {
        $prefix = (string) config('push.topic_prefix', 'org');

        return sprintf('%s_%d_%s', $prefix, $organizationId, $segment);
    }
}
