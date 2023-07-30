<?php

namespace Juzaweb\Frontend\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\Backend\Models\Menu;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'cms::layouts.frontend-inertia';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(
            parent::share($request),
            [
                'flash' => function () use ($request) {
                    return [
                        'success' => $request->session()->get('success'),
                        'error' => $request->session()->get('error'),
                    ];
                },
            ],
            $this->getFrontendParams($request)
        );
    }

    protected function getFrontendParams(Request $request): array
    {
        global $jw_user;

        $configs = get_configs(['title', 'description', 'icon', 'banner', 'logo']);

        $configs['logo'] = upload_url($configs['logo']);

        $user = $jw_user ? UserResource::make($jw_user)->toArray($request) : null;

        $menu = get_menu_by_theme_location('primary');
        $menu = Menu::find($menu);

        return apply_filters(
            'theme.inertia.frontend_params',
            [
                'current_theme' => jw_current_theme(),
                'config' => $configs,
                'user' => $user,
                'is_admin' => $user ? $user['is_admin'] : false,
                'auth' => (bool) $user,
                'guest' => ! $user,
            ]
        );
    }
}
