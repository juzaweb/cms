<?php

namespace Juzaweb\Crawler\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Crawler\Models\CrawComponentReplace
 *
 * @property int $id
 * @property int $component_id
 * @property string $find
 * @property string $replace
 * @property int $type 1: str_replace, 2: preg_replace
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace whereComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace whereFind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace whereReplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentReplace whereType($value)
 * @mixin \Eloquent
 */
class ComponentReplace extends Model
{
    protected $table = 'crawler_component_replaces';
    protected $fillable = [
        'component_id',
        'find',
        'replace',
        'type',
    ];
    
    public $timestamps = false;
}
