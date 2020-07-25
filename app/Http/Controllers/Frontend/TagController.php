<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movies;
use App\Models\Tags;

class TagController extends Controller
{
    public function index($slug) {
        $info = Tags::where('slug', '=', $slug)
            ->firstOrFail(['id', 'name']);
        
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
            ->whereRaw('find_in_set(?, tags)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('themes.mymo.genre.index', [
            'items' => $items,
            'info' => $info,
        ]);
    }
}
