<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Plugins\Movie\Models\Movie\Movie;

class MoviesController extends FrontendController
{
    public function index()
    {
        $info = (object) [
            'name' => trans('app.movies'),
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
            'genres',
            'countries',
            'tv_series',
            'current_episode',
            'max_episode',
        ])
            ->where('status', '=', 1)
            ->where('tv_series', '=', 0)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('genre.index', [
            'title' => get_config('movies_title'),
            'description' => get_config('movies_description'),
            'keywords' => get_config('movies_keywords'),
            'banner' => get_config('movies_banner'),
            'items' => $items,
            'info' => $info,
        ]);
    }
}
