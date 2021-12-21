<?php

namespace App\Jobs;

use App\Models\Offers;
use App\Models\Pages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nesk\Puphpeteer\Resources\Page;

class SendOffers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $telegram = new \Telegram\Bot\Api();

        $pages = Pages::all();

        foreach ($pages as $page) {
            $stringFormat ='Название: %s,' . PHP_EOL . 'Цена: %s' . PHP_EOL . '<a href="%s">Offer url</a>';
            $response = $telegram->sendPhoto([
                'chat_id' => $page->user->telegram_id,
                'photo' => \Telegram\Bot\FileUpload\InputFile::create($page->offer->image_url, 'photo'),
                'caption' => sprintf($stringFormat, $page->offer->name, $page->offer->lastPrice->price_str, $page->offer->offer_url),
                'parse_mode' => 'HTML',
            ]);

            $messageId = $response->getMessageId();
        }
    }
}
