<?php

namespace App\Telegram\Commands;

use App\Interfaces\ShortLinkInterface;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Throwable;

class getStats extends Command
{
    protected $name = 'getStats';
    protected $aliases = ['/getStats'];
    protected $description = 'Start command to process shorter link!';


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
        Log::info('blablabla');
        $info = '';
        try {
            $stats = $this->shortLinkService->getStats();
            foreach ($stats as $stat) {
                $info .= $stat['short_link'] . ' ' . $stat['unique_views'] . ' ' . $stat['total_views'] . ' ' . $stat['title'] . "\n";

            }
        } catch (\Exception $exception) {
            Log::error(serialize($exception));
            $info .= $exception;

        }
        $this->telegram->sendMessage([
            'chat_id' => $message->chat->id,
            'text' => $info,
        ]);
    }

    /**
     * Triggered on failure.
     *
     * @param Throwable $exception
     */
    public function failed(Throwable $exception)
    {
        Log::info($exception);
    }
}
