<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Http\Requests\Auth\LoginRequest;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\ResponseMessage;

trait AuthLoginForm
{
    use ResponseMessage;

    public function index(): View
    {
        do_action('login.index');

        do_action('recaptcha.init');

        $socialites = get_config('socialites', []);

        return view(
            $this->getViewForm(),
            [
                'title' => trans('cms::app.login'),
                'socialites' => $socialites
            ]
        );
    }

    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        // Login handle action
        do_action('login.handle', $request);

        $email = $request->post('email');
        $password = $request->post('password');
        $remember = filter_var(
            $request->post('remember', 1),
            FILTER_VALIDATE_BOOLEAN
        );

        $user = User::whereEmail($email)->first(['status', 'is_admin']);

        if (empty($user)) {
            return $this->error(
                [
                    'message' => trans('cms::message.login_form.login_failed'),
                ]
            );
        }

        if ($user->status != 'active') {
            if ($user->status == 'verification') {
                return $this->error(
                    [
                        'message' => trans('cms::message.login_form.verification'),
                    ]
                );
            }

            return $this->error(
                [
                    'message' => trans('cms::message.login_form.user_is_banned'),
                ]
            );
        }

        if (Auth::attempt(
            [
                'email' => $email,
                'password' => $password,
            ],
            $remember
        )
        ) {
            /**
             * @var User $user
             */
            $user = Auth::user();

            do_action('login.success', $user);

            return $this->success(
                [
                    'message' => trans('cms::app.login_successfully'),
                    'redirect' => $user->hasPermission() ? route('admin.dashboard') : '/',
                ]
            );
        }

        do_action('login.failed');

        return $this->error(
            [
                'message' => trans('cms::message.login_form.login_failed'),
            ]
        );
    }

    public function logout(): RedirectResponse
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->to('/');
    }

    protected function getViewForm(): string
    {
        return 'cms::auth.login';
    }
}
