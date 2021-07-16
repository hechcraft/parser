<?php

namespace App\Parser;

class ParserFactory
{
    public static function make(string $url)
    {
        $host = parse_url($url, PHP_URL_HOST);

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
