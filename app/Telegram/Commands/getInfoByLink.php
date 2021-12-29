<?php

namespace App\Telegram\Commands;

use App\Interfaces\ShortLinkInterface;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Throwable;

class getInfoByLink extends Command
{
    protected $name = 'getInfoByLink';
    protected $aliases = ['/getInfoByLink'];
    protected $description = 'Start command to process shorter link!';
    protected $arguments = [];
    protected $pattern = '{short_url}';


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
            $this->arguments['short_url']
        );
        $info ='';
        try {
            $dates = $this->shortLinkService->getStatsByShortLink($this->arguments['short_url']);
            foreach ($dates as $date => $views) {
                $info .= $date .' '. $views['unique_views'] .' '. $views['total_views']."\n";

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
     * @param array $arguments
     * @param Throwable $exception
     */
    public function failed(array $arguments, Throwable $exception)
    {
        Log::info('1' . $exception);
    }
}
