<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Ecommerce\Models\VariantName
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Ecommerce\Models\VariantNameItem[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName query()
 * @mixin \Eloquent
 */
class VariantName extends Model
{
    protected $table = 'variant_names';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function items()
    {
        return $this->hasMany(VariantNameItem::class, 'variant_name_id', 'id');
    }
}
