<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movies;
use App\Http\Controllers\Controller;

class YearController extends Controller
{
    public function index($year) {
        $items = Movies::where('status', '=', 1)
            ->where('release', 'like', $year . '%')
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('themes.mymo.genre.index', [
            'items' => $items
        ]);
    }
}
