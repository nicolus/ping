<?php

namespace App\Jobs;

use App\Models\Url;
use App\Notifications\Down;
use App\Notifications\Up;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckUrl implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Url $url
     */
    public function __construct(protected Url $url)
    {
    }

    public function uniqueId()
    {
        return $this->url->id;
    }

    /**
     * Execute the job.
     *
     * @param Url $url
     * @return void
     */
    public function handle()
    {
        $previousCheck = $this->url->latestCheck()->first();
        $previousGoodCheck = $this->url->latestGoodCheck()->first();

        $check = $this->url->makeCheck();

        if (!$previousCheck) {
            return;
        }

        if ($previousCheck->wasOnline() && $check->wasOffline()){
            $this->url->user->notify(new Down($check));
        }

        if ($previousCheck->wasOffline() && $check->wasOnline()){
            $this->url->user->notify(new Up($check, $previousGoodCheck));
        }
    }
}
