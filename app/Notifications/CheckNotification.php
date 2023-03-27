<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\BroadcastChannel;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CheckNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param Check $check The Check that triggered this notification
     */
    public function __construct(public Check $check)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [BroadcastChannel::class];
    }

    public function toBroadCast(mixed $notifiable): BroadcastMessage
    {
        $status = $this->check->online ? 'online' : 'offline';
        return new BroadcastMessage([
            'style' => 'info',
            'title' => $this->check->url->name . " checked",
            'text' => "it is still $status and responded in " . $this->check->time . "ms",
        ]);
    }
}
