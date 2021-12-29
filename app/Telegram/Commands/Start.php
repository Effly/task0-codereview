<?php

namespace App\Telegram\Commands;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Throwable;

class Start extends Command
{
    protected $name = 'start';
    protected $aliases = ['/start'];
    protected $description = 'Start command to process initial request!';
    protected $arguments = [];
    protected $pattern = '{url} {title?}';

    /**
     * Execute the bot command.
     */
    public function handle()
    {
        $message = $this->getUpdate()->getMessage();
        Log::info(
            serialize($this->arguments)
        );
        $firstName = $message->from->first_name;

        $text = "Hello, $firstName! Welcome to our bot!\nType /help to get a list of available commands.";
        $args = (object) $this->arguments;
        $this->telegram->sendMessage([
            'chat_id' => $message->chat->id,
            'text' => $args->url,
        ]);
    }

    /**
     * Triggered on failure.
     *
     * @param array $arguments
     * @param Throwable $exception
     */
    public function failed(array $arguments, Throwable $exception)
    {
        Log::info('1' . $exception);
    }
}
