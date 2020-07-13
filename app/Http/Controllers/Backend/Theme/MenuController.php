<?php

namespace App\Http\Controllers\Backend\Theme;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index() {
        return view('backend.theme.menu.index');
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
        ], $request, [
            'name' => trans('app.name')
        ]);
        
        
    }
}
