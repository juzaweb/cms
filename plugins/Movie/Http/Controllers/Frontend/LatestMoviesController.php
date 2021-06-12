<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Plugins\Movie\Models\Movie\Movie;

class LatestMoviesController extends FrontendController
{
    public function index() {
        $info = (object) [
            'name' => trans('theme::app.latest_movies'),
        ];
        
        $items = Movie::wherePublish()
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('genre.index', [
            'title' => get_config('latest_movies_title'),
            'description' => get_config('latest_movies_description'),
            'keywords' => get_config('latest_movies_keywords'),
            'banner' => get_config('latest_movies_banner'),
            'info' => $info,
            'items' => $items,
        ]);
    }
}
