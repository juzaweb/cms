<?php

namespace App\Core\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use App\Core\Models\Movie\Movies;
use App\Core\Models\Category\Stars;

class StarController extends FrontendController
{
    public function index($slug) {
        $info = Stars::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail(['name', 'slug']);
    
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
    
        return view('genre.index', [
            'title' => $info->name,
            'description' => $info->name,
            'keywords' => $info->name,
            'items' => $items,
            'info' => $info,
        ]);
    }
}
