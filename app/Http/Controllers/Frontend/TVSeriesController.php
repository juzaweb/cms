<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movies;
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
            'year',
            'video_quality',
            'genres',
            'countries',
        ])
            ->where('status', '=', 1)
            ->where('tv_series', '=', 1)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('themes.mymo.genre.index', [
            'items' => $items,
            'info' => $info
        ]);
    }
}
