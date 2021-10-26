<?php


namespace App\Parser\Olx;


use App\Parser\ParserProvider;

class OlxGroup implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "return Array.from(document.querySelectorAll('#offers_table .offer-wrapper')).length";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "olx.ua";
    }

    public function parserOption(): string
    {
        return "Array.from(document.querySelectorAll('#offers_table .offer-wrapper')).
            map(node => ({ title: node.querySelector('h3 >a[class$=detailsLink]').innerText,
                            url: node.querySelector('h3>a[class$=detailsLink]').getAttribute('href'),
                            price: node.querySelector('p.price > strong').innerText.replace(/[^0-9]/g,''),
                            priceStr: node.querySelector('p.price > strong').innerText,
                            image: node.querySelector('a[class^=thumb] > img').getAttribute('src')}))";
    }
}
