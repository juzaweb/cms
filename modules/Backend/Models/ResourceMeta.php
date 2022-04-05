<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Models;

use Juzaweb\Models\Model;

/**
 * Juzaweb\Backend\Models\ResourceMeta
 *
 * @property int $id
 * @property int $resource_id
 * @property string $meta_key
 * @property string|null $meta_value
 * @property-read \Juzaweb\Backend\Models\Resource $resource
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceMeta whereResourceId($value)
 * @mixin \Eloquent
 */
class ResourceMeta extends Model
{
    public $timestamps = false;

    protected $table = 'resource_metas';
    protected $fillable = [
        'meta_key',
        'meta_value',
        'resource_id',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id', 'id');
    }
}
