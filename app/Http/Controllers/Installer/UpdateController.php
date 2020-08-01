<?php

namespace App\Http\Controllers\Installer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function index() {
        return view('installer.update');
    }
}
