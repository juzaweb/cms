<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Models\Movie\Movies;
use App\Core\Http\Controllers\Controller;

class YearController extends Controller
{
    public function index($year) {
        $info = (object) [
            'name' => $year,
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
            ->where('year', '=', $year)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('genre.index', [
            'title' => $year,
            'description' => $year,
            'keywords' => $year,
            'info' => $info,
            'items' => $items,
        ]);
    }
}
