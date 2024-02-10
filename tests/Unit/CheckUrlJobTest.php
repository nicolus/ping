<?php

use App\Jobs\CheckProbe;
use App\Models\Probe;
use App\Notifications\CheckNotification;
use App\Notifications\DownNotification;
use App\Notifications\UpNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
});

test('site goes offline', function () {
    Notification::fake();
    Http::fake([
        'gooddomain.com' => Http::sequence()
            ->pushStatus(200)
            ->pushStatus(200)
            ->pushStatus(500)
    ]);

    $probe = Probe::where('url', 'https://gooddomain.com')->first();

    CheckProbe::dispatch($probe);
    // 200
    CheckProbe::dispatch($probe);
    // 200 still online => nothing happens
    Notification::assertSentTo($probe->user, CheckNotification::class);
    CheckProbe::dispatch($probe);
    // 500 => notify that site is down
    Notification::assertSentTo($probe->user, DownNotification::class);
});

test('site goes online', function () {
    Notification::fake();
    Http::fakeSequence()
        ->pushStatus(200)
        ->pushStatus(400)
        ->pushStatus(500)
        ->pushStatus(200);

    $probe = Probe::where('url', 'https://gooddomain.com')->first();

    CheckProbe::dispatch($probe); // 200 => nothing happens
    Notification::assertSentTo($probe->user, CheckNotification::class);

    CheckProbe::dispatch($probe); // 400 => site is now offline
    CheckProbe::dispatch($probe); // 500
    CheckProbe::dispatch($probe); // 200 again => notify that site is up again
    Notification::assertSentTo($probe->user, UpNotification::class);
});
