<?php

namespace App\Http\Controllers\Frontend\Account;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index() {
        $user = \Auth::user();
        $notifications = $user->notifications()
            ->paginate(10);
        return view('themes.mymo.profile.notification.index', [
            'user' => $user,
            'notifications' => $notifications
        ]);
    }
    
    public function detail($id) {
        $user = \Auth::user();
        $notification = $user->notifications()
            ->where('id', '=', $id)
            ->firstOrFail();
        
    }
}
