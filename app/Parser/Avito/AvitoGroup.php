<?php


namespace App\Parser\Avito;


use App\Parser\ParserProviders;

class AvitoGroup implements ParserProviders
{
    public function getPageDiscroveryScript(): string
    {
        return "return document.querySelector('div[class^=iva-item-content]') ? document.querySelector('div[class^=iva-item-content]').innerText : null";
    }

    public function matchesUrl(string $host): string
    {
        return $host === "avito.ru";
    }

    public function parserOption(): string
    {
        return "Array.from(document.querySelectorAll('div[class^=iva-item-content]'))
                        .map(node => ({title: node.querySelector('h3[itemprop=name]').innerText,
                        url: 'https://www.avito.ru' + node.querySelector('div[class^=iva-item] a').getAttribute('href'),
                        price: node.querySelector('span[class^=price-text]').innerText,
                        image: node.querySelector('img[class^=photo-slider-image]') ? node.querySelector('img[class^=photo-slider-image]').getAttribute('src') : 'null'}))";
    }
}
