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
            'thumbnail',
            'name',
            'slug',
        ])
            ->where('status', '=', 1)
            ->whereRaw('find_in_set(?, genres)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('themes.mymo.genre.index', [
            'items' => $items,
            'info' => $info,
        ]);
    }
}
