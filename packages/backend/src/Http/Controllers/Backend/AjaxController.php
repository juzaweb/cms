<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Backend\Facades\HookAction;

class AjaxController extends BackendController
{
    public function handle(Request $request, $slug)
    {
        $ajax = HookAction::getAdminAjaxs($slug);
        if (empty($ajax)) {
            return abort(404);
        }

        if ($request->method() != strtoupper($ajax->get('method'))) {
            return abort(403);
        }

        $callback = $ajax->get('callback');

        return app($callback[0])->{$callback[1]}($request);
    }
}
