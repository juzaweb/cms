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
 * Juzaweb\Ecommerce\Models\VariantNameItem
 *
 * @method static \Illuminate\Database\Eloquent\Builder|VariantNameItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantNameItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantNameItem query()
 * @mixin \Eloquent
 */
class VariantNameItem extends Model
{
    public $timestamps = false;

    protected $table = 'variant_name_items';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
