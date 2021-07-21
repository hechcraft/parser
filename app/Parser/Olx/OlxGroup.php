<?php


namespace App\Parser\Olx;


use App\Parser\ParserProvider;

class OlxGroup implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "return document.querySelector('#offers_table .offer-wrapper')";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "olx.ua";
    }

    public function parserOption(): string
    {
        return "Array.from(document.querySelectorAll('#offers_table .offer-wrapper')).
            map(node => ({ name: node.querySelector('h3 >a[class$=detailsLink]').innerText,
                            url: node.querySelector('h3>a[class$=detailsLink]').getAttribute('href'),
                            price: node.querySelector('p.price > strong').innerText,
                            img: node.querySelector('a[class^=thumb] > img') ? node.querySelector('a[class^=thumb] > img').getAttribute('src') : 'Без фото'}))";
    }
}
