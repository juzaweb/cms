<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Traits\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Juzaweb\Backend\Models\PasswordReset;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\ResponseMessage;

trait AuthResetPassword
{
    use ResponseMessage;

    public function index($email, $token): View
    {
        do_action('reset-password.index');

        $passwordReset = PasswordReset::where(['email' => $email, 'token' => $token])
            ->firstOrFail();

        $title = trans('cms::app.reset_password');

        return view(
            $this->getViewForm(),
            compact('email', 'token', 'passwordReset', 'title')
        );
    }

    public function resetPassword($email, $token, Request $request): RedirectResponse
    {
        do_action('auth.reset-password.handle');

        $request->validate(
            [
                'password' => 'required|string|min:6|max:32',
                'password_confirmation' => 'required|string|max:32|min:6',
            ]
        );

        $passwordReset = PasswordReset::where(['email' => $email, 'token' => $token])
            ->firstOrFail();

        $user = User::whereEmail($passwordReset->email)->firstOrFail();

        DB::beginTransaction();
        try {
            $user->update(
                [
                    'password' => Hash::make($request->post('password')),
                ]
            );

            $passwordReset->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'redirect' => route('login'),
            ]
        );
    }

    protected function getViewForm(): string
    {
        return 'cms::auth.reset_password';
    }
}
