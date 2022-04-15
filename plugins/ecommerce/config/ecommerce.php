<?php

return [
    /**
     * Cart Helper class support
     */
    'cart' => \Juzaweb\Ecommerce\Supports\DbCart::class,
    
    'payment_methods' => [
        'cod' => 'Cash on delivery',
        'paypal' => 'Paypal',
        'custom' => 'Custom',
    ],
];
