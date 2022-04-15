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

use Illuminate\Http\Request;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Ecommerce\Models\PaymentMethod;
use Omnipay\Omnipay;

class CheckoutController extends FrontendController
{
    public function checkout(Request $request)
    {
        //
        
        $paymentMethod = PaymentMethod::find(1);
        
        $response = $this->getPaymentResponse($paymentMethod);
    
        if ($response->isRedirect()) {
            $response->redirect();
        }
        
        return redirect()->to($this->getThanksPageRedirect())->with(
            [
                'message' => $response->getMessage(),
            ]
        );
    }
    
    public function cancel(Request $request)
    {
        return redirect()->to($this->getThanksPageRedirect());
    }
    
    public function completed(Request $request)
    {
        
        
        return redirect()->to($this->getThanksPageRedirect());
    }
    
    protected function getPaymentResponse(PaymentMethod $paymentMethod)
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->initialize(
            [
                'clientId' => $paymentMethod->data['sandbox_client_id'],
                'secret'   => $paymentMethod->data['sandbox_secret'],
                'testMode' => true,
            ]
        );
    
        $response = $gateway->purchase(
            [
                'amount' => '10.00',
                'currency' => 'USD',
                'cancelUrl' => route('ajax', ['payment/cancel']),
                'returnUrl' => route('home'),
            ]
        )->send();
        
        return $response;
    }
    
    protected function getThanksPageRedirect()
    {
        $thanksPage = Post::find(21);
        return $thanksPage->slug ?? '/';
    }
}
