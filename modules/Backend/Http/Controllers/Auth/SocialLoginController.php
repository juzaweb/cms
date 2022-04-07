<?php

namespace Juzaweb\Backend\Http\Controllers\Auth;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Models\User;
use Juzaweb\Backend\Models\SocialToken;
use Laravel\Socialite\Facades\Socialite;
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

        $userToken = SocialToken::where('social_id', '=', $authUser->id)
            ->first();

        DB::beginTransaction();
        try {
            if ($userToken) {
                $user = $userToken->user;

                $userToken->update(
                    [
                        'social_token' => $authUser->token,
                        'social_refresh_token' => $authUser->refreshToken,
                    ]
                );
            } else {
                $user = User::create(
                    [
                        'name' => $authUser->name,
                        'email' => $authUser->email,
                    ]
                );

                SocialToken::create(
                    [
                        'user_id' => $user->id,
                        'social_id' => $authUser->id,
                        'social_token' => $authUser->token,
                        'social_refresh_token' => $authUser->refreshToken,
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Auth::login($user);

        return redirect()->to('/');
    }

    /**
     * Create an instance of the specified driver.
     *
     * @param string $method
     * @return \Laravel\Socialite\Two\AbstractProvider
     */
    protected function getProvider($method)
    {
        $config = $this->getConfig($method);
        $provider = null;

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

    protected function getConfig($method)
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
                'auth.socialites.redirect',
                [$method]
            ),
        ];
    }
}
