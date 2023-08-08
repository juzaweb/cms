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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\PasswordReset;
use Juzaweb\CMS\Http\Requests\Auth\ForgotPasswordRequest;
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

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse|RedirectResponse
    {
        do_action('forgot-password.handle', $request);

        $email = $request->post('email');
        $user = User::whereEmail($email)
            ->where('status', '=', 'active')
            ->first();

        $passwordReset = PasswordReset::whereEmail($email)->first();
        if ($passwordReset) {
            if ($passwordReset->created_at < now()->subHour()) {
                $this->sendPasswordResetEmail($email, $user, $passwordReset->token);
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

            $this->sendPasswordResetEmail($email, $user, $resetToken);

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

    protected function sendPasswordResetEmail($email, $user, $resetToken): void
    {
        Email::make()
            ->withTemplate('forgot_password')
            ->setEmails([$email])
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
    }

    protected function getViewForm(): string
    {
        return 'cms::auth.forgot_password';
    }
}
