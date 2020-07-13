<?php

namespace App\Http\Controllers\Backend\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemesController extends Controller
{
    public function index() {
        return view('backend.theme.themes.index', [
        
        ]);
    }
    
    public function save(Request $request) {
    
    }
}
