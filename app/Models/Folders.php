<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{
    protected $table = 'folders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
    
    public function childs() {
        return $this->hasMany('App\Models\Files', 'folder_id', 'id');
    }
    
    public function folder_childs() {
        return $this->hasMany('App\Models\Folders', 'folder_id', 'id');
    }
    
    public function deleteFolder() {
        foreach ($this->folder_childs as $folder_child) {
            $folder_child->deleteFolder();
        }
        
        foreach ($this->childs as $child) {
            $child->deleteFile();
        }
        
        return $this->delete();
    }
    
    public static function folderExists($folder_name, $parent_id) {
        return self::where('name', '=', $folder_name)
            ->where('folder_id', '=', $parent_id)
            ->exists();
    }
}
