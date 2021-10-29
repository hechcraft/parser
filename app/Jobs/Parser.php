<?php

namespace App\Jobs;

use App\Models\Offers;
use App\Models\PriceHistory;
use App\Parser\MarketPlaceParser;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Parser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $url;
    public $pageId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url, int $pageId)
    {
        $this->url = $url;
        $this->pageId = $pageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currentTime = Carbon::now()->toDateTimeString();
        $getParser = new MarketPlaceParser($this->url);

        $helpers = new \App\Helpers\Parser();

        foreach ($getParser->parser() as $item) {
            $currentOffer = Offers::where('offer_url', $item->url)->first();

            if (!isset($currentOffer)) {
                $offer = Offers::firstOrCreate([
                    'page_id' => 1,
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
