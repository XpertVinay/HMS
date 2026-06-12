<?php

namespace App\Traits;

use App\Models\UserDevice;
use Illuminate\Notifications\Notifiable;

trait HasPushNotifications
{
    use Notifiable;

    /**
     * Active device registrations for this user.
     */
    public function devices()
    {
        return $this->hasMany(UserDevice::class, 'user_id')
            ->where('user_type', $this->pushUserType());
    }

    /**
     * FCM routing tokens for all active devices.
     *
     * @return array<int, string>
     */
    public function routeNotificationForFcm(): array
    {
        return UserDevice::query()
            ->active()
            ->withFcmToken()
            ->where('user_type', $this->pushUserType())
            ->where('user_id', $this->getKey())
            ->pluck('fcm_token')
            ->unique()
            ->values()
            ->all();
    }

    /**
     * User type key stored in user_devices.user_type.
     */
    public function pushUserType(): string
    {
        return $this->account_type ?? class_basename($this);
    }
}
