<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Models\Viewers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function getStatsByCode($code)
    {
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

    public function getStats()
    {

        $allLinks = ShortLink::all();
        return [
            'unique_views' => array_sum($allLinks->map(function ($item) {
                return $item->viewers()->get()->unique(function ($item) {
                    return $item['user_agent'] . $item['ip'];
                })->count();
            })->toArray()),
            'total_views' => Viewers::all()->count()
//        "total_views" => array_sum($allLinks->map(function ($item) { // Вот тут я прям хз как лучше Вроде б и запрос в бд один но действий с коллекцией больше
//                return $item->viewers()->get()->count();
//            })->toArray())
        ];
    }
}
