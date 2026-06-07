<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\CommunityPost;

class PostRequiresStage1Approval extends Notification
{
    use Queueable;

    protected $post;

    /**
     * Create a new notification instance.
     */
    public function __construct(CommunityPost $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Currently using only database notifications (in-app) as requested
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => 'New Community Post requires Stage 1 Verification',
            'message' => 'A new post titled "' . $this->post->title . '" by ' . ($this->post->member->username ?? 'a member') . ' requires your review.',
            'url' => route('staff.community.moderation')
        ];
    }
}
