<?php

namespace App\Telegram\Commands;

use App\Interfaces\ShortLinkInterface;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Throwable;

class getShortLink extends Command
{
    protected $name = 'getShortLink';
    protected $aliases = ['/getShortLink'];
    protected $description = 'Start command to process shorter link!';
    protected $arguments = [];
    protected $pattern = '{long_url} {title?}';


    public function __construct(ShortLinkInterface $shortLinkService)
    {
        $this->shortLinkService = $shortLinkService;
    }


    /**
     * Execute the bot command.
     */
    public function handle()
    {
        $message = $this->getUpdate()->getMessage();
        Log::info(
            serialize($this->arguments)
        );
        try {
            $shortOrException = $this->shortLinkService->createShortLink([$this->arguments])[0];
        } catch (\Exception $exception) {
            Log::error(serialize($exception));
            $shortOrException = $exception;
        }
        $this->telegram->sendMessage([
            'chat_id' => $message->chat->id,
            'text' => $shortOrException,
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
