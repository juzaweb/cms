<?php

namespace Mymo\Theme\Http\Controllers\Auth;

use Mymo\Theme\Http\Controllers\FrontendController;

class RegisterController extends FrontendController
{
    public function index()
    {
        return view('auth.register');
    }
}
