<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Models;

use Juzaweb\Models\Model;

/**
 * Juzaweb\Ecommerce\Models\VariantName
 *
 * @property int $id
 * @property string $name
 * @property int|null $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Ecommerce\Models\VariantNameItem[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName query()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantName whereUpdatedAt($value)
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
