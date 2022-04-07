<?php

namespace Juzaweb\Ecommerce\Http\Controllers\Backend;

use Juzaweb\CMS\Http\Controllers\BackendController;

class SettingController extends BackendController
{
    public function index()
    {
        $title = trans('ecom::content.setting');

        return view('ecom::backend.setting.index', compact(
            'title'
        ));
    }
}
