<?php

namespace App\Console\Commands;

use App\Models\Pages;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ParserGetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $pages = Pages::all();

        $currenTime = Carbon::now();

        foreach ($pages as $page) {
            $pageHost = parse_url($page->url, PHP_URL_HOST);
            $lastCheckedAt = Carbon::parse($page->offer->max('last_checked_at'));

            if ($pageHost === 'www.dns-shop.ru' &&
                $currenTime->diffInHours($lastCheckedAt) >= 6) {
                \App\Jobs\Parser::dispatch($page->url, $page->id);
            }

            if ($pageHost !== 'www.dns-shop.ru' &&
                $currenTime->diffInMinutes($lastCheckedAt) >= 10){
                \App\Jobs\Parser::dispatch($page->url, $page->id);
            }
        }
    }
}
