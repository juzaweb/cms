<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Http\Controllers\Controller;

class LiveTvController extends Controller
{
    public function index() {
        return view('live-tv.index');
    }
}
