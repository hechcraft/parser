<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class olxPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:olx {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get price from olx';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch();

        $page = $browser->newPage();
//        $page->goto('https://www.olx.ua/d/obyavlenie/prodam-raketu-kawasaki-IDM9xRu.html');
//        $page->goto('https://www.olx.ua/nedvizhimost/kvartiry-komnaty/arenda-kvartir-komnat/lugansk/');
        $page->goto($this->argument('url'));

        $parserData = $page->evaluate(JsFunction::createWithBody("
            var parserData = Array.from(document.querySelectorAll(\"#offers_table .offer-wrapper\")).
                        map(node => ({ name: node.querySelector(\"h3 >a[class*= link]\").innerText,
                            url: node.querySelector(\"h3>a[class*=link]\").getAttribute('href'),
                            price: node.querySelector(\"p.price > strong\").innerText,
                            img: node.querySelector(\"a[class^=thumb] > img\").getAttribute('src')}));
            return {
                parserData: parserData,
                arrayLength: parserData.length
            };
        "));

        if ($parserData['arrayLength'] != 0) {
            $browser->close();
            return $parserData;
        }

        $parserData = $page->evaluate(JsFunction::createWithBody("
            return {
                price: document.querySelector('[data-testid=\"ad-price-container\"] h3').innerText,
            };
        "));

        $browser->close();
        return $parserData;
    }
}
