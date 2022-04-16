<?php

use Juzaweb\Ecommerce\Http\Resources\CartItemCollectionResource;
use Juzaweb\Ecommerce\Http\Resources\PaymentMethodCollectionResource;
use Juzaweb\Ecommerce\Models\PaymentMethod;
use Juzaweb\Ecommerce\Supports\CartInterface;

if (!function_exists('ecom_get_cart')) {
    function ecom_get_cart() : array
    {
        /**
         * @var CartInterface $cart
         */
        $cart = app(CartInterface::class);
        $model = $cart->getCurrentCart();
        
        return [
            'code' => $model->code ?? null,
            'items' => ecom_get_cart_items($cart),
        ];
    }
}

if (!function_exists('ecom_get_cart_items')) {
    function ecom_get_cart_items(CartInterface $cart = null) : array
    {
        $cart = $cart ?: app(CartInterface::class);
        
        $items = $cart->getCartItems();
        
        $data = (new CartItemCollectionResource($items))
            ->toArray(request());
        
        return $data;
    }
}

if (!function_exists('ecom_get_payment_methods')) {
    function ecom_get_payment_methods() : array
    {
        $methods = PaymentMethod::active()->get();
    
        $data = (new PaymentMethodCollectionResource($methods))
            ->toArray(request());
    
        return $data;
    }
}
