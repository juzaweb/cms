<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Supports\Paymemts;

use Juzaweb\Ecommerce\Abstracts\PaymentMethodAbstract;
use Juzaweb\Ecommerce\Supports\PaymentMethodInterface;
use Omnipay\Omnipay;

class Paypal extends PaymentMethodAbstract implements PaymentMethodInterface
{
    public function purchase(array $data): PaymentMethodInterface
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->initialize(
            [
                'clientId' => $this->paymentMethod->data['sandbox_client_id'],
                'secret'   => $this->paymentMethod->data['sandbox_secret'],
                'testMode' => true,
            ]
        );
    
        $response = $gateway->purchase($data)->send();
        dd($response->getData());
        $this->setRedirect($response->isRedirect());
        $this->redirect = $response->getData();
    
        return $this;
    }
}
