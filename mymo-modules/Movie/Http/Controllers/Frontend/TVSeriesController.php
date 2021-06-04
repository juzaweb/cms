<?php

namespace Modules\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Modules\Movie\Models\Movie\Movies;

class TVSeriesController extends FrontendController
{
    public function index()
    {
        $info = (object) [
            'name' => trans('app.tv_series')
        ];
        
        $items = Movies::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'video_quality',
            'year',
            'genres',
            'countries',
            'tv_series',
            'current_episode',
            'max_episode',
        ])
            ->where('status', '=', 1)
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
