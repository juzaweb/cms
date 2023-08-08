<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\User;
use OpenApi\Annotations as OA;

class GeneralController extends AdminApiController
{
    /**
     * @OA\Get(
     *      path="/api/admin/menu-left",
     *      tags={"Admin / Menus"},
     *      summary="Get admin menu items",
     *      operationId="admin.menus.admin_menu",
     *      @OA\Response(response=200, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function adminMenu(Request $request): JsonResponse
    {
        $user = $request->user('api');

        $items = $this->mapMenuItems(HookAction::getAdminMenu(), $user);

        return $this->restSuccess($items);
    }

    private function mapMenuItems(array $items, User $user): array
    {
        return collect($items)
            ->sortBy('position')
            ->map(
                function ($item, $key) use ($user) {
                    if (!$user->canAny(Arr::get($item, 'permissions', ['admin']))) {
                        return [];
                    }

                    $data = $this->mapMenuItem($key, $item);

                    if ($children = Arr::get($item, 'children')) {
                        $data['children'] = $this->mapMenuItems($children, $user);
                    }

                    return $data;
                }
            )
            ->values()
            ->toArray();
    }

    private function mapMenuItem(string $key, array $item): array
    {
        return [
            'id' => $key,
            'title' => $item['title'],
            'translate' => $item['title'],
            'type' => Arr::get($item, 'children') ? 'collapse' : 'item',
            'icon' => str_replace('fa fa-', '', $item['icon']),
            'url' => "/{$item['url']}",
        ];
    }
}
