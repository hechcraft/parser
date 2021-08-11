<?php


namespace App\TelegramCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected $name = "start";

    protected $description = "Start Command to get you started";

    public function handle()
    {
        $this->replyWithMessage(['text' => 'Hello! Welcome to our bot, Here are our available commands:']);
    }
}
