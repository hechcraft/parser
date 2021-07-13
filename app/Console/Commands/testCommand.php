<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use PDepend\Util\Log;

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
        $puppeteer = new Puppeteer([
//            'read_timeout' => 95,
//            'idle_timeout' => 90,
        ]);
        $browser = $puppeteer->launch([
          'headless' => false,
        ]);

        $page = $browser->newPage();
//        $page->goto('https://www.olx.ua/d/obyavlenie/prodam-raketu-kawasaki-IDM9xRu.html');
//        $page->goto('https://www.avito.ru/vyatskie_polyany/zapchasti_i_aksessuary/kolesa_2190155178');
        $page->goto('https://www.dns-shop.ru/product/1110e3f5aef22eb1/videokarta-gigabyte-geforce-rtx-3060-gaming-oc-lhr-gv-n3060gaming-oc-12gd-rev20/', [
//            'timeout' => 90000
        ]);

        $data = $page->evaluate(JsFunction::createWithBody('return document.documentElement.outerHTML'));
//        olx.ua
//        $data = $page->evaluate(JsFunction::createWithBody("
//            return {
//                price: document.querySelector('[data-testid=\"ad-price-container\"] h3').innerText,
//            };
//        "));

//        avito
//        $data = $page->evaluate(JsFunction::createWithBody("
//            return {
//                price: document.querySelector(\".js-item-price\").innerText,
//            };
//        "));
//        dns
        $data = $page->evaluate(JsFunction::createWithBody("
            return {
                price: document.querySelector(\".product-buy__price\").innerText,
            };
        "));
//

        $browser->close();
        dd($data);
    }
}
