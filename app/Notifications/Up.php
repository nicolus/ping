<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class Up extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param Check $check The Check that triggered this notification
     */
    public function __construct(public Check $check, public Check $previousGoodCheck)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable)
    {
        if ($notifiable->routeNotificationForVonage($this)) {
            return ['mail', 'Vonage'];
        }

        return ['mail'];
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
            ->line("It was offline since {$this->previousGoodCheck->created_at}");
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

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
