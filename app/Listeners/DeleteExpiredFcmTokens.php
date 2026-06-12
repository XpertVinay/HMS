<?php

namespace App\Listeners;

use App\Models\UserDevice;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Arr;
use NotificationChannels\Fcm\FcmChannel;

class DeleteExpiredFcmTokens
{
    public function handle(NotificationFailed $event): void
    {
        if ($event->channel !== FcmChannel::class) {
            return;
        }

        $report = Arr::get($event->data, 'report');

        if (!$report || !method_exists($report, 'target')) {
            return;
        }

        $target = $report->target();

        if (!$target || !method_exists($target, 'value')) {
            return;
        }

        $token = $target->value();

        if (!$token) {
            return;
        }

        UserDevice::query()
            ->where('fcm_token', $token)
            ->update([
                'fcm_token' => null,
                'status' => 'revoked',
            ]);
    }
}
