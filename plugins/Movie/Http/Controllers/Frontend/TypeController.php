<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Mymo\PostType\Models\Taxonomy;

class TypeController extends FrontendController
{
    public function index($slug) {
        $info = Taxonomy::where('slug', '=', $slug)
            ->firstOrFail();
        
        $items = $info->movies()
            ->wherePublish()
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
