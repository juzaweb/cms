<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\User;

class ProfileController extends Controller
{
    public function index() {
        $user = User::find(\Auth::id());
        return view('themes.mymo.profile.index', [
            'user' => $user
        ]);
    }
}
