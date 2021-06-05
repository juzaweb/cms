<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Plugins\Movie\Models\Category\Genres;
use Plugins\Movie\Models\Movie\Movies;
use Mymo\Core\Http\Controllers\FrontendController;

class GenreController extends FrontendController
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
        
        return view('genre.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'banner' => $info->getThumbnail(false),
            'items' => $items,
            'info' => $info,
        ]);
    }
}
