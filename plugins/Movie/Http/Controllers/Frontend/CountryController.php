<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Plugins\Movie\Models\Category\Countries;
use Plugins\Movie\Models\Movie\Movie;
use Mymo\Core\Http\Controllers\FrontendController;

class CountryController extends FrontendController
{
    public function index($slug) {
        $info = Countries::where('slug', '=', $slug)
            ->where('status', '=', 1)
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
            ->whereRaw('find_in_set(?, countries)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('genre.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'items' => $items,
            'info' => $info,
        ]);
    }
}
