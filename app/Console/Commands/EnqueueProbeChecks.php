<?php

namespace App\Console\Commands;

use App\Jobs\CheckProbe;
use App\Models\Check;
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
            CheckProbe::dispatch($uri);
        }
    }
}
