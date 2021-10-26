<?php


namespace App\Parser\Dns;


use App\Parser\ParserProvider;

class DnsGroup implements ParserProvider
{
    public function getPageDiscoveryScript(): string
    {
        return "return Array.from(document.querySelectorAll('div[data-id=product]')).length";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "dns-shop.ru";
    }

    public function parserOption(): string
    {
        return "Array.from(document.querySelectorAll('div[data-id=product]'))
                        .map(node => ({title: node.querySelector('a[class^=catalog-product__name]').innerText,
                        url: 'https://www.dns-shop.ru' + node.querySelector('a[class^=catalog-product__name]').getAttribute('href'),
                        image: node.querySelector('.catalog-product__image-link img').getAttribute('src'),
                        price: node.querySelector('.product-buy__price').innerText.replace(/[^0-9]/g,''),
                        priceStr: node.querySelector('.product-buy__price').innerText}))";
    }
}
