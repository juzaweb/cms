<?php

namespace Juzaweb\CMS\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * Juzaweb\Multisite\Models\Translation
 *
 * @property int $id
 * @property int $status
 * @property string $locale
 * @property string $group
 * @property string $namespace
 * @property string $key
 * @property string|null $value
 * @method static Builder|Translation newModelQuery()
 * @method static Builder|Translation newQuery()
 * @method static Builder|Translation ofTranslatedGroup($group)
 * @method static Builder|Translation orderByGroupKeys($ordered)
 * @method static Builder|Translation query()
 * @method static Builder|Translation selectDistinctGroup()
 * @method static Builder|Translation whereActive()
 * @method static Builder|Translation whereGroup($value)
 * @method static Builder|Translation whereId($value)
 * @method static Builder|Translation whereKey($value)
 * @method static Builder|Translation whereLocale($value)
 * @method static Builder|Translation whereNamespace($value)
 * @method static Builder|Translation whereStatus($value)
 * @method static Builder|Translation whereValue($value)
 * @mixin \Eloquent
 * @property string $object_type
 * @property string $object_key
 * @method static Builder|Translation whereObjectKey($value)
 * @method static Builder|Translation whereObjectType($value)
 */
class Translation extends Model
{
    public const STATUS_SAVED = 0;
    public const STATUS_CHANGED = 1;

    public $timestamps = false;
    protected $table = 'jw_translations';

    protected $guarded = [
        'id'
    ];

    public function scopeOfTranslatedGroup(Builder $query, $group): Builder
    {
        return $query->where('group', $group)->whereNotNull('value');
    }

    public function scopeOrderByGroupKeys(Builder $query, $ordered): Builder
    {
        if ($ordered) {
            $query->orderBy('group')->orderBy('key');
        }

        return $query;
    }

    public function scopeSelectDistinctGroup(Builder $query): Builder
    {
        $select = match (DB::getDriverName()) {
            'mysql' => 'DISTINCT `group`',
            default => 'DISTINCT "group"',
        };

        return $query->select(DB::raw($select));
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder->where('status', '=', 1);
    }
}
