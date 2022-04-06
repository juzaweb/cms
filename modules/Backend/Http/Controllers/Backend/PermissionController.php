<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Juzaweb\CMS\Http\Controllers\BackendController;

class PermissionController extends BackendController
{
    public function index()
    {
        //

        return view('jupe::index', [
            'title' => 'Title Page',
        ]);
    }
}
