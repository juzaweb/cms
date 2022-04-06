<?php

namespace Juzaweb\Backend\Http\Controllers;

use Juzaweb\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        return redirect()->route('installer.welcome');
    }

    public function welcome()
    {
        return view('installer::welcome');
    }
}
