<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Jobs\ImportBlogger;

class ImportController extends BackendController
{
    public function index()
    {
        $title = trans('cms::app.import');

        return view(
            'cms::backend.tool.import',
            compact('title')
        );
    }

    public function import(Request $request)
    {
        $this->validate(
            $request,
            [
                'file' => 'required'
            ]
        );

        global $jw_user;

        $file = $request->input('file');

        dispatch(new ImportBlogger($file, $jw_user->id));

        return $this->success(
            [
                'message' => 'Import in process'
            ]
        );
    }
}
