<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;

class HomeController extends FrontendController
{
    public function index()
    {
        return view('home.index', [
            'title' => get_config('title'),
            'description' => get_config('description'),
            'keywords' => get_config('keywords'),
            'banner' => get_config('banner'),
        ]);
    }
}
