<?php

namespace App\Parser;

use App\Helpers\Parser;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use PDepend\Util\Log;

class MarketPlaceParser
{
    public $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function parser(): \Illuminate\Support\Collection
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([
            'headless' => true,
            'args' => [
                '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                '--window-size=1920,1080',
            ],
            'defaultViewport' => ['width' => 1920, 'height' => 1080],
        ]);

        $page = $browser->newPage();

        $page->goto($this->url, ['waitUntil' => 'networkidle2']);

        Parser::scrollPage($page);

        $pageType = new DiscoverPageType($this->url, $page);
        dd($pageType->discover());
        $parserOption = $pageType->discover()->parserOption();
        $parserData = $page->evaluate(JsFunction::createWithBody("
            return $parserOption "));
        $browser->close();
        dd($parserData);
        return collect($parserData)->map(function ($item) {
            return PageOffer::fromProvider($item);
        });
    }
}
