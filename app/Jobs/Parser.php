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
        $getParser = new MarketPlaceParser($this->url);
        $currentTime = Carbon::now()->toDateTimeString();

        foreach ($getParser->parser() as $item) {

            $currentOffer = Offers::where('offer_url', $item->url)->first();

            if (!isset($currentOffer)) {
                Offers::firstOrCreate([
                    'page_id' => $this->pageId,
                    'name' => $item->name,
                    'image_url' => $item->image,
                    'last_checked_at' => $currentTime,
                    'offer_url' => $item->url,
                ]);

                PriceHistory::create([
                    'offer_id' => Offers::latest()->first()->id,
                    'price' => $item->price,
                    'checked_at' => $currentTime,
                ]);
                return;
            }

            if ($currentOffer->lastPrice->price == $item->price) {
                return;
            }

            PriceHistory::create([
                'offer_id' => $currentOffer->id,
                'price' => $item->price,
                'checked_at' => $currentTime,
            ]);
        }
    }
}
