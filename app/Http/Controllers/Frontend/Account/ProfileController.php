<?php

namespace App\Http\Controllers\Frontend\Account;

use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Models\Movies;

class ProfileController extends Controller
{
    public function index() {
        $viewed = Cookie::get('viewed');
        $recently_visited = [];
        if ($viewed) {
            $viewed = json_decode($viewed, true);
            $recently_visited = Movies::whereIn('id', $viewed)
                ->where('status', '=', 1)
                ->paginate(5);
        }
        
        return view('themes.mymo.profile.index', [
            'user' => \Auth::user(),
            'recently_visited' => $recently_visited
        ]);
    }
}
