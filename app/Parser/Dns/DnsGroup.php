<?php


namespace App\Parser\Dns;


class DnsGroup
{
    public function getPageDiscroveryScript(): string
    {
        return "return document.querySelector('div[class=products-list__content]')";
    }

    public function matchesUrl(string $host): bool
    {
        return $host === "dns-shop.ru";
    }
}
