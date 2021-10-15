<?php


namespace App\Parser\Avito;


use App\Parser\ParserProvider;

class AvitoSingle implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "document.querySelector('.title-info-title-text')";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "avito.ru";
    }

    public function parserOption(): string
    {
        return "[{
                  price: document.querySelector('span[class^=price-value-string]').innerText.replace(/[^0-9]/g,''),
                  title: document.querySelector('span[class=title-info-title-text]').innerText,
                  image: document.querySelector('div[class^=gallery-img-frame] > img').getAttribute('src'),
                  url: document.URL,
                }]";
    }
}
