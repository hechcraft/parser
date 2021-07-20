<?php


namespace App\Parser\Olx;


class OlxSingle
{
    public function getPageDiscroveryScript(): string
    {
        return "return document.querySelector('[name=user_ads]')";
    }

    public function matchesUrl($host): string
    {
        return $host === "olx.ua";
    }
}
