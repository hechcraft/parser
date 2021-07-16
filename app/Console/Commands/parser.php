<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Parser\ParserFactory;

class parser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parser {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from market place';

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
        $test = ParserFactory::make($this->argument('url'));
        dd($test->dataFromPage());
        return ParserFactory::make($this->argument('url'));
    }
}
