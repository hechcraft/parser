<?php


namespace App\Parser;


interface ParserProvider
{
    public function getPageDiscoveryScript(): string;

    public function matchesUrl(string $host): bool;

    public function parserOption(): string;
}
