<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\BroadcastChannel;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class UpNotification extends Notification implements ShouldQueue
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
        $channels = [BroadcastChannel::class, MailChannel::class];

        if ($notifiable->routeNotificationForVonage($this)) {
            $channels[] = VonageSmsChannel::class;
        }

        if ($notifiable->routeNotificationForFcm()) {
            $channels[] = FcmChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->check->url->name . ' is up !')
            ->greeting('Yay !')
            ->line("It looks like {$this->check->url->name} is now up.")
            ->action('See for yourself', $this->check->url->url)
            ->line("It was offline since {$this->check->previousOnlineCheck()->created_at}");
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return VonageMessage
     */
    public function toVonage(mixed $notifiable): VonageMessage
    {
        return (new VonageMessage())
            ->content($this->check->url->name . ' is up !');
    }


    public function toBroadCast(mixed $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'style' => 'success',
            'title' => $this->check->url->name . " is online !",
            'text' => "This website is responding again !",
        ]);
    }
}
