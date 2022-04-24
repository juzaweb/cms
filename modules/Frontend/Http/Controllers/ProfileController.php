<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/16/2021
 * Time: 8:15 PM
 */

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class ProfileController extends FrontendController
{
    public function index($slug = null)
    {
        $title = trans('cms::app.profile');
        $user = Auth::user();

        return $this->view('theme::profile.index', compact(
            'title',
            'user',
            'slug'
        ));
    }

    public function changePassword()
    {
        $title = trans('cms::app.change_password');
        $user = Auth::user();

        return $this->view('theme::profile.change_password', compact(
            'title',
            'user'
        ));
    }

    public function notification()
    {
        $title = trans('cms::app.profile');
        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        return $this->view('theme::profile.notification.index', compact(
            'title',
            'notifications',
            'user'
        ));
    }

    public function doChangePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|string|max:32|min:6',
        ]);

        $currentPassword = $request->post('current_password');
        $password = $request->post('password');
        $user = Auth::user();

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => trans('cms::app.current_password_incorrect'),
            ]);
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        return $this->success([
            'message' => trans('cms::app.change_password_successfully'),
        ]);
    }
}
