<?php


namespace App\Helpers;


use Nesk\Puphpeteer\Resources\Page;
use Nesk\Rialto\Data\JsFunction;

class Parser
{
    static public function scrollPage(Page $page) :void
    {
        $clientHeight = $page->evaluate(JsFunction::createWithBody('return document.body.clientHeight'));
        $currentCounter = 0;
        do {
            sleep(1);
            $currentHeight = $page->evaluate(JsFunction::createWithBody("return window.innerHeight"));
            $page->evaluate(JsFunction::createWithBody("window.scrollBy(0, $currentHeight)"));
            $currentCounter += $currentHeight;
        } while ($clientHeight >= $currentCounter);
    }
}
