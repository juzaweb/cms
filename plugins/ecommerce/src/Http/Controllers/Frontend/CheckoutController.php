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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\CMS\Models\User;
use Juzaweb\Ecommerce\Http\Requests\CheckoutRequest;
use Juzaweb\Ecommerce\Models\Order;
use Juzaweb\Ecommerce\Models\PaymentMethod;
use Juzaweb\Ecommerce\Supports\CartInterface;
use Omnipay\Omnipay;

class CheckoutController extends FrontendController
{
    public function checkout(CartInterface $cart, CheckoutRequest $request)
    {
        global $jw_user;
        
        $items = $cart->getCartItems();
        
        if ($items->isEmpty()) {
            return $this->error(
                [
                    'message' => __('Cart is empty.'),
                ]
            );
        }
        
        $paymentMethod = PaymentMethod::find($request->input('payment_method_id'));
        
        DB::beginTransaction();
        try {
            if (empty($jw_user)) {
                $password = Hash::make(Str::random());
                
                $jw_user = User::create(
                    [
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => $password,
                    ]
                );
            }
            
            $order = new Order();
            $order->fill(
                $request->except(
                    [
                        'code',
                        'payment_status',
                        'delivery_status',
                        'payment_method_name',
                        'user_id',
                        'total_price',
                        'total',
                        'quantity',
                    ]
                )
            );
            
            $order->code = Str::uuid()->toString();
            $order->user_id = $jw_user->id;
            $order->total_price = $items->sum('price');
            $order->total = $order->total_price;
            $order->quantity = $items->sum('quantity');
            $order->name = $jw_user->name;
            $order->phone = $jw_user->phone;
            $order->email = $jw_user->email;
            $order->payment_method_name = $paymentMethod->name;
            $order->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        $paymentMethod = $order->paymentMethod;
        
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
        $thanksPage = Post::find(get_config('ecom_thanks_page'));
        return $thanksPage->slug ?? '/';
    }
}
