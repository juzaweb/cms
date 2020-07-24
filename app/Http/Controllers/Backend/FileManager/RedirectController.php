<?php

namespace App\Http\Controllers\Backend\Filemanager;

use Illuminate\Support\Facades\Storage;

class RedirectController extends LfmController
{
    public function showFile($file_path)
    {
        $storage = Storage::disk('uploads');

        if (!$storage->exists($file_path)) {
            abort(404);
        }

        return response($storage->get($file_path))
            ->header('Content-Type', $storage->mimeType($file_path));
    }
}
