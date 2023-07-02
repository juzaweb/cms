<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\MediaFolder
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int|null $folder_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|MediaFolder[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\MediaFile[] $files
 * @property-read int|null $files_count
 * @property-read MediaFolder|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder whereUpdatedAt($value)
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|MediaFolder whereSiteId($value)
 * @mixin \Eloquent
 */
class MediaFolder extends Model
{
    protected $table = 'media_folders';
    protected $fillable = [
        'name',
        'folder_id',
        'type',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(MediaFile::class, 'folder_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class, 'folder_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MediaFolder::class, 'folder_id', 'id');
    }

    public function deleteFolder(): ?bool
    {
        foreach ($this->children as $child) {
            $child->deleteFolder();
        }

        foreach ($this->files as $file) {
            $file->delete();
        }

        return $this->delete();
    }

    public static function folderExists($name, $parentId): bool
    {
        return self::where('name', '=', $name)
            ->where('folder_id', '=', $parentId)
            ->exists();
    }
}
