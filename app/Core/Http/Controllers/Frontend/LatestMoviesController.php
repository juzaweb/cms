<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\Controller;
use App\Core\Models\Movie\Movies;

class LatestMoviesController extends Controller
{
    public function index() {
        $info = (object) [
            'name' => trans('app.latest_movies'),
        ];
        
        $items = Movies::where('status', '=', 1)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('themes.mymo.genre.index', [
            'title' => get_config('latest_movies_title'),
            'description' => get_config('latest_movies_description'),
            'keywords' => get_config('latest_movies_keywords'),
            'banner' => get_config('latest_movies_banner'),
            'info' => $info,
            'items' => $items,
        ]);
    }
}
