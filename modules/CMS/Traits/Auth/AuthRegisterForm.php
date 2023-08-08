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
use Juzaweb\CMS\Http\Requests\Auth\RegisterRequest;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\ResponseMessage;

trait AuthRegisterForm
{
    use ResponseMessage;

    public function index(): View
    {
        if (! get_config('user_registration', 1)) {
            abort(403, trans('cms::message.register_form.register_closed'));
        }

        do_action('register.index');

        do_action('recaptcha.init');

        $socialites = get_config('socialites', []);

        return view(
            $this->getViewForm(),
            [
                'title' => trans('cms::app.sign_up'),
                'socialites' => $socialites
            ]
        );
    }

    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        if (! get_config('user_registration', 1)) {
            return $this->error(trans('cms::message.register_form.register_closed'));
        }

        $request->createUserFromRequest();

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
            ->firstOrFail();

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

    protected function getViewForm(): string
    {
        return 'cms::auth.register';
    }
}
