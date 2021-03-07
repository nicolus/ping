<?php

namespace Tests\Unit;

use App\Jobs\CheckUrl;
use App\Models\Url;
use App\Notifications\Down;
use App\Notifications\Up;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckUrlJobTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

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

        CheckUrl::dispatch($url);
        CheckUrl::dispatch($url);
        Notification::assertNothingSent();
        CheckUrl::dispatch($url);
        Notification::assertSentTo(
            [$url->user], Down::class
        );
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

        CheckUrl::dispatch($url);
        Notification::assertNothingSent();
        CheckUrl::dispatch($url);
        CheckUrl::dispatch($url);
        CheckUrl::dispatch($url);
        Notification::assertSentTo(
            [$url->user], Up::class
        );
    }
}
