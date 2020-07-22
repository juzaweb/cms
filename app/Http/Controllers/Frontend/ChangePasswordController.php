<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function index() {
        return view('themes.mymo.profile.change_password');
    }
    
    public function changePassword(Request $request) {
        $this->validateRequest([
            'password' => 'required',
            'new_password' => 'required',
        ], $request, [
        
        ]);
    }
}
