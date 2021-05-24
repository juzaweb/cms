<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\FrontendController;
use App\Core\Models\Pages;

class PageController extends FrontendController
{
    public function index($slug) {
        $info = Pages::where('status', '=', 1)
            ->where('slug', '=', $slug)
            ->firstOrFail();
        
        return view('page.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'info' => $info
        ]);
    }
}
