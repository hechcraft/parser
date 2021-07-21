<?php


namespace App\Parser\Avito;


use App\Parser\ParserProviders;

class AvitoSingle implements ParserProviders
{
    public function getPageDiscroveryScript(): string
    {
        return "document.querySelector('.title-info-title-text')";
    }

    public function matchesUrl(string $host): string
    {
        return $host === "avito.ru";
    }

    public function parserOption(): string
    {
        return "{
                  price: document.querySelector('span[class^=price-value-string]').innerText,
                  title: document.querySelector('span[class=title-info-title-text]').innerText,
                  image: document.querySelector('div[class^=gallery-img-frame] > img').getAttribute('src'),
                  url: document.url
                }";
    }
}
