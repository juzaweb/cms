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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Juzaweb\Backend\Events\RegisterSuccessful;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\CMS\Models\User;
use Juzaweb\Ecommerce\Events\OrderSuccess;
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
        global $jw_user;
        
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
            if (empty($jw_user)) {
                $password = Hash::make(Str::random());
    
                $jw_user = User::create(
                    [
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'password' => $password,
                    ]
                );
                
                event(new RegisterSuccessful($jw_user));
            }
            
            $newOrder = $order->createByCart($cart, $jw_user, $request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return $this->error($e->getMessage());
        }
        
        event(new OrderSuccess($newOrder, $jw_user));
        
        $paymentMethod = $newOrder->paymentMethod;
        
        try {
            $payment = Payment::make($paymentMethod);
    
            $response = $payment->purchase(
                [
                    'amount' => $newOrder->total,
                    'currency' => get_config('ecom_currency', 'USD'),
                    'cancelUrl' => route('ajax', ['payment/cancel']),
                    'returnUrl' => route('ajax', ['payment/completed']),
                ]
            );
        } catch (\Exception $e) {
            report($e);
            return $this->error($e->getMessage());
        }
    
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
        $paypal = new PayPal;
    
        $response = $paypal->complete(
            [
                'amount' => $paypal->formatAmount($order->amount),
                'transactionId' => $order->id,
                'currency' => 'USD',
                'cancelUrl' => $paypal->getCancelUrl($order),
                'returnUrl' => $paypal->getReturnUrl($order),
                'notifyUrl' => $paypal->getNotifyUrl($order),
            ]
        );
    
        if ($response->isSuccessful()) {
            $order->update(['transaction_id' => $response->getTransactionReference()]);
        }
        
        return redirect()->to($this->getThanksPageRedirect());
    }
    
    protected function getThanksPageRedirect()
    {
        $thanksPage = Post::find(get_config('ecom_thanks_page'));
        return $thanksPage->slug ?? '/';
    }
}
