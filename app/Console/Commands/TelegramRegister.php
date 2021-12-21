<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TelegramRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:register {--remove} {--output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Telegram register webhook';

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
     * @return void
     */
    public function handle()
    {
        $url = 'https://api.telegram.org/bot'
            .config('telegram.bots.mybot.token')
            .'/setWebhook';

        $remove = $this->option('remove');

        if (! $remove) {
            $url .= '?url='.$this->ask('What is the target url for the telegram bot?') . '/webhook';
        }

        $this->info('Using '.$url);

        $this->info('Pinging Telegram...');

        $output = json_decode(file_get_contents($url));

        if ($output->ok == true && $output->result == true) {
            $this->info(
                $remove
                    ? 'Your bot Telegram\'s webhook has been removed!'
                    : 'Your bot is now set up with Telegram\'s webhook!'
            );
        }

        if ($this->option('output')) {
            dump($output);
        }
    }
}
