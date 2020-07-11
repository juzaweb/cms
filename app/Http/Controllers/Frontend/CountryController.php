<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Countries;
use App\Models\Movies;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index($slug) {
        $info = Countries::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        $items = Movies::select([
            'id',
            'thumbnail',
            'name',
            'slug',
        ])
            ->where('status', '=', 1)
            ->whereRaw('find_in_set(?, countries)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('themes.mymo.genre.index', [
            'items' => $items,
            'info' => $info,
        ]);
    }
}
