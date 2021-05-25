<?php

namespace Tests\Feature;

use App\Jobs\CheckUrl;
use App\Models\Check;
use App\Models\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_up_notification_email()
    {
        Event::fake([MessageSending::class]);

        Http::fake();

        /** @var Url $url */
        $url = Url::find(1);

        $goodCheck = new Check();
        $goodCheck->status = 200;
        $goodCheck->created_at = '2021-05-05 13:37';

        $badCheck = new Check();
        $badCheck->status = 500;
        $badCheck->created_at = Carbon::now()->subMinute();


        $url->checks()->saveMany([$goodCheck, $badCheck]);

        CheckUrl::dispatch($url);

        Event::assertDispatched(MessageSending::class, function (MessageSending $event) {
            echo $event->message->getBody();
            return Str::contains($event->message->getBody(), 'is now up')
                && Str::contains($event->message->getBody(), 'It was offline since 2021-05-05 13:37');
        });
    }
}
