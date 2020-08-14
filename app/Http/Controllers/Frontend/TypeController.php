<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Types;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    public function index($slug) {
        $info = Types::where('slug', '=', $slug)
            ->firstOrFail();
        
        $items = $info->movies()
            ->where('status', '=', 1)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('themes.mymo.genre.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'info' => $info,
            'items' => $items,
        ]);
    }
}
