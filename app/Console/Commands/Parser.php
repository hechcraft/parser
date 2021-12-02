<?php

namespace App\Console\Commands;

use App\Jobs\SendNewPosition;
use App\Jobs\SendCurrentOffer;
use App\Models\Offers;
use App\Models\Pages;
use App\Models\PriceHistory;
use App\Models\User;
use App\Parser\DiscoverPageType;
use App\Parser\Dns\DnsSingle;
use App\Parser\MarketPlaceParser;
use App\Parser\PageOffer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Parser\ParserFactory;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use phpDocumentor\Reflection\Types\Collection;
use Ramsey\Uuid\Type\Time;

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
        $currentTime = Carbon::now()->toDateTimeString();
        $getParser = new MarketPlaceParser($this->argument('url'));

        $helpers = new \App\Helpers\Parser();

        foreach ($getParser->parser() as $item) {
            $currentOffer = Offers::where('offer_url', $item->url)->first();

            if (!isset($currentOffer)) {
                $offer = Offers::firstOrCreate([
                    'page_id' => 10,
                    'name' => $item->name,
                    'image_url' => $item->image,
                    'last_checked_at' => $currentTime,
                    'offer_url' => $item->url,
                ]);
                $price = PriceHistory::create([
                    'offer_id' => $offer->id,
                    'price' => $item->price,
                    'price_str' => $item->priceStr,
                    'checked_at' => $currentTime,
                ]);

                SendCurrentOffer::dispatch($offer, $item->priceStr);
            }

            if (isset($currentOffer)) {
                $currentOffer->update([
                    'last_checked_at' => $currentTime,
                ]);

                if ($currentOffer->lastPrice->price != $item->price) {
                    PriceHistory::create([
                        'offer_id' => $currentOffer->id,
                        'price' => $item->price,
                        'price_str' => $item->priceStr,
                        'checked_at' => $currentTime,
                    ]);
                }

                if ($currentOffer->page->type === 'groupMinPrice' &&
                    $helpers->getOfferMinPrice($currentOffer->page->id->price > $currentOffer->lastPrice->price)) {
                    SendCurrentOffer::dispatch($currentOffer, $item->priceStr);
                    break;
                }
            }
        }
    }
}
