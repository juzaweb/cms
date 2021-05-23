<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() {
        return view('themes.mymo.home.index', [
            'title' => get_config('title'),
            'description' => get_config('description'),
            'keywords' => get_config('keywords'),
            'banner' => get_config('banner'),
        ]);
    }
}
