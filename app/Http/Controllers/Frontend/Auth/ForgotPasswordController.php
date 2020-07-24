<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function handle(Request $request) {
        $this->validateRequest([
            'email' => 'required',
        ], $request, [
            'email' => trans('app.email')
        ]);
    }
}
