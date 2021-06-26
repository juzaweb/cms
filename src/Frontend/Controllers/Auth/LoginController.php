<?php

namespace Mymo\Frontend\Controllers\Auth;

use Mymo\Frontend\Controllers\FrontendController;

class LoginController extends FrontendController
{
    public function index()
    {
        return view('auth.login');
    }
}
