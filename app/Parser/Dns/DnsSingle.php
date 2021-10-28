<?php


namespace App\Parser\Dns;


use App\Parser\ParserProvider;

class DnsSingle implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "return document.querySelector('h1[class=product-card-top__title]')";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "dns-shop.ru";
    }

    public function parserOption(): string
    {
        return "[{
                        title: document.querySelector('.product-card-top__title').innerText,
                        price: document.querySelector('.product-buy__price').innerText.replace(/[^0-9]/g,''),
                        priceStr: document.querySelector('.product-buy__price').innerText,
                        url: document.URL,
                        image: document.querySelector('img[class^=product-images-slider__main-img]').getAttribute('src')
                        ? document.querySelector('img[class^=product-images-slider__main-img]').getAttribute('src')
                        : '/assets/a4dd64d3/images/theme/nophoto-120x120.png',
                        }]";
    }
}
