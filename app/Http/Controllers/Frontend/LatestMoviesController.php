<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movies;

class LatestMoviesController extends Controller
{
    public function index() {
        $items = Movies::where('status', '=', 1)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('themes.mymo.genre.index', [
            'title' => get_config('latest_movies_title'),
            'description' => get_config('latest_movies_description'),
            'keywords' => get_config('latest_movies_keywords'),
            'banner' => get_config('latest_movies_banner'),
            'items' => $items,
        ]);
    }
}
