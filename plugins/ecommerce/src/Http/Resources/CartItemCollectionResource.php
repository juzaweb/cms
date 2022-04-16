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

class CartItemCollectionResource extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(
            function ($item) {
                return [
                    'sku_code' => $item->sku_code,
                    'barcode' => $item->barcode,
                    'title' => $item->title,
                    'thumbnail' => upload_url($item->thumbnail),
                    'description' => $item->description,
                    'names' => $item->names,
                    'images' => $item->images,
                    'price' => $item->price,
                    'compare_price' => $item->compare_price,
                    'stock' => $item->stock,
                    'type' => $item->type,
                    'line_price' => $item->line_price,
                    'quantity' => $item->quantity,
                ];
            }
        )->toArray();
    }
}
