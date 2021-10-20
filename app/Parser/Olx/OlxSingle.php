<?php


namespace App\Parser\Olx;


use App\Parser\ParserProvider;

class OlxSingle implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "return Array.from(document.querySelectorAll('[name=user_ads]')).length";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "olx.ua";
    }

    public function parserOption(): string
    {
        return "[{
                  price: document.querySelector('[data-testid=ad-price-container] h3').innerText.replace(/[^0-9]/g,''),
                  priceStr: document.querySelector('[data-testid=ad-price-container] h3').innerText,
                  url: document.URL,
                  image: document.querySelector('.swiper-zoom-container > img').getAttribute('src'),
                  title: document.querySelector('[data-cy=ad_title]').innerText
                }]";
    }
}
