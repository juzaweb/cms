<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Http\Controllers\Frontend;

use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Ecommerce\Http\Requests\AddToCartRequest;
use Juzaweb\Ecommerce\Http\Requests\RemoveItemCartRequest;
use Juzaweb\Ecommerce\Supports\CartInterface;

class CartController extends FrontendController
{
    public function addToCart(AddToCartRequest $request, CartInterface $cart)
    {
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity');
        
        $cart = $cart->addOrUpdate($variantId, $quantity);
        
        return $this->success(
            [
                'message' => __('Add to cart successfully.'),
                'cart' => $cart,
            ]
        );
    }
    
    public function removeItem(RemoveItemCartRequest $request, CartInterface $cart)
    {
        $variantId = $request->input('variant_id');
        $cart = $cart->remove($variantId);
    
        return $this->success(
            [
                'message' => __('Add to cart successfully.'),
                'cart' => $cart,
            ]
        );
    }
}
