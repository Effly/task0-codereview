<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function getStatsByCode($code)
    {
        $link = ShortLink::where('code', $code)->firstOrFail();
//        dd($link->viewers()->get()->unique('user_agent','ip')->toArray());

        $results = $link->viewers()->orderBy('created_at', 'desc')->get(['user_agent','ip','created_at'])
            ->unique(function ($item){
                return $item['user_agent'].$item['ip'];
            })
            ->groupBy(function ($items) {
                return Carbon::parse($items->created_at)->format('d.m.Y'); // А это то-же поле по нему мы и будем группировать
            })
//            ->count();
            ->toArray();
        dd($results);
        $allResults = [];
        foreach ($results as $date => $result) {
            dump(($result));
            $allResults[$date] = [
                'total_views'=>count($result),
//                "unique_views"=> ,

            ];
        }
        dd($allResults);
    }

    public function getStats()
    {

    }
}
