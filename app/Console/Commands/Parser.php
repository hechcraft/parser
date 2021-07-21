<?php

namespace App\Console\Commands;

use App\Parser\MarketPlaceParser;
use Illuminate\Console\Command;
use App\Parser\ParserFactory;

class Parser extends Command
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
     * @return array
     */
    public function handle(): array
    {
        $getParser = new MarketPlaceParser($this->argument('url'));
        return $getParser->parser();
    }
}
