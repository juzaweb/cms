<?php

namespace App\Http\Controllers\Frontend\Account;

use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Models\Movie\Movies;

class ProfileController extends Controller
{
    public function index() {
        $viewed = Cookie::get('viewed');
        $viewed = $viewed ? json_decode($viewed, true) : [0];
        $recently_visited = Movies::whereIn('id', $viewed)
            ->where('status', '=', 1)
            ->paginate(5);
        
        return view('themes.mymo.account.index', [
            'title' => trans('app.profile'),
            'user' => \Auth::user(),
            'recently_visited' => $recently_visited
        ]);
    }
}
