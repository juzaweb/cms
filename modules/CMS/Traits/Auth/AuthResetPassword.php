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

trait AuthResetPassword
{
    public function index($email, $token): View
    {
        do_action('reset-password.index');

        $user = User::whereEmail($email)
            ->whereExists(
                function ($query) use ($email, $token) {
                    $query->select(['email'])
                        ->where('email', '=', $email)
                        ->where('token', '=', $token);
                }
            )
            ->firstOrFail();

        return view(
            $this->getViewForm(),
            [
                'user' => $user,
            ]
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

        $user = User::whereEmail($email)
            ->whereExists(
                function ($query) use ($email, $token) {
                    $query->select(['email'])
                        ->from('password_resets')
                        ->where('email', '=', $email)
                        ->where('token', '=', $token);
                }
            )
            ->firstOrFail();

        $passwordReset = PasswordReset::where('email', '=', $email)
            ->where('token', '=', $token)
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $user->update(
                [
                    'password' => Hash::make($request->post('password')),
                ]
            );

            $passwordReset->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

        return redirect()->route('user.login');
    }

    protected function getViewForm(): string
    {
        return 'cms::auth.forgot_password';
    }
}
