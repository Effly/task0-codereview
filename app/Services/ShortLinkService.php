<?php

namespace App\Services;

use App\Interfaces\ShortLinkInterface;
use App\Models\ShortLink;
use App\Models\Tags;
use App\Models\Viewers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ShortLinkService implements ShortLinkInterface
{
    /**
     * @var TitleService
     */
    private TitleService $titleService;
    /**
     * @var CodeService
     */
    private CodeService $codeService;

    public function __construct(
        TitleService $titleService,
        CodeService  $codeService)
    {
        $this->titleService = $titleService;
        $this->codeService = $codeService;

    }

    public function createShortLink($data): array
    {
        $shortLinks = [];
        foreach ($data as $item) {

            try {
                $title = $this->titleService->getTitle($item['long_url']);
                Log::info($title);
                $link = new ShortLink();
                $link->long_url = $item['long_url'];
                $link->code = $this->codeService->getCode();
                $link->title = (!empty($item['title']) ? $item['title'] : $title);
                $link->save();
                $shortLinks[] = 'https://m88cloud.ibg.ru:88/'.$link->code;
                if (!empty($item['tags'])) {
                    foreach ($item['tags'] as $tag) {
                        $new_tag = new Tags();
                        $new_tag->name = $tag;
                        $link->tags()->save($new_tag);
                    }
                }
            } catch (\Exception $exception) {
                $shortLinks[] = 'bad url ' . $link->long_url;
                Log::error($exception);
            }
        }

        return $shortLinks;
    }
    public function getStatsByShortLink($shortLink): array
    {
        $code = explode('https://m88cloud.ibg.ru:88/',$shortLink)[1];
        $link = ShortLink::where('code', $code)->firstOrFail();
        return $link->viewers()->orderBy('created_at', 'desc')->get(['user_agent', 'ip', 'created_at'])
            ->groupBy(function ($items) {
                return Carbon::parse($items->created_at)->format('d.m.Y');
            })->map(function ($item) {
                return [
                    'total_views' => $item->count(),
                    "unique_views" => $item->unique(function ($item) {
                        return $item['user_agent'] . $item['ip'];
                    })->count()
                ];
            })
            ->toArray();
    }

    public function getStats(): object
    {
        $allLinks = ShortLink::all();
        return $allLinks->map(function ($item) {
            Log::info($item->code);
            return [
                'short_link'=>'https://m88cloud.ibg.ru:88/'.$item->code,
                'unique_views' => $item->viewers()->get()->unique(function ($item) {
                        return $item['user_agent'] . $item['ip'];
                    })->count(),
                'total_views'=>$item->viewers()->get()->count(),
                'title' => $item->title
            ];
        });
    }
}
