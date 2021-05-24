<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\FrontendController;
use App\Core\Models\Category\Types;

class TypeController extends FrontendController
{
    public function index($slug) {
        $info = Types::where('slug', '=', $slug)
            ->firstOrFail();
        
        $items = $info->movies()
            ->where('status', '=', 1)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('genre.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'info' => $info,
            'items' => $items,
        ]);
    }
}
