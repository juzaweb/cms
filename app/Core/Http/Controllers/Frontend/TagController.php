<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\Controller;
use App\Core\Models\Movie\Movies;
use App\Core\Models\Category\Tags;

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
    
        return view('genre.index', [
            'items' => $items,
            'info' => $info,
        ]);
    }
}
