<?php

namespace Mymo\Theme\Http\Controllers\Auth;

use Mymo\Theme\Http\Controllers\FrontendController;

class LoginController extends FrontendController
{
    public function index()
    {
        return view('auth.login');
    }
}
