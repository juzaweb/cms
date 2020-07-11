<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movies;
use App\Http\Controllers\Controller;

class WatchController extends Controller
{
    public function index($slug) {
        $item = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        return view('themes.mymo.watch.index', [
            'item' => $item,
        ]);
    }
    
    public function watch($slug) {
        $item = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        return view('themes.mymo.watch.watch', [
            'item' => $item,
        ]);
    }
}
