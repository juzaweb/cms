<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\Folder
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int|null $folder_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mymo\Core\Models\Files[] $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mymo\Core\Models\Folder[] $folder_childs
 * @property-read int|null $folder_childs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Folder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Folder extends Model
{
    protected $table = 'folders';
    protected $fillable = [
        'name'
    ];
    
    public function childs() {
        return $this->hasMany('Mymo\Core\Models\Files', 'folder_id', 'id');
    }
    
    public function folder_childs() {
        return $this->hasMany('Mymo\Core\Models\Folder', 'folder_id', 'id');
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
