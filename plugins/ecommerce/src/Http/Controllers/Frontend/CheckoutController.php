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
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Omnipay\Omnipay;

class CheckoutController extends FrontendController
{
    public function checkout(Request $request)
    {
        //
    }
    
    public function payment()
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->initialize(
            [
                'clientId' => '',
                'secret'   => '-5FGEptuLX1b8vFfNdc3_',
                'testMode' => true,
            ]
        );
    
        $response = $gateway->purchase(
            [
                'amount' => '10.00',
                'currency' => 'USD',
                'cancelUrl' => route('home'),
                'returnUrl' => route('home'),
            ]
        )->send();
        
        if ($response->isRedirect()) {
            $response->redirect();
        }
        dd($response->getMessage());
        return redirect()->back()->with(
            [
                'message' => $response->getMessage(),
            ]
        );
    }
}
