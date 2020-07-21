<?php

namespace App\Http\Controllers\Backend;

use App\Models\Movies;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        $count_movie = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 0)
            ->count('id');
        $count_tvserie = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 1)
            ->count('id');
        $count_user = User::where('status', '=', 1)
            ->count('id');
        
        return view('backend.dashboard', [
            'count_movie' => $count_movie,
            'count_tvserie' => $count_tvserie,
            'count_user' => $count_user,
        ]);
    }
}
