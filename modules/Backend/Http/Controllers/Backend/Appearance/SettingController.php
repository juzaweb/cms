<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Appearance;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Http\Controllers\BackendController;

class SettingController extends BackendController
{
    public function __construct(
        protected LocalThemeRepositoryContract $themeRepository,
        protected HookActionContract $hookAction
    ) {
        //
    }

    public function index(): View
    {
        $fnParseToField = function ($item) {
            $item['type'] = $item['data']['type'] ?? 'text';
            return $item;
        };

        $title = trans('cms::app.setting');
        $configs = $this->hookAction->getThemeSettings()
            ->map($fnParseToField)
            ->values()
            ->toArray();

        return view(
            'cms::backend.appearance.setting.index',
            compact('title', 'configs')
        );
    }

    public function save(Request $request): JsonResponse|RedirectResponse
    {
        $configs = $request->post('config', []);
        $themeConfigs = $request->post('theme', []);

        foreach ($configs as $name => $value) {
            set_config($name, $value);
        }

        foreach ($themeConfigs as $name => $value) {
            set_theme_config($name, $value);
        }

        return $this->success(
            trans('cms::app.updated_successfully')
        );
    }
}
