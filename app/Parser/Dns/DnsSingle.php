<?php


namespace App\Parser\Dns;


class DnsSingle
{
    public function getPageDiscroveryScript(): string
    {
        return "return document.querySelector('h1[class=product-card-top__title]')";
    }

    public function matchesUrl($host): string
    {
        return $host === "dns-shop.ru";
    }

    public function parserOption()
    {
        return "{
                        name: document.querySelector('.product-card-top__title').innerText,
                        price: document.querySelector('.product-buy__price').innerText,
                        image: document.querySelector('img[class^=product-images-slider__img]').getAttribute('src'),
                        url: document.URL,
                        }";
    }
}
