<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Extensions;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class TwigExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'App_Extension_Ecommerce_Custom';
    }
    
    public function getFunctions()
    {
        return [
            new TwigFunction('ecom_get_cart_items', 'ecom_get_cart_items'),
            new TwigFunction('ecom_get_payment_methods', 'ecom_get_payment_methods'),
            new TwigFunction('ecom_get_cart', 'ecom_get_cart'),
        ];
    }
}
