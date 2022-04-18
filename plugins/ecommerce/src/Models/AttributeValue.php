<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Duy Hoang <hoangduy02071997@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\Ecommerce\Models\Attribute;

/**
 * Juzaweb\Ecommerce\Models\AttributeValue
 *
 * @property int $id
 * @property string $value
 * @property string $value_type
 * @property int $attribute_id
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereValueType($value)
 * @mixin \Eloquent
 * @property-read Attribute $attribute
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereId($value)
 */

class AttributeValue extends Model
{
    protected $table = 'attribute_values';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
