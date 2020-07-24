<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Folders
 *
 * @property int $id
 * @property string $name
 * @property int|null $folder_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Folders whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Folders extends Model
{
    protected $table = 'folders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
    
    public static function folderExists($folder_name, $parent_id) {
        return self::where('name', '=', $folder_name)
            ->where('folder_id', '=', $parent_id)
            ->exists();
    }
}
