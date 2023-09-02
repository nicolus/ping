<?php

use App\Jobs\CheckProbe;
use App\Models\Check;
use App\Models\Probe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('up notification email', function () {
    Event::fake([MessageSending::class]);

    Http::fake();

    /** @var Probe $url */
    $url = Probe::find(1);

    $goodCheck = new Check();
    $goodCheck->status = 200;
    $goodCheck->online = 1;
    $goodCheck->created_at = '2021-05-05 13:37';

    $badCheck = new Check();
    $badCheck->status = 500;
    $badCheck->online = 0;
    $badCheck->created_at = Carbon::now()->subMinute();

    $url->checks()->saveMany([$goodCheck, $badCheck]);

    CheckProbe::dispatch($url);

    Event::assertDispatched(MessageSending::class, function (MessageSending $event) {
        return Str::contains($event->message->getHtmlBody(), 'is now up')
            && Str::contains($event->message->getHtmlBody(), 'It was offline since 2021-05-05 13:37');
    });
});

test('down notification email', function () {
    Event::fake([MessageSending::class]);

    Http::fake([
        Http::response('failure', 500)
    ]);

    /** @var Probe $url */
    $url = Probe::find(1);

    $goodCheck = new Check();
    $goodCheck->status = 200;
    $goodCheck->online = 1;
    $goodCheck->created_at = Carbon::now()->subMinute();

    $url->checks()->save($goodCheck);

    CheckProbe::dispatch($url);

    Event::assertDispatched(MessageSending::class, function (MessageSending $event) {
        return Str::contains($event->message->getHtmlBody(), 'is down');
    });
});
