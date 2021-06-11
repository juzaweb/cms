<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Plugins\Movie\Models\Movie\Movie;

class TVSeriesController extends FrontendController
{
    public function index()
    {
        $info = (object) [
            'name' => trans('mymo::app.tv_series')
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
            ->where('tv_series', '=', 1)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('genre.index', [
            'title' => get_config('tv_series_title'),
            'description' => get_config('tv_series_description'),
            'keywords' => get_config('tv_series_keywords'),
            'banner' => get_config('tv_series_banner'),
            'items' => $items,
            'info' => $info
        ]);
    }
}
