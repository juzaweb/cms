<?php

namespace Modules\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Modules\Movie\Models\Movie\Movies;
use Modules\Movie\Models\Category\Tags;

class TagController extends FrontendController
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
