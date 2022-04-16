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

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Ecommerce\Http\Requests\AddToCartRequest;
use Juzaweb\Ecommerce\Http\Requests\BulkUpdateCartRequest;
use Juzaweb\Ecommerce\Http\Requests\RemoveItemCartRequest;
use Juzaweb\Ecommerce\Models\Cart;
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
        
        return $this->responseCartWithCookie(
            $cart,
            'Add to cart successfully.'
        );
    }
    
    public function removeItem(RemoveItemCartRequest $request, CartInterface $cart)
    {
        $variantId = $request->input('variant_id');
        
        DB::beginTransaction();
        try {
            $cart = $cart->removeItem($variantId);
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
    
        return $this->responseCartWithCookie(
            $cart,
            'Remove item cart successfully.'
        );
    }
    
    public function bulkUpdate(
        BulkUpdateCartRequest $request,
        CartInterface $cart
    ) {
        $items = (array) $request->input('items');
        
        DB::beginTransaction();
        try {
            $cart = $cart->bulkUpdate($items);
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
    
        return $this->responseCartWithCookie($cart, 'Add to cart successfully.');
    }
    
    public function remove(CartInterface $cart)
    {
        DB::beginTransaction();
        try {
            $cart->remove();
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
    
    public function getCartItems(CartInterface $cart)
    {
        $model = $cart->getCurrentCart();
        $items = $cart->getCartItems()
            ->map(
                function ($item) {
                    return Arr::only(
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
            );
        
        return response()->json(
            [
                'code' => $model->code,
                'items' => $items
            ]
        );
    }
    
    protected function responseCartWithCookie(Cart $cart, string $message)
    {
        $cookie = Cookie::make('jw_cart', $cart->code, 43200);
    
        return Response::make()
            ->withCookie($cookie)
            ->setContent(
                response()
                    ->json(
                        [
                            'status' => true,
                            'data' => [
                                'cart' => $cart,
                                'message' => __($message),
                            ],
                        ]
                    )
                    ->getContent()
            );
    }
}
