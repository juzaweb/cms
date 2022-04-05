<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Http\Datatables\EmailLogDatatable;

class EmailLogController extends BackendController
{
    public function index()
    {
        $dataTable = new EmailLogDatatable();
        $title = trans('cms::app.email_logs');

        return view('cms::backend.logs.email', compact(
            'title',
            'dataTable'
        ));
    }
}
