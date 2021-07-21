<?php


namespace App\Parser;


interface ParserProviders
{
    public function getPageDiscroveryScript(): string;

    public function matchesUrl(string $host): string;

    public function parserOption(): string;
}
