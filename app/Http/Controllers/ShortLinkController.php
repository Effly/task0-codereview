<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateLinkRequest;
use App\Models\ShortLink;
use App\Models\Tags;
use App\Models\Viewers;
use App\Services\CodeService;
use App\Services\TitleService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * @var TitleService
     */
    private $titleService;
    /**
     * @var CodeService
     */
    private $codeService;

    public function __construct(
//        TitleService $titleService,
        CodeService $codeService)
    {
//        $this->titleService = $titleService;
        $this->codeService = $codeService;

    }


    public function index(Request $request)
    {
//        dd($request->userAgent());
//        return 1;
        return view('shortenLinks');
    }

    public function store(GenerateLinkRequest $request)
    {
//        $request->dd();
//        dd();
//        $request->validated();
        foreach (array_combine($request->validated()['long_url'], $request->validated()['tags']) as $long_url => $tag) {
//            $link = ShortLink::create([
//                'long_url' => $long_url,
//                'title' => 'test title',
////                (empty($request->validated()['title'])) ? $this->titleService->getTitle($request->validated()['long_url']) : $request->validated()['title'],
//
//                'code' => $this->codeService->getCode()
//            ]);
//            dd($link);
//            $new_tag = Tags::create([
//                'name' => $tag
//            ]);
//            $link->tags()->save(Tags::create(['name' => $tag]));

            $link = new ShortLink();
            $link->long_url = $long_url;
            $link->title = 'test title';
            $link->code = $this->codeService->getCode();
            $link->save();

//            dd($link);

            $new_tag = new Tags();
            $new_tag->name = $tag;

            $link->tags()->save($new_tag);

        }


    }

    public function followShortLink($code, Request $request)
    {
        $fetchLink = ShortLink::where('code', $code)->first();
        $viewer = Viewers::create([
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);
        $fetchLink->viewers()->save($viewer);

        return redirect($fetchLink->long_url);
    }
}
