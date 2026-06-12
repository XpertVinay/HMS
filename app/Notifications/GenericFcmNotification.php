<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\FcmTopicChannel;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class GenericFcmNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $body,
        public array $data = [],
        public ?string $image = null,
        public array $custom = [],
    ) {
    }

    /**
     * @return array<int, class-string>
     */
    public function via(object $notifiable): array
    {
        return $notifiable instanceof AnonymousNotifiable
            ? [FcmTopicChannel::class]
            : [FcmChannel::class];
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $message = (new FcmMessage(
            notification: new FcmNotification(
                title: $this->title,
                body: $this->body,
                image: $this->image,
            )
        ))->data($this->stringifyData($this->data));

        if ($this->custom !== []) {
            $message->custom($this->custom);
        }

        return $message;
    }

    /**
     * FCM data payloads must be string key-value pairs.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, string>
     */
    private function stringifyData(array $data): array
    {
        $payload = [];

        foreach ($data as $key => $value) {
            if (is_scalar($value) || $value === null) {
                $payload[(string) $key] = (string) $value;
                continue;
            }

            $payload[(string) $key] = json_encode($value);
        }

        return $payload;
    }
}
