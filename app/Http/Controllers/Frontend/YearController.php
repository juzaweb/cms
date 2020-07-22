<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movies;
use App\Http\Controllers\Controller;

class YearController extends Controller
{
    public function index($year) {
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
        ])
            ->where('status', '=', 1)
            ->where('year', '=', $year)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('themes.mymo.genre.index', [
            'items' => $items
        ]);
    }
}
