<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Genres;
use App\Models\Movies;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    public function index($slug) {
        $info = Genres::where('slug', '=', $slug)
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
            ->whereRaw('find_in_set(?, genres)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('themes.mymo.genre.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'items' => $items,
            'info' => $info,
        ]);
    }
}
