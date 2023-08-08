<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;

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

    public function resource(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id', 'id');
    }
}
