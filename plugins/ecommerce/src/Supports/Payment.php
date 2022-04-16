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

use Juzaweb\Ecommerce\Models\PaymentMethod;
use Juzaweb\Ecommerce\Supports\Paymemts\Paypal;
use Juzaweb\Ecommerce\Supports\Payments\Cod;

class Payment
{
    public static function make(PaymentMethod $paymentMethod) : PaymentMethodInterface
    {
        switch ($paymentMethod->type) {
            case 'paypal':
                return new Paypal($paymentMethod);
        }
        
        return new Cod($paymentMethod);
    }
}
