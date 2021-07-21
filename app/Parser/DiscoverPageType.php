<?php


namespace App\Parser;

use App\Parser\Avito\AvitoGroup;
use App\Parser\Avito\AvitoSingle;
use App\Parser\Dns\DnsSingle;
use App\Parser\Dns\DnsGroup;
use App\Parser\Olx\OlxGroup;
use App\Parser\Olx\OlxSingle;
use Nesk\Rialto\Data\JsFunction;

class DiscoverPageType
{
    private $url;
    private $page;

    private $pageTypes = array(
        DnsSingle::class,
        DnsGroup::class,
        AvitoSingle::class,
        AvitoGroup::class,
        OlxSingle::class,
        OlxGroup::class,
    );

    public function __construct(string $url, $page)
    {
        $this->url = $url;
        $this->page = $page;
    }

    public function discover(): ParserProvider
    {
        $host = str_replace('www.', "", parse_url($this->url, PHP_URL_HOST));

        foreach ($this->pageTypes as $type) {
            $typeClass = new $type;
            if ($typeClass->matchesUrl($host) && $this->page->evaluate(JsFunction::createWithBody($typeClass->getPageDiscoveryScript()))) {
                return $typeClass;
            }
        }
    }
}


