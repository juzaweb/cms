<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\JuzawebApi;

class ThemeInstallController extends BackendController
{
    public function index(): View
    {
        if (!config('juzaweb.theme.enable_upload')) {
            abort(403, 'Access deny.');
        }

        $title = trans('cms::app.install');

        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.themes'),
                'url' => route('admin.themes')
            ]
        );

        return view(
            'cms::backend.theme.install',
            compact('title')
        );
    }

    public function getData(Request $request, JuzawebApi $api): object|array
    {
        if (!config('juzaweb.theme.enable_upload')) {
            return (object) [];
        }

        $limit = $request->get('limit', 20);
        $page = $request->get('page', 1);
        $except = array_keys(ThemeLoader::all(true));

        return $api->get(
            'themes',
            [
                'limit' => $limit,
                'page' => $page,
                'except' => $except
            ]
        );
    }

    public function upload(Request $request)
    {
        //
    }
}
