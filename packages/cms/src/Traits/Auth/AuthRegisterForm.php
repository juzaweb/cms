<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Juzaweb\Backend\Events\RegisterSuccessful;
use Juzaweb\Facades\Site;
use Juzaweb\Models\User;
use Juzaweb\Traits\ResponseMessage;

trait AuthRegisterForm
{
    use ResponseMessage;

    public function index()
    {
        if (! get_config('users_can_register', 1)) {
            return abort(403, trans('cms::message.register-form.register-closed'));
        }

        do_action('register.index');

        do_action('recaptcha.init');

        return view('cms::auth.register', [
            'title' => trans('cms::app.sign_up'),
        ]);
    }

    public function register(Request $request)
    {
        do_action('register.handle', $request);

        if (! get_config('users_can_register', 1)) {
            return $this->error(trans('cms::message.register-form.register-closed'));
        }

        global $site;

        // Validate register
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')->where(function ($q) use ($request, $site) {
                    return $q->where('email', $request->input('email'))
                        ->where('site_id', $site->id);
                })
            ],
            'password' => 'required|min:6|max:32|confirmed',
        ]);

        // Create user
        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        event(new RegisterSuccessful($user));

        do_action('register.success', $user);

        if (get_config('user_verification')) {
            return $this->success([
                'redirect' => route('register'),
                'message' => trans('cms::app.registered_success_verify'),
            ]);
        }

        return $this->success([
            'redirect' => route('login'),
            'message' => trans('cms::app.registered_success'),
        ]);
    }

    public function verification($email, $token)
    {
        $user = User::whereEmail($email)
            ->where('verification_token', '=', $token)
            ->first();

        if ($user) {
            DB::beginTransaction();
            try {
                $user->update([
                    'status' => 'active',
                    'verification_token' => null,
                ]);

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }

            return redirect()->route('login');
        }

        return abort(404);
    }
}
