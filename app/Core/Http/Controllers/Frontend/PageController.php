<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\Controller;
use App\Core\Models\Pages;

class PageController extends Controller
{
    public function index($slug) {
        $info = Pages::where('status', '=', 1)
            ->where('slug', '=', $slug)
            ->firstOrFail();
        
        return view('themes.mymo.page.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'info' => $info
        ]);
    }
}
