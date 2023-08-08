<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Juzaweb\Backend\Http\Requests\Tool\ImportRequest;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\Imports\PostImportFromXml;

class ImportController extends BackendController
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $title = trans('cms::app.import');

        return view(
            'cms::backend.tool.import',
            compact('title')
        );
    }

    public function import(ImportRequest $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        global $jw_user;

        $file = $request->input('file');

        $type = $request->input('type');

        $importer = app(PostImportFromXml::class)
            ->setUserID($jw_user->id)
            ->import($file, $type);

        $result = $importer->getCacheInfo();

        return $this->success(
            [
                'message' => $result ? __('Import in process') : __('Import successfully'),
                'next' => $result,
            ]
        );
    }
}
