<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Mymo\Core\Models\File
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\File whereUserId($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'name',
        'path',
        'extension',
        'mime_type',
    ];
    
    public function delete()
    {
        Storage::disk('public')->delete($this->path);
        return parent::delete();
    }

    public function isImage()
    {

    }
}
