<?php

namespace Juzaweb\Permission\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;

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
