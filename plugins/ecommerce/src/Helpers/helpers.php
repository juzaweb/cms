<?php

use Juzaweb\Ecommerce\Http\Resources\PaymentMethodCollectionResource;
use Juzaweb\Ecommerce\Http\Resources\ProductVariantCollectionResource;
use Juzaweb\Ecommerce\Models\PaymentMethod;
use Juzaweb\Ecommerce\Supports\CartInterface;

if (!function_exists('ecom_get_cart_items')) {
    function ecom_get_cart_items() : array
    {
        /**
         * @var CartInterface $cart
         */
        $cart = app(CartInterface::class);
        
        $items = $cart->getCartItems();
        
        $data = (new ProductVariantCollectionResource($items))
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
