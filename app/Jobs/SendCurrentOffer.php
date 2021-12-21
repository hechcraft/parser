<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class SendCurrentOffer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $currentOffer;
    private $currentPrice;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($currentOffer, $currentPrice)
    {
        $this->currentOffer = $currentOffer;
        $this->currentPrice = $currentPrice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $telegram = new Api();

        $stringFormat = 'Название: %s,' . PHP_EOL . 'Цена: %s' . PHP_EOL . '<a href="%s">Offer url</a>';
        try {
            $response = $telegram->sendPhoto([
                'chat_id' => $this->currentOffer->page->user->telegram_id,
                'photo' => \Telegram\Bot\FileUpload\InputFile::create(asset($this->currentOffer->image_url), 'photo'),
                'caption' => sprintf($stringFormat, $this->currentOffer->name, str_replace("\n", '', $this->currentPrice), $this->currentOffer->offer_url),
                'parse_mode' => 'HTML',
            ]);

        } catch (\Exception $exception) {
            $response = $telegram->sendMessage([
                'chat_id' => $this->currentOffer->page->user->telegram_id,
                'text' => sprintf($stringFormat, $this->currentOffer->name, str_replace("\n", '', $this->currentPrice), $this->currentOffer->offer_url),
                'parse_mode' => 'HTML',
            ]);
        }

        $messageId = $response->getMessageId();
    }
}
