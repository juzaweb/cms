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

use Juzaweb\CMS\Models\Model;
use Juzaweb\Backend\Models\Post;

/**
 * Juzaweb\Ecommerce\Models\Variant
 *
 * @property int $id
 * @property string $title
 * @property string $price
 * @property string|null $compare_price
 * @property string|null $sku_code
 * @property string|null $barcode
 * @property array|null $images
 * @property int $product_id
 * @property-read Post $product
 * @method static \Illuminate\Database\Eloquent\Builder|Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereComparePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereSkuCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant whereTitle($value)
 * @mixin \Eloquent
 */
class Variant extends Model
{
    protected $table = 'variants';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $timestamps = false;
    public $casts = [
        'images' => 'array',
        'names' => 'array',
    ];

    public static function findByProduct($productId)
    {
        return self::where('product_id', '=', $productId)
            ->first();
    }

    public function product()
    {
        return $this->belongsTo(Post::class, 'product_id', 'id');
    }
}
