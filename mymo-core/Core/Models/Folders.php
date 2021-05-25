<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Folders
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int|null $folder_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Models\Files[] $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Models\Folders[] $folder_childs
 * @property-read int|null $folder_childs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Folders whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Folders extends Model
{
    protected $table = 'folders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
    
    public function childs() {
        return $this->hasMany('App\Core\Models\Files', 'folder_id', 'id');
    }
    
    public function folder_childs() {
        return $this->hasMany('App\Core\Models\Folders', 'folder_id', 'id');
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
