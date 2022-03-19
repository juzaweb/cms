<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tool\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Facades\Site;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Tool\Jobs\ImportBlogger;

class ImportController extends BackendController
{
    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);

        global $jw_user, $site;

        $file = $request->input('file');

        dispatch(new ImportBlogger($file, $jw_user->id, $site->id));

        return $this->success([
            'message' => 'Import in process'
        ]);
    }
}
