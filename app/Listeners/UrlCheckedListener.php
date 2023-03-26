<?php

namespace App\Listeners;

use App\Events\UrlChecked;
use App\Notifications\CheckNotification;
use App\Notifications\DownNotification;
use App\Notifications\UpNotification;

class UrlCheckedListener
{
    public function __construct()
    {
    }

    public function handle(UrlChecked $event): void
    {
        $check = $event->check;
        $previous = $check->previousCheck();

        if ($previous?->wasOnline() && $check->wasOffline()){
            $notification = new DownNotification($event->check);
        } elseif ($previous?->wasOffline() && $check->wasOnline()){
            $notification = new UpNotification($event->check);
        } else {
            $notification = new CheckNotification($event->check);
        }

        $event->check->url->user->notify($notification);
    }
}
