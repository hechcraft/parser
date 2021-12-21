<?php


namespace App\Parser\Avito;


use App\Parser\ParserProvider;

class AvitoGroup implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "return Array.from(document.querySelectorAll('div[class^=iva-item-content]')).length";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "avito.ru";
    }

    public function parserOption(): string
    {
        return "Array.from(document.querySelectorAll('div[class^=iva-item-content]'))
                        .map(node => ({title: node.querySelector('h3[itemprop=name]').innerText,
                        url: 'https://www.avito.ru' + node.querySelector('div[class^=iva-item] a').getAttribute('href'),
                        price: node.querySelector('span[class^=price-text]').innerText.replace(/[^0-9]/g,''),
                        priceStr: node.querySelector('span[class^=price-text]').innerText,
                        image: (node.querySelector('img[class^=photo-slider-image]') === null) ? '/assets/a4dd64d3/images/theme/nophoto-120x120.png'
                         : node.querySelector('img[class^=photo-slider-image]').getAttribute('src')}))";
    }
}
