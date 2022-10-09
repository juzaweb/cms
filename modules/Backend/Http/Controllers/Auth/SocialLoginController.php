<?php

namespace Juzaweb\Backend\Http\Controllers\Auth;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Juzaweb\Backend\Events\RegisterSuccessful;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Models\User;
use Juzaweb\Backend\Models\SocialToken;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\FacebookProvider;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\GithubProvider;
use Laravel\Socialite\Two\LinkedInProvider;
use Laravel\Socialite\One\TwitterProvider;

class SocialLoginController extends FrontendController
{
    public function redirect($method)
    {
        $config = $this->getConfig($method);

        return Socialite::buildProvider(
            FacebookProvider::class,
            $config
        )->redirect();
    }

    public function callback($method)
    {
        $authUser = $this->getProvider($method)->user();

        $register = false;
        DB::beginTransaction();
        try {
            $user = $this->updateOrCreateUser($authUser, $method, $register);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($register) {
            event(new RegisterSuccessful($user));
        }

        Auth::login($user, true);

        return redirect()->to('/');
    }

    protected function updateOrCreateUser($authUser, string $method, &$register)
    {
        $userToken = SocialToken::where('social_provider', '=', $method)
            ->where('social_id', '=', $authUser->id)
            ->first();

        if ($userToken) {
            $userToken->update(
                [
                    'social_token' => $authUser->token,
                    'social_refresh_token' => $authUser->refreshToken,
                ]
            );

            return $userToken->user;
        }

        $password = Str::random();

        $user = User::whereEmail($authUser->email)->first();
        if ($user) {
            $this->updateSocialToken($user, $authUser, $method);

            return $user;
        }

        $register = true;

        $user = new User();

        $user->fill(
            [
                'name' => $authUser->name,
                'email' => $authUser->email,
            ]
        );

        $user->setAttribute('password', Hash::make($password));

        $user->save();

        $this->updateSocialToken($user, $authUser, $method);

        return $user;
    }

    protected function updateSocialToken($user, $authUser, $method): SocialToken
    {
        return $user->socialTokens()->updateOrCreate(
            [
                'social_id' => $authUser->id,
                'social_provider' => $method,
            ],
            [
                'social_token' => $authUser->token,
                'social_refresh_token' => $authUser->refreshToken,
            ]
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @param string $method
     * @return AbstractProvider
     */
    protected function getProvider(string $method): AbstractProvider
    {
        $config = $this->getConfig($method);

        switch ($method) {
            case 'facebook':
                $provider = FacebookProvider::class;
                break;
            case 'google':
                $provider = GoogleProvider::class;
                break;
            case 'twitter':
                $provider = TwitterProvider::class;
                break;
            case 'linkedin':
                $provider = LinkedInProvider::class;
                break;
            case 'github':
                $provider = GithubProvider::class;
                break;
        }

        if (empty($provider)) {
            return abort(404);
        }

        return Socialite::buildProvider(
            FacebookProvider::class,
            $config
        );
    }

    protected function getConfig($method): array
    {
        $config = Arr::get(get_config('socialites', []), $method);

        if (empty($config['client_id'])
            || empty($config['client_secret'])
            || empty($config['enable'])
        ) {
            return abort(404);
        }

        return [
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'redirect' => route(
                'auth.socialites.callback',
                [$method]
            ),
        ];
    }
}
