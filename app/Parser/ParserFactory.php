<?php

namespace App\Parser;

class ParserFactory
{
    public static function make(string $url)
    {
        $test = new DiscoverPageType($url, $host);
        dd($test->discover());

        $host = parse_url($url, PHP_URL_HOST);
        $host = ltrim($host, 'www.');

        switch ($host) {
            case "www.olx.ua":
                return new Olx($url);
            case "www.avito.ru":
                return  new Avito($url);
            case "www.dns-shop.ru":
                return new Dns($url);
        }
    }
}
