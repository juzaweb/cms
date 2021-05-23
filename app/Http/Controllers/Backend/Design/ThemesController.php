<?php

namespace App\Http\Controllers\Backend\Design;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemesController extends Controller
{
    public function index() {
        return view('backend.design.themes.index');
    }
    
    public function save(Request $request) {
    
    }
}
