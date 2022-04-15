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

use Illuminate\Support\Facades\DB;
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
    
        DB::beginTransaction();
        try {
            $cart = $cart->addOrUpdate($variantId, $quantity);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return $this->error(
                [
                    'message' => $e->getMessage(),
                ]
            );
        }
        
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
        
        DB::beginTransaction();
        try {
            $cart = $cart->remove($variantId);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return $this->error(
                [
                    'message' => $e->getMessage(),
                ]
            );
        }
    
        return $this->success(
            [
                'message' => __('Remove item cart successfully.'),
                'cart' => $cart,
            ]
        );
    }
    
    public function bulkUpdate(Request $request, CartInterface $cart)
    {
        $items = (array) $request->input('items');
        $cart = $cart->bulkUpdate($items);
        
        return $this->success(
            [
                'message' => __('Add to cart successfully.'),
                'cart' => $cart,
            ]
        );
    }
}
