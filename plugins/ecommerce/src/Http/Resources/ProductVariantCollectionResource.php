<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductVariantCollectionResource extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(
            function ($item) {
                return array_only(
                    $item->toArray(),
                    [
                        'sku_code',
                        'barcode',
                        'title',
                        'thumbnail',
                        'description',
                        'names',
                        'images',
                        'price',
                        'compare_price',
                        'stock',
                        'type',
                    ]
                );
            }
        )->toArray();
    }
}
