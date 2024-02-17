<?php

namespace App\Console\Commands;

use App\Jobs\CheckProbe;
use App\Models\Probe;
use Illuminate\Console\Command;

class EnqueueProbeChecks extends Command
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
     * Execute the console command.
     *
     */
    public function handle(): void
    {
        foreach (Probe::all() as $uri) {
            // Delay the job randomly to avoid pinging the server each minute on the clock
            CheckProbe::dispatch($uri)->delay(now()->addSeconds(rand(1, 30)));
        }
    }
}
