<?php

namespace Mymo\Frontend\Controllers\Auth;

use Mymo\Frontend\Controllers\FrontendController;

class RegisterController extends FrontendController
{
    public function index()
    {
        return view('auth.register');
    }
}
