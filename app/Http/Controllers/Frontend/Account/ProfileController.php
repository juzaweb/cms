<?php

namespace App\Http\Controllers\Frontend\Account;

use App\Http\Controllers\Controller;
use App\User;

class ProfileController extends Controller
{
    public function index() {
        $user = \Auth::user();
        return view('themes.mymo.profile.index', [
            'user' => $user
        ]);
    }
}
