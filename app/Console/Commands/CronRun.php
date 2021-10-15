<?php

namespace App\Console\Commands;

use App\Models\Pages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use React\EventLoop\Loop;

class CronRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run ReactPHP';

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
        $loop = Loop::get();

        foreach (Pages::all() as $page) {
            $currentUrl = $page->url;
            $currentPageId = $page->id;
            $loop->addPeriodicTimer(60, function () use ($currentUrl, $currentPageId) {
                \App\Jobs\Parser::dispatch($currentUrl, $currentPageId);
            });
        }
        $loop->run();
    }
}
