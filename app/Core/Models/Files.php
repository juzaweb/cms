<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Files
 *
 * @property int $id
 * @property string $name
 * @property int $type 1: images, 2: files
 * @property string $mime_type
 * @property string $path
 * @property string $extension
 * @property int $size
 * @property int|null $folder_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Files whereUserId($value)
 * @mixin \Eloquent
 */
class Files extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'path',
        'extension',
        'mime_type',
    ];
    
    public function deleteFile() {
        \Storage::disk('public')->delete($this->path);
        return $this->delete();
    }
}
