<?php

namespace App\Console\Commands;

use App\Jobs\CheckUrl;
use App\Models\Url;
use Illuminate\Console\Command;

class EnqueueUrlChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all the URLs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Url::all() as $uri) {
            CheckUrl::dispatch($uri);
        };
    }
}
