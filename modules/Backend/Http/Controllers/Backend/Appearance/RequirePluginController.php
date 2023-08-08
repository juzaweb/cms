<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Appearance;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\BackendController;

class RequirePluginController extends BackendController
{
    public function index(): View
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.themes'),
                'url' => route('admin.themes'),
            ]
        );

        $title = trans('cms::app.require_plugins');

        return view(
            'cms::backend.theme.require',
            compact(
                'title'
            )
        );
    }

    public function getData(): JsonResponse
    {
        $themeInfo = ThemeLoader::getThemeInfo(jw_current_theme());
        $require = $themeInfo->get('require', []);
        $result = [];

        foreach ($require as $plugin => $ver) {
            $info = app('plugins')->find($plugin);
            if ($info) {
                if ($info->isEnabled()) {
                    continue;
                }
            }

            $result[] = [
                'id' => $plugin,
                'key' => $plugin,
                'version' => $ver,
                'status' => $info ? 'installed' : 'not_installed',
            ];
        }

        return response()->json(
            [
                'total' => count($result),
                'rows' => $result,
            ]
        );
    }
}
