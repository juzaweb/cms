<?php

namespace App\Core\Http\Controllers\Frontend\Account;

use Illuminate\Support\Facades\Cookie;
use App\Core\Http\Controllers\FrontendController;
use App\Core\Models\Movie\Movies;

class ProfileController extends FrontendController
{
    public function index() {
        $viewed = Cookie::get('viewed');
        $viewed = $viewed ? json_decode($viewed, true) : [0];
        $recently_visited = Movies::whereIn('id', $viewed)
            ->where('status', '=', 1)
            ->paginate(5);
        
        return view('account.index', [
            'title' => trans('app.profile'),
            'user' => \Auth::user(),
            'recently_visited' => $recently_visited
        ]);
    }
}
