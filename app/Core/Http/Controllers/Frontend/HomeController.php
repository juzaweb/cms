<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\FrontendController;

class HomeController extends FrontendController
{
    public function index() {
        return view('home.index', [
            'title' => get_config('title'),
            'description' => get_config('description'),
            'keywords' => get_config('keywords'),
            'banner' => get_config('banner'),
        ]);
    }
}
