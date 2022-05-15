<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;

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

        if (is_string($callback[0])) {
            return app($callback[0])->{$callback[1]}($request);
        }

        return App::call($callback, [$request]);
    }
}
