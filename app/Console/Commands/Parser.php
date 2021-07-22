<?php

namespace App\Console\Commands;

use App\Models\Offers;
use App\Models\PriceHistory;
use App\Parser\MarketPlaceParser;
use App\Parser\PageOffer;
use Carbon\Carbon;
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
     * @return void
     */
    public function handle()
    {
        $getParser = new MarketPlaceParser($this->argument('url'));
        $currentTime = Carbon::now()->toDateTimeString();

        foreach ($getParser->parser() as $item) {
            Offers::create([
                'page_id' => 1,
                'name' => $item->name,
                'image_url' => $item->url,
                'last_checked_at' => $currentTime,
                'offer_url' => $item->url,
            ]);

            PriceHistory::create([
                'offer_id' => Offers::latest()->first()->id,
                'price' => $item->price,
                'checked_at' => $currentTime,
            ]);
        }
    }
}
