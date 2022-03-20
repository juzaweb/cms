<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Facades\Storage;
use Juzaweb\Models\Model;

class MediaFile extends Model
{
    protected $table = 'media_files';
    protected $fillable = [
        'name',
        'path',
        'extension',
        'mime_type',
        'user_id',
        'folder_id',
        'type',
        'size',
    ];

    public function delete()
    {
        Storage::disk(config('juzaweb.filemanager.disk'))->delete($this->path);

        return parent::delete();
    }

    public function isImage()
    {
        return in_array(
            $this->mime_type,
            config('juzaweb.filemanager.types.image.valid_mime')
        );
    }
}
