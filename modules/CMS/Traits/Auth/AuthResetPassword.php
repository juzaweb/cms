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

    public function resetPassword($email, $token, Request $request): JsonResponse|RedirectResponse
    {
        do_action('auth.reset-password.handle');

        $request->validate(
            [
                'password' => 'required|string|min:6|max:32|confirmed',
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
                'message' => trans('cms::app.change_password_successfully'),
            ]
        );
    }

    protected function getViewForm(): string
    {
        return 'cms::auth.reset_password';
    }
}
