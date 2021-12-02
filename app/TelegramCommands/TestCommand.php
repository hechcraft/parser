<?php


namespace App\TelegramCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class TestCommand extends Command
{
    protected $name = "info";

    protected $description = "info command";

    public function handle()
    {
        $this->replyWithMessage(['text' => 'Для отслеживания позиций перейдите по ссылке url']);
    }
}
