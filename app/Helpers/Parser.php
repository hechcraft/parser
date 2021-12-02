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


    public function getOfferMinPrice(int $pageId)
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
            if ($minPriceOffer != null) {
                $priceHistoryCollect->push($minPriceOffer);
            }
        }

        return $priceHistoryCollect;
    }

    public function getDataForGraph(string $method, int $pageId): \Illuminate\Support\Collection
    {
        if ($method === 'single'){
            return $this->singletonDataGraph($pageId);
        }

        return $this->multiDataGraph($pageId);
    }

    private function singletonDataGraph(int $pageId): \Illuminate\Support\Collection
    {
        $offer = Offers::where('page_id', $pageId)->first();
        $graphData = collect();
        $prices = collect();
        $dates = collect();

        foreach ($offer->priceHistory as $price){
            $prices->push($price->price);
            $dates->push($price->checked_at);
        }

        $graphData->push($prices);
        $graphData->push($dates);

        return $graphData;
    }

    private function multiDataGraph(int $pageId): \Illuminate\Support\Collection
    {
        $offers = Offers::where('page_id', $pageId)->get();
        $graphData = collect();
        $prices = collect();
        $dates = collect();

        foreach ($offers as $offer) {
            if ($offer->lastPrice) {
                $prices->push($offer->lastPrice->price);
                $dates->push($offer->lastPrice->checked_at);
            }
        }

        $graphData->push($prices);
        $graphData->push($dates);

        return $graphData;
    }
}
