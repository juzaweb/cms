<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Abstracts;

use Juzaweb\Ecommerce\Models\PaymentMethod;

abstract class PaymentMethodAbstract
{
    protected $paymentMethod;
    protected $redirect = false;
    
    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }
    
    public function isRedirect(): bool
    {
        return $this->redirect;
    }
    
    public function redirectUrl(): string
    {
        return null;
    }
    
    public function getMessage(): string
    {
        return __('Thank you for your order.');
    }
    
    protected function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }
}
