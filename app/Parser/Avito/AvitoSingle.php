<?php


namespace App\Parser\Avito;


class AvitoSingle
{
    public function getPageDiscroveryScript(): string
    {
        return "document.querySelector('.title-info-title-text')";
    }

    public function matchesUrl($host): string
    {
        return $host === "avito.ru";
    }
}
