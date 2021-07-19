<?php


namespace App\Parser;


use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class DiscoverPageType
{
    public function discover(string $url)
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([
            'headless' => true,
            'args' => [
                '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);

        $page = $browser->newPage();

        $page->goto($url, ['waitUntil' => 'networkidle2']);

        $pageType['dnsSingle'] = $page->evaluate(JsFunction::createWithBody("
            return document.querySelector('h1[class=product-card-top__title]');
        "));

        $pageType['dnsGroup'] = $page->evaluate(JsFunction::createWithBody("
            return document.querySelector('div[class=products-list__content]');
        "));

        $pageType['olxSingle'] = $page->evaluate(JsFunction::createWithBody("
            return document.querySelector('[name=user_ads]');
        "));

        $pageType['olxGroup'] = $page->evaluate(JsFunction::createWithBody("
            return document.querySelector('#offers_table .offer-wrapper');
        "));

        $pageType['avitoSingle'] = $page->evaluate(JsFunction::createWithBody("
            return document.querySelector('.title-info-title-text');
        "));

        $pageType['avitoGroup'] = $page->evaluate(JsFunction::createWithBody("
            return document.querySelector('div[class^=iva-item-content]') ? document.querySelector('div[class^=iva-item-content]').innerText : null;
        "));

        foreach ($pageType as $key => $type) {
            if ($type != null){
                return $key;
            }
        }
    }
}
