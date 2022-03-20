<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\Models\Model;

class MediaFolder extends Model
{
    protected $table = 'media_folders';
    protected $fillable = [
        'name',
        'folder_id',
        'type',
    ];

    public function files()
    {
        return $this->hasMany('Juzaweb\Backend\Models\MediaFile', 'folder_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(MediaFolder::class, 'folder_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(MediaFolder::class, 'folder_id', 'id');
    }

    public function deleteFolder()
    {
        foreach ($this->folder_childs as $folder_child) {
            $folder_child->deleteFolder();
        }

        foreach ($this->childs as $child) {
            $child->deleteFile();
        }

        return $this->delete();
    }

    public static function folderExists($name, $parentId)
    {
        return self::where('name', '=', $name)
            ->where('folder_id', '=', $parentId)
            ->exists();
    }
}
