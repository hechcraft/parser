<?php


namespace App\Helpers;


use App\Models\Offers;
use App\Models\PriceHistory;
use Nesk\Puphpeteer\Resources\Page;
use Nesk\Rialto\Data\JsFunction;
use Ramsey\Collection\Collection;

class Parser
{
    static public function scrollPage(Page $page): void
    {
        $clientHeight = $page->evaluate(JsFunction::createWithBody('return document.body.clientHeight'));
        $currentCounter = 0;
        do {
            sleep(1);
            $currentHeight = $page->evaluate(JsFunction::createWithBody("return window.innerHeight"));
            $page->evaluate(JsFunction::createWithBody("window.scrollBy(0, $currentHeight)"));
            $currentCounter += $currentHeight;
        } while ($clientHeight >= $currentCounter);
    }

    /**
     * @param int $pageId
     * @param string $method min or max
     * @return int
     */

    public function getOfferMinPrice(int $pageId): PriceHistory
    {
        return $this->sortOfferPrices($pageId, 'min')->sortBy('price')->first();
    }

    public function getOfferMaxPrice(int $pageId): PriceHistory
    {
        return $this->sortOfferPrices($pageId, 'max')->sortByDesc('price')->first();
    }

    private function sortOfferPrices(int $pageId, string $method): \Illuminate\Support\Collection
    {
        $offers = Offers::where('page_id', $pageId)->get();

        $priceHistoryCollect = collect();
        foreach ($offers as $offer) {
            $offerPrices = $offer->priceHistory;
            $minPriceOffer = $offerPrices->where('price', $offerPrices->$method('price'))->first();
            $priceHistoryCollect->push($minPriceOffer);
        }

        return $priceHistoryCollect;
    }
}
