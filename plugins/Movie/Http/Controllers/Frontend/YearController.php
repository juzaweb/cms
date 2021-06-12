<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Plugins\Movie\Models\Movie\Movie;

class YearController extends FrontendController
{
    public function index($year) {
        $info = (object) [
            'name' => $year,
        ];
        
        $items = Movie::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'video_quality',
            'year',
            'tv_series',
            'current_episode',
            'max_episode',
        ])
            ->wherePublish()
            ->where('year', '=', $year)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('genre.index', [
            'title' => $year,
            'description' => $year,
            'keywords' => $year,
            'info' => $info,
            'items' => $items,
        ]);
    }
}
