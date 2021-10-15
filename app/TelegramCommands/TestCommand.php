<?php


namespace App\TelegramCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class TestCommand extends Command
{
    protected $name = "test";

    protected $description = "test command";

    public function handle()
    {
        $this->replyWithMessage(['text' => 'Test Command']);
    }
}
