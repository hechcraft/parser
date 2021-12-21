<?php


namespace App\Parser\Olx;


use App\Parser\ParserProvider;

class OlxSingle implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "return Array.from(document.querySelectorAll('[data-cy=seller_card]')).length";
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
                  title: document.querySelector('[data-cy=ad_title]').innerText,
                  image: (document.querySelector('.swiper-zoom-container > img') === null) ? '/assets/a4dd64d3/images/theme/nophoto-120x120.png'
                  : document.querySelector('.swiper-zoom-container > img').getAttribute('src'),
                }]";
    }
}
