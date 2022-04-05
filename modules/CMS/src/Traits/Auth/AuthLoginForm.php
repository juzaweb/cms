<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Models\User;
use Juzaweb\Traits\ResponseMessage;

trait AuthLoginForm
{
    use ResponseMessage;

    public function index()
    {
        do_action('login.index');

        do_action('recaptcha.init');

        return view('cms::auth.login', [
            'title' => trans('cms::app.login'),
        ]);
    }

    public function login(Request $request)
    {
        // Login handle action
        do_action('login.handle', $request);

        // Validate login
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:32',
        ]);

        if (get_config('google_recaptcha')) {
            $request->validate([
                'recaptcha' => 'required|recaptcha',
            ]);
        }

        $email = $request->post('email');
        $password = $request->post('password');
        $remember = filter_var(
            $request->post('remember', 1),
            FILTER_VALIDATE_BOOLEAN
        );

        $user = User::whereEmail($email)->first(['status', 'is_admin']);

        if (empty($user)) {
            return $this->error([
                'message' => trans('cms::message.login_form.login_failed'),
            ]);
        }

        if ($user->status != 'active') {
            if ($user->status == 'verification') {
                return $this->error([
                    'message' => trans('cms::message.login_form.verification'),
                ]);
            }

            return $this->error([
                'message' => trans('cms::message.login_form.user_is_banned'),
            ]);
        }

        if (Auth::attempt([
            'email' => $email,
            'password' => $password,
        ], $remember)) {
            /**
             * @var User $user
             */
            $user = Auth::user();

            do_action('login.success', $user);

            return $this->success([
                'message' => trans('cms::app.login_successfully'),
                'redirect' => $user->isAdmin() ? route('admin.dashboard') : '/',
            ]);
        }

        do_action('login.failed');

        return $this->error([
            'message' => trans('cms::message.login_form.login_failed'),
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->to('/');
    }
}
