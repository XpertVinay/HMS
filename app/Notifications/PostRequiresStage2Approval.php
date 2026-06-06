<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\CommunityPost;

class PostRequiresStage2Approval extends Notification
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
            'title' => 'Community Post requires Stage 2 Final Approval',
            'message' => 'A post titled "' . $this->post->title . '" has passed Stage 1 verification and requires your final approval.',
            'url' => route('admin.community.approvals') // Assuming we will create this route
        ];
    }
}
