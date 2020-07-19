<?php

namespace App\Http\Controllers\Backend\Filemanager;

class DownloadController extends LfmController
{
    public function getDownload()
    {
        return response()->download($this->lfm->setName(request('file'))->path('absolute'));
    }
}
