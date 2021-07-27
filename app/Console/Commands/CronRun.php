<?php

namespace App\Console\Commands;

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
        $url = "https://www.dns-shop.ru/product/96b1191c66923332/videokarta-kfa2-geforce-210-21ggf4hi00nk/";

        $loop = Loop::get();

        $loop->addPeriodicTimer(60, function () use ($url) {
            \App\Jobs\Parser::dispatch($url);
        });

        $loop->run();
    }
}
