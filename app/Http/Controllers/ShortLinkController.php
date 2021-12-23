<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateLinkRequest;
use App\Interfaces\ShortLinkInterface;
use App\Models\ShortLink;
use App\Models\Tags;
use App\Models\Viewers;
use App\Services\CodeService;
use App\Services\ShortLinkService;
use App\Services\TitleService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{

    /**
     * @var ShortLinkInterface
     */
    private ShortLinkInterface $shortLink;

    public function __construct(ShortLinkInterface $shortLink)
    {
        $this->shortLink = $shortLink;
    }


    public function index()
    {
        return ShortLink::all('long_url','code','title');
    }

    public function store(Request $request)
    {
//        dd(url()->full());
        return response()->json($this->shortLink->createShortLink($request->all()), 201);
    }

    public function followShortLink($code, Request $request)
    {

        $fetchLink = ShortLink::where('code', $code)->firstOrFail();

        $viewer = new Viewers();
        $viewer->user_agent = $request->userAgent();
        $viewer->ip = $request->ip();

        $fetchLink->viewers()->save($viewer);

        return redirect($fetchLink->long_url);
    }

    public function update($code)
    {

    }

    public function delete($code)
    {
        if (ShortLink::where('code', $code)->firstOrFail()->destroy()) return response()->json(null, 204);

    }

    public function getShortLinkByCode($code)
    {
        return response()->json(url(ShortLink::where('code', $code)->firstOrFail()->code), 201);
    }
}
