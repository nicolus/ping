<?php

namespace App\Jobs;

use App\Events\UrlChecked;
use App\Models\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckUrl implements ShouldQueue //, ShouldBeUnique
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

    public function uniqueId(): int
    {
        return $this->url->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $check = $this->url->makeCheck();

        UrlChecked::dispatch($check);
    }
}
