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
use Juzaweb\Ecommerce\Models\Attribute;

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
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereComparePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereSkuCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereTitle($value)
 * @mixin \Eloquent
 */
class ProductVariant extends Model
{
    protected $table = 'product_variants';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // public $timestamps = false;
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

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'variants_attributes', 'variant_id', 'attribute_id');
    }
}
