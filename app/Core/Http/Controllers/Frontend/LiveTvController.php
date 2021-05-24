<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\FrontendController;

class LiveTvController extends FrontendController
{
    public function index()
    {
        return view('live-tv.index');
    }
}
