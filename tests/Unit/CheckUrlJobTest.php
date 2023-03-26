<?php

namespace Tests\Unit;

use App\Jobs\CheckUrl;
use App\Models\Url;
use App\Notifications\CheckNotification;
use App\Notifications\DownNotification;
use App\Notifications\UpNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckUrlJobTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSiteGoesOffline()
    {
        Notification::fake();
        Http::fake([
            'gooddomain.com' => Http::sequence()
                ->pushStatus(200)
                ->pushStatus(200)
                ->pushStatus(500)
        ]);


        $url = Url::where('url', 'https://gooddomain.com')->first();

        CheckUrl::dispatch($url); // 200
        CheckUrl::dispatch($url); // 200 still online => nothing happens
        Notification::assertSentTo($url->user, CheckNotification::class);
        CheckUrl::dispatch($url); // 500 => notify that site is down
        Notification::assertSentTo($url->user, DownNotification::class);
    }


    public function testSiteGoesOnline()
    {
        Notification::fake();
        Http::fake([
            'gooddomain.com' => Http::sequence()
                ->pushStatus(200)
                ->pushStatus(400)
                ->pushStatus(500)
                ->pushStatus(200)
        ]);


        $url = Url::where('url', 'https://gooddomain.com')->first();

        CheckUrl::dispatch($url); // 200 => nothing happens
        Notification::assertSentTo($url->user, CheckNotification::class);
        CheckUrl::dispatch($url); // 400 => site is now offline
        CheckUrl::dispatch($url); // 500
        CheckUrl::dispatch($url); // 200 again => notify that site is up again
        Notification::assertSentTo($url->user, UpNotification::class);
    }
}
