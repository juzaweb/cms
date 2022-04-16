<?php

return [
    /**
     * Cart Helper class support
     */
    'cart' => \Juzaweb\Ecommerce\Supports\DbCart::class,
    
    /**
     * Order Helper class support
     */
    'order' => \Juzaweb\Ecommerce\Supports\DbOrder::class,
    
    /**
     * Payment method supported
     */
    'payment_methods' => [
        'cod' => 'Cash on delivery',
        'paypal' => 'Paypal',
        'custom' => 'Custom',
    ],
];
