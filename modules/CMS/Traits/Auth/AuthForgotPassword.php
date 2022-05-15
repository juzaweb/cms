<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
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
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\PasswordReset;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\Email;
use Juzaweb\CMS\Traits\ResponseMessage;

trait AuthForgotPassword
{
    use ResponseMessage;

    public function index(): View
    {
        do_action('forgot-password.index');

        return view(
            $this->getViewForm(),
            [
                'title' => trans('cms::app.forgot_password'),
            ]
        );
    }

    public function forgotPassword(Request $request): JsonResponse|RedirectResponse
    {
        do_action('forgot-password.handle', $request);

        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.exists' => trans('cms::app.email_does_not_exists')
            ]
        );

        $email = $request->post('email');
        $user = User::whereEmail($email)
            ->where('status', '=', 'active')
            ->first();

        $passwordReset = PasswordReset::whereEmail($email)->first();
        if ($passwordReset) {
            if ($passwordReset->created_at < now()->subHour()) {
                Email::make()
                    ->withTemplate('forgot_password')
                    ->setEmails([$request->post('email')])
                    ->setParams(
                        [
                            'name' => $user->name,
                            'email' => $email,
                            'token' => $passwordReset->token,
                            'url' => route(
                                'reset_password',
                                [
                                    'email' => $email,
                                    'token' => $passwordReset->token,
                                ]
                            ),
                        ]
                    )
                    ->send();
            }

            return $this->success(
                [
                    'message' => trans('cms::app.send_email_successfully'),
                    'redirect' => route('forgot_password')
                ]
            );
        }

        DB::beginTransaction();
        try {
            $resetToken = Str::random(32);
            PasswordReset::create(
                [
                    'email' => $email,
                    'token' => $resetToken,
                ]
            );

            Email::make()
                ->withTemplate('forgot_password')
                ->setEmails([$request->post('email')])
                ->setParams(
                    [
                        'name' => $user->name,
                        'email' => $email,
                        'token' => $resetToken,
                        'url' => route(
                            'reset_password',
                            [
                                'email' => $email,
                                'token' => $resetToken,
                            ]
                        ),
                    ]
                )
                ->send();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'message' => trans('cms::app.send_email_successfully'),
                'redirect' => route('forgot_password')
            ]
        );
    }

    protected function getViewForm(): string
    {
        return 'cms::auth.forgot_password';
    }
}
