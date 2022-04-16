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

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'price',
        'compare_price',
        'sku_code',
        'barcode',
    ];
}
