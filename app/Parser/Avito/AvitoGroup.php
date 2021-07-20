<?php


namespace App\Parser\Avito;


class AvitoGroup
{
    public function getPageDiscroveryScript(): string
    {
        return "return document.querySelector('div[class^=iva-item-content]') ? document.querySelector('div[class^=iva-item-content]').innerText : null";
    }

    public function matchesUrl($host): string
    {
        return $host === "avito.ru";
    }


}
