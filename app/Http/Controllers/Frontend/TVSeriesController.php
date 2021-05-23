<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movie\Movies;
use App\Http\Controllers\Controller;

class TVSeriesController extends Controller
{
    public function index() {
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
    
        return view('themes.mymo.genre.index', [
            'title' => get_config('tv_series_title'),
            'description' => get_config('tv_series_description'),
            'keywords' => get_config('tv_series_keywords'),
            'banner' => get_config('tv_series_banner'),
            'items' => $items,
            'info' => $info
        ]);
    }
}
