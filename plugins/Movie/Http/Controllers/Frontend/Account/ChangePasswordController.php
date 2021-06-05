<?php

namespace Plugins\Movie\Http\Controllers\Frontend\Account;

use Mymo\Core\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Cookie;
use Plugins\Movie\Models\Movie\Movies;
use Plugins\Movie\User;
use Illuminate\Http\Request;

class ChangePasswordController extends FrontendController
{
    public function index()
    {
        $viewed = Cookie::get('viewed');
        if ($viewed) {
            $viewed = json_decode($viewed, true);
        }
        else {
            $viewed = [];
        }
        
        $recently_visited = Movies::whereIn('id', $viewed)
            ->where('status', '=', 1)
            ->paginate(5);
        
        return view('account.change_password', [
            'title' => trans('app.change_password'),
            'user' => \Auth::user(),
            'recently_visited' => $recently_visited
        ]);
    }
    
    public function handle(Request $request)
    {
        $this->validateRequest([
            'current_password' => 'required|string',
            'password' => 'required|string|max:32|min:6|confirmed',
            'password_confirmation' => 'required|string|max:32|min:6'
        ], $request, [
            'current_password' => trans('app.current_password'),
            'password' => trans('app.new_password'),
            'password_confirmation' => trans('app.confirm_password')
        ]);
        
        $current_password = $request->post('current_password');
        $password = $request->post('password');
        
        if (!\Hash::check($current_password, \Auth::user()->password)) {
            return response()->json([
                'status' => 'error',
                'message' => trans('app.current_password_incorrect'),
            ]);
        }
        
        User::where('id', '=', \Auth::id())
            ->update([
                'password' => \Hash::make($password),
            ]);
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.change_password_successfully'),
        ]);
    }
}
