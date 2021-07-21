<?php


namespace App\Parser\Olx;


use App\Parser\ParserProviders;

class OlxSingle implements ParserProviders
{
    public function getPageDiscroveryScript(): string
    {
        return "return document.querySelector('[name=user_ads]')";
    }

    public function matchesUrl(string $host): string
    {
        return $host === "olx.ua";
    }

    public function parserOption(): string
    {
        return "{
                  price: document.querySelector('[data-testid=ad-price-container] h3').innerText,
                  url: document.URL,
                  image: document.querySelector('.swiper-zoom-container > img').getAttribute('src'),
                  title: document.querySelector('[data-cy=ad_title]').innerText
                }";
    }
}
