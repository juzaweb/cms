<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Supports;

use Illuminate\Support\Collection;
use Juzaweb\Ecommerce\Models\Cart as CartModel;

interface CartInterface
{
    public function addOrUpdate(int $variantId, int $quantity) : CartModel;
    
    public function bulkUpdate(array $items) : CartModel;
    
    public function removeItem(int $variantId) : CartModel;
    
    public function getCurrentCart() : CartModel;
    
    public function remove() : bool;
    
    public function getCartItems() : Collection;
}
