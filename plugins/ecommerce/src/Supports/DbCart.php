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

use Illuminate\Support\Arr;
use Juzaweb\Ecommerce\Models\Cart;
use Juzaweb\Ecommerce\Models\ProductVariant;
use Illuminate\Support\Facades\Cookie;

class DbCart implements CartInterface
{
    public function addOrUpdate(int $variantId, int $quantity) : Cart
    {
        $cart = $this->getCurrentCart();
        $variant = ProductVariant::find($variantId);
        if ($variant) {
            return $cart;
        }
        
        $cart->items[$variantId] = [
            'variant_id' => $variantId,
            'quantity' => $quantity,
        ];
        
        $cart->save();
        return $cart;
    }
    
    public function bulkUpdate(array $items) : Cart
    {
        $cart = $this->getCurrentCart();
        $variantIds = collect($items)->pluck('variant_id')->toArray();
        $variants = ProductVariant::whereIn('id', $variantIds)->get()->keyBy('id');
        
        foreach ($items as $item) {
            $variant = $variants->get($item['variant_id']);
            if (empty($variant)) {
                continue;
            }
            
            $cart->items[$variant->id] = Arr::only(
                $item,
                [
                    'variant_id',
                    'quantity',
                ]
            );
        }
        
        $cart->save();
        return $cart;
    }
    
    public function removeItem(int $variantId) : Cart
    {
        $cart = $this->getCurrentCart();
        unset($cart->items[$variantId]);
        $cart->save();
        return $cart;
    }
    
    public function remove(): bool
    {
        $cart = $this->getCurrentCart();
        Cookie::forget('jw_cart');
        $cart->delete();
        return true;
    }
    
    public function getCurrentCart() : Cart
    {
        $cartCode = Cookie::get('jw_cart');
        $cart = Cart::firstOrNew(['code' => $cartCode]);
        $cart->load('user');
        return $cart;
    }
}
