<?php

namespace Tests\Unit;

use App\Jobs\CheckProbe;
use App\Models\Probe;
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


        $probe = Probe::where('url', 'https://gooddomain.com')->first();

        CheckProbe::dispatch($probe); // 200
        CheckProbe::dispatch($probe); // 200 still online => nothing happens
        Notification::assertSentTo($probe->user, CheckNotification::class);
        CheckProbe::dispatch($probe); // 500 => notify that site is down
        Notification::assertSentTo($probe->user, DownNotification::class);
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


        $probe = Probe::where('url', 'https://gooddomain.com')->first();

        CheckProbe::dispatch($probe); // 200 => nothing happens
        Notification::assertSentTo($probe->user, CheckNotification::class);
        CheckProbe::dispatch($probe); // 400 => site is now offline
        CheckProbe::dispatch($probe); // 500
        CheckProbe::dispatch($probe); // 200 again => notify that site is up again
        Notification::assertSentTo($probe->user, UpNotification::class);
    }
}
