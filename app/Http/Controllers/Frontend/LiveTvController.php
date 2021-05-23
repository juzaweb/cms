<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class LiveTvController extends Controller
{
    public function index() {
        return view('themes.mymo.live-tv.index');
    }
}
