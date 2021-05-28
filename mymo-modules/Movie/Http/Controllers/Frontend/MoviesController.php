<?php

namespace App\Core\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Modules\Movie\Models\Movie\Movies;

class MoviesController extends FrontendController
{
    public function index()
    {
        $info = (object) [
            'name' => trans('app.movies'),
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
