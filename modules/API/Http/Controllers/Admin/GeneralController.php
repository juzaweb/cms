<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\ApiController;

class GeneralController extends ApiController
{
    public function callAction($method, $parameters)
    {
        do_action(Action::BACKEND_CALL_ACTION, $method, $parameters);

        do_action(Action::BACKEND_INIT);

        return parent::callAction($method, $parameters);
    }

    public function adminMenu(Request $request): JsonResponse
    {
        $items = $this->mapMenuItems(HookAction::getAdminMenu());

        return $this->restSuccess($items);
    }

    private function mapMenuItems(array $items): array
    {
        return collect($items)
            ->sortBy('position')
            ->map(
                function ($item, $key) {
                    $data = $this->mapMenuItem($key, $item);
                    if ($children = Arr::get($item, 'children')) {
                        $data['children'] = $this->mapMenuItems($children);
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
