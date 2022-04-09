<?php

namespace Juzaweb\Crawler\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Crawler\Models\CrawComponent
 *
 * @property int $id
 * @property string $code
 * @property string $element
 * @property int $template_id
 * @method static \Illuminate\Database\Eloquent\Builder|Component newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Component newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Component query()
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereElement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereTemplateId($value)
 * @mixin \Eloquent
 * @property string|null $attr
 * @property int|null $index
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereIndex($value)
 * @property int $trans
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereTrans($value)
 * @property int $to_bbcode
 * @method static \Illuminate\Database\Eloquent\Builder|Component whereToBbcode($value)
 */
class Component extends Model
{
    protected $table = 'crawler_components';
    protected $fillable = [
        'code',
        'element',
        'attr',
        'index'
    ];
    
    public $timestamps = false;
}
