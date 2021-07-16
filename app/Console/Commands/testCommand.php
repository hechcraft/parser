<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class testCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $browser = $puppeteer->launch([
            'headless' => true,
            'args' => [
                '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);

        $page = $browser->newPage();
//        $page->goto('https://www.olx.ua/d/obyavlenie/prodam-raketu-kawasaki-IDM9xRu.html');
//        $page->goto('https://www.avito.ru/vyatskie_polyany/zapchasti_i_aksessuary/kolesa_2190155178');
        $page->goto('https://www.avito.ru/rostov-na-donu/kvartiry/2-k._kvartira_50m_1224et._1100891590');
//        $page->goto('https://www.dns-shop.ru/product/1110e3f5aef22eb1/videokarta-gigabyte-geforce-rtx-3060-gaming-oc-lhr-gv-n3060gaming-oc-12gd-rev20/', [
//            'timeout' => 90000
//        ]);

//        $data = $page->evaluate(JsFunction::createWithBody('return document.documentElement.outerHTML'));
//        olx.ua
//        $data = $page->evaluate(JsFunction::createWithBody("
//            return {
//                price: document.querySelector('[data-testid=\"ad-price-container\"] h3').innerText,
//            };
//        "));

//        avito
        $data = $page->evaluate(JsFunction::createWithBody("
            return {
                price: document.querySelector('span[class^=price-value-string]').innerText,
            };
        "));
//        dns
//        $data = $page->evaluate(JsFunction::createWithBody("
//            return {
//                price: document.querySelector(\".product-buy__price\").innerText,
//            };
//        "));
//

        $browser->close();
        dd($data);
    }
}
