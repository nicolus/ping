<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidNotification;

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
    public function via(mixed $notifiable): array
    {
        $channels = [MailChannel::class];

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
            ->subject($this->check->url->name . ' is down')
            ->greeting('Ooops')
            ->line("It looks like {$this->check->url->name} is down.")
            ->action('See for yourself', $this->check->url->url)
            ->line('We\'ll let you know as soon as it goes back online.');
    }


    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Site is down')
                ->setBody($this->check->url->name . ' is down')
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setNotification(AndroidNotification::create()->setClickAction('FCM_PLUGIN_ACTIVITY'))
            );
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
            ->content($this->check->url->name . ' is down.');
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
