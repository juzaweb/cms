<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pages;

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
