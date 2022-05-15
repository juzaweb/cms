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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Juzaweb\Backend\Events\RegisterSuccessful;
use Juzaweb\CMS\Http\Requests\Auth\RegisterRequest;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\ResponseMessage;

trait AuthRegisterForm
{
    use ResponseMessage;

    public function index(): View
    {
        if (! get_config('users_can_register', 1)) {
            return abort(403, trans('cms::message.register-form.register-closed'));
        }

        do_action('register.index');

        do_action('recaptcha.init');

        return view(
            $this->getViewForm(),
            [
                'title' => trans('cms::app.sign_up'),
            ]
        );
    }

    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        do_action('register.handle', $request);

        if (! get_config('users_can_register', 1)) {
            return $this->error(trans('cms::message.register-form.register-closed'));
        }

        // Create user
        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');

        DB::beginTransaction();
        try {
            $user = new User();
            $user->fill(
                [
                    'name' => $name,
                    'email' => $email,
                ]
            );
            $user->setAttribute('password', Hash::make($password));
            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        event(new RegisterSuccessful($user));

        do_action('register.success', $user);

        if (get_config('user_verification')) {
            return $this->success(
                [
                    'redirect' => route('register'),
                    'message' => trans('cms::app.registered_success_verify'),
                ]
            );
        }

        return $this->success(
            [
                'redirect' => route('login'),
                'message' => trans('cms::app.registered_success'),
            ]
        );
    }

    public function verification($email, $token): RedirectResponse
    {
        $user = User::whereEmail($email)
            ->where('verification_token', '=', $token)
            ->first();

        if ($user) {
            DB::beginTransaction();
            try {
                $user->update(
                    [
                        'status' => 'active',
                        'verification_token' => null,
                    ]
                );

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }

            return redirect()->route('login');
        }

        return abort(404);
    }

    protected function getViewForm(): string
    {
        return 'cms::auth.register';
    }
}
