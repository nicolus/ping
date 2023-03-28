<?php

namespace App\Listeners;

use App\Events\ProbeChecked;
use App\Notifications\CheckNotification;
use App\Notifications\DownNotification;
use App\Notifications\UpNotification;

class ProbeCheckedListener
{
    public function __construct()
    {
    }

    public function handle(ProbeChecked $event): void
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

        $event->check->probe->user->notify($notification);
    }
}
