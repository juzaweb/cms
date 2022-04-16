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
use Juzaweb\Ecommerce\Http\Requests\CheckoutRequest;
use Juzaweb\Ecommerce\Supports\CartInterface;
use Juzaweb\Ecommerce\Supports\OrderInterface;
use Illuminate\Support\Facades\DB;
use Juzaweb\Ecommerce\Supports\Payment;

class CheckoutController extends FrontendController
{
    public function checkout(
        CartInterface $cart,
        OrderInterface $order,
        CheckoutRequest $request
    ) {
        $items = $cart->getCurrentCart()->items;
        
        if (empty($items)) {
            return $this->error(
                [
                    'message' => __('Cart is empty.'),
                ]
            );
        }
    
        DB::beginTransaction();
        try {
            $newOrder = $order->create($cart, $request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return $this->error($e->getMessage());
        }
        
        $paymentMethod = $newOrder->paymentMethod;
        
        $payment = Payment::make($paymentMethod);
    
        $response = $payment->purchase(
            [
                'amount' => $newOrder->total,
                'currency' => get_config('ecom_currency', 'USD'),
                'cancelUrl' => route('ajax', ['payment/cancel']),
                'returnUrl' => route('ajax', ['payment/completed']),
            ]
        );
        
        if ($response->isRedirect()) {
            $redirect = $response->redirectUrl();
        } else {
            $redirect = $this->getThanksPageRedirect();
        }
        
        return $this->success(
            [
                'redirect' => $redirect,
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
    
    protected function getThanksPageRedirect()
    {
        $thanksPage = Post::find(get_config('ecom_thanks_page'));
        return $thanksPage->slug ?? '/';
    }
}
