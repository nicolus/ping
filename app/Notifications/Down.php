<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class Down extends Notification
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
    public function via(mixed $notifiable)
    {
        return ['mail', 'nexmo'];
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
            ->subject($this->check->url->name . ' is down')
            ->greeting('Ooops')
            ->line("It looks like {$this->check->url->name} is down.")
            ->action('See for yourself', $this->check->url->url)
            ->line('We\'ll let you know as soon as it goes back online.');
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo(mixed $notifiable): NexmoMessage
    {
        return (new NexmoMessage())
            ->content($this->check->url->name . ' is down.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return arrayr
     */
    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
