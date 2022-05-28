<?php

namespace Juzaweb\Backend\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Support\MenuCollection;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = $request->user();
        $adminPrefix = config('juzaweb.admin_prefix');
        $adminUrl = url($adminPrefix);
        $menuItems = $this->buildMenuItems($adminPrefix, $adminUrl);

        return array_merge(
            parent::share($request),
            [
                'auth' => $user ? [
                    'user' => $user ? [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->getAvatar(),
                        'totalNotifications' => $user->unreadNotifications()->count(['id']),
                        'notifications' => $user->unreadNotifications()
                            ->orderBy('id', 'DESC')
                            ->limit(5)
                            ->get(['id', 'data', 'created_at'])
                    ] : null,
                ] : null,
                'flash' => function () use ($request) {
                    return [
                        'success' => $request->session()->get('success'),
                        'error' => $request->session()->get('error'),
                    ];
                },
                'adminPrefix' => $adminPrefix,
                'adminUrl' => $adminUrl,
                'menuItems' => $menuItems,
            ]
        );
    }

    protected function buildMenuItems(string $adminPrefix, string $adminUrl): array
    {
        global $jw_user;

        $menuItems = [];
        $items = MenuCollection::make(HookAction::getAdminMenu());
        foreach ($items as $item) {
            if ($item->get('key') != 'dashboard' && !$jw_user->can($item->get('key'))) {
                continue;
            }

            $menuItems[] = $this->buildMenuItem($adminPrefix, $adminUrl, $item);
        }

        return $menuItems;
    }

    protected function buildMenuItem(string $adminPrefix, string $adminUrl, $item): array
    {
        $submenu = is_array($item) ? $item : $item->toArray();
        $url = ($submenu['url'] ?? '');
        $submenu['url'] = $url == 'dashboard' ? "/{$adminPrefix}" : "/{$adminPrefix}/{$url}";

        if ($submenu['children'] ?? []) {
            $children = [];

            foreach ($submenu['children'] as $child) {
                $children[] = $this->buildMenuItem(
                    $adminPrefix,
                    $adminUrl,
                    $child
                );
            }

            $submenu['children'] = $children;
        }
        return $submenu;
    }
}
