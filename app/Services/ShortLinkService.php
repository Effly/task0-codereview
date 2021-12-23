<?php

namespace App\Services;

use App\Interfaces\ShortLinkInterface;
use App\Models\ShortLink;
use App\Models\Tags;

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
                $link = new ShortLink();
                $link->long_url = $item['long_url'];
                $link->code = $this->codeService->getCode();
                $link->title = (!empty($item['title']) ? $item['title'] : $this->titleService->getTitle($item['long_url']));
                $link->save();
                $shortLinks[] = url($link->code);
                if (!empty($item['tags'])) {
                    foreach ($item['tags'] as $tag) {
                        $new_tag = new Tags();
                        $new_tag->name = $tag;
                        $link->tags()->save($new_tag);
                    }
                }
            } catch (\Exception $exception) {
                $shortLinks[] = 'bad url ' . $link->long_url;
            }
        }

        return $shortLinks;
    }
}
