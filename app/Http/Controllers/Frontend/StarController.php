<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movies;
use App\Models\Stars;
use App\Http\Controllers\Controller;

class StarController extends Controller
{
    public function index($slug) {
        $info = Stars::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
    
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
            ->whereRaw('find_in_set(?, stars)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('themes.mymo.genre.index', [
            'title' => $info->name,
            'description' => $info->name,
            'keywords' => $info->name,
            'items' => $items,
            'info' => $info,
        ]);
    }
}
