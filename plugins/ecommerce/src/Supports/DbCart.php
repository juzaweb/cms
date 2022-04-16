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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juzaweb\Ecommerce\Models\Cart;
use Juzaweb\Ecommerce\Models\ProductVariant;
use Illuminate\Support\Facades\Cookie;

class DbCart implements CartInterface
{
    public function addOrUpdate(int $variantId, int $quantity) : Cart
    {
        $cart = $this->getCurrentCart();
        $variant = ProductVariant::find($variantId);
        if (empty($variant)) {
            return $cart;
        }
        
        $items = $cart->items;
        $items[$variantId] = [
            'variant_id' => $variantId,
            'quantity' => $quantity,
        ];
        
        $cart->items = $items;
        $cart->save();
        return $cart;
    }
    
    public function bulkUpdate(array $items) : Cart
    {
        $cart = $this->getCurrentCart();
        $variantIds = collect($items)->pluck('variant_id')->toArray();
        $variants = ProductVariant::whereIn('id', $variantIds)
            ->get()
            ->keyBy('id');
    
        $items = $cart->items;
        foreach ($items as $item) {
            $variant = $variants->get($item['variant_id']);
            if (empty($variant)) {
                continue;
            }
    
            $items[$variant->id] = Arr::only(
                $item,
                [
                    'variant_id',
                    'quantity',
                ]
            );
        }
    
        $cart->items = $items;
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
        Cookie::queue(Cookie::forget('jw_cart'));
        $cart->delete();
        return true;
    }
    
    public function getCurrentCart() : Cart
    {
        global $jw_user;
        
        $cartCode = Cookie::get('jw_cart');
        $cart = Cart::firstOrNew(['code' => $cartCode]);
        if (empty($cart->code)) {
            $cart->code = Str::uuid()->toString();
        }
        
        if ($jw_user) {
            $cart->user_id = $jw_user->id;
        }
        
        return $cart;
    }
    
    public function getCartItems() : Collection
    {
        $cart = $this->getCurrentCart();
        $variantIds = collect($cart->items)
            ->pluck('variant_id')
            ->toArray();
        
        $variants = ProductVariant::with(['product'])
            ->whereIn('id', $variantIds)
            ->get()
            ->map(
                function ($item) use ($cart) {
                    $item->quantity = $cart->items[$item->id]['quantity'];
                    $item->line_price = $item->price * $item->quantity;
                    return $item;
                }
            );
        
        return $variants;
    }
}
