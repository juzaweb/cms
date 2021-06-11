<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\PostType\Models\Taxonomy;
use Plugins\Movie\Models\Movie\Movie;
use Mymo\Core\Http\Controllers\FrontendController;

class GenreController extends FrontendController
{
    public function index($slug) {
        $info = Taxonomy::where('slug', '=', $slug)
            ->firstOrFail();
        
        $items = Movie::select([
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
            ->whereTaxonomy($info->id)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('genre.index', [
            'title' => $info->name,
            'description' => $info->description,
            'banner' => $info->getThumbnail(false),
            'items' => $items,
            'info' => $info,
        ]);
    }
}
