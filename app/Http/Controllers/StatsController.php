<?php

namespace App\Http\Controllers;

use App\Interfaces\ShortLinkInterface;
use App\Models\ShortLink;
use App\Models\Viewers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __construct(ShortLinkInterface $shortLinkService)
    {
        $this->shortLinkService = $shortLinkService;
    }

    public function getStatsByShortLink($shortLink)
    {
        return $this->shortLinkService->getStatsByShortLink($shortLink);
    }

    public function getStats(): array
    {
        return $this->shortLinkService->getStats();

    }
}
