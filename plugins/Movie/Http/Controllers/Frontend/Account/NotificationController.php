<?php

namespace Plugins\Movie\Http\Controllers\Frontend\Account;

use Mymo\Core\Http\Controllers\FrontendController;

class NotificationController extends FrontendController
{
    public function index() {
        $user = \Auth::user();
        $notifications = $user->notifications()
            ->paginate(10);
        
        return view('account.notification.index', [
            'title' => trans('theme::app.notification'),
            'user' => $user,
            'notifications' => $notifications
        ]);
    }
    
    public function detail($id) {
        $user = \Auth::user();
        $notification = $user->notifications()
            ->where('id', '=', $id)
            ->firstOrFail();
        $notification->update(['read_at' => now()]);
        
        if (isset($notification->data['url'])) {
            return redirect()->to($notification->data['url']);
        }
        
        return view('account.notification.detail', [
            'title' => trans('theme::app.notification'),
            'user' => $user,
            'notification' => $notification
        ]);
    }
    
    public function getUnreadNotifications() {
    
        $result = [];
        if (\Auth::check()) {
            $notifications = \Auth::user()
                ->unreadNotifications()
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get();
            
            foreach ($notifications as $notification) {
                $result[] = [
                    'id' => $notification->id,
                    'thumb' => asset('styles/themes/mymo/images/notification.png'),
                    'link' => route('account.notification.detail', [$notification->id]),
                    'title' => $notification->data['subject'],
                    'date' => $notification->created_at->format('Y-m-d'),
                ];
            }
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    }
    
    public function readAllNotifications() {
        \Auth::user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);
    
        return response()->json([
            'status' => 'success',
        ]);
    }
}
