<?php

namespace App\Parser;

use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class marketPlaceParser
{
    public $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function parser(string $groupCommand, string $singleCommand): array
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([
            'headless' => false,
            'args' => [
                '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);

        $page = $browser->newPage();

        $page->goto($this->url, ['waitUntil' => 'networkidle2']);
        $parserData = $page->evaluate(JsFunction::createWithBody("
        window.scrollTo(0, document.body.scrollHeight);
            return {
                parserData: $groupCommand,
            };
        "));

        if (count(reset($parserData)) != 0) {
            $browser->close();
            return $parserData;
        }

        $parserData = $page->evaluate(JsFunction::createWithBody("
            return {
                parserData: $singleCommand,
            };
        "));

        $browser->close();
        return $parserData;
    }
}
