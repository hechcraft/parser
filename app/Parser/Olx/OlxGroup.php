<?php


namespace App\Parser\Olx;


class OlxGroup
{
    public function getPageDiscroveryScript(): string
    {
        return "return document.querySelector('#offers_table .offer-wrapper')";
    }

    public function matchesUrl($host): string
    {
        return $host === "olx.ua";
    }
}
