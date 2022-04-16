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

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Juzaweb\CMS\Models\User;
use Juzaweb\Ecommerce\Models\Order;
use Juzaweb\Ecommerce\Models\PaymentMethod;

class DbOrder implements OrderInterface
{
    public function create(CartInterface $cart, array $data) : Order
    {
        global $jw_user;
    
        $items = $cart->getCartItems();
    
        if (empty($items)) {
            throw new \Exception('Cart is empty.');
        }
        
        $paymentMethod = PaymentMethod::find(Arr::get($data, 'payment_method_id'));
    
        if (empty($paymentMethod)) {
            throw new \Exception('Payment method does not exist');
        }
        
        if (empty($jw_user)) {
            $password = Hash::make(Str::random());
        
            $jw_user = User::create(
                [
                    'name' => Arr::get($data, 'name'),
                    'email' => Arr::get($data, 'email'),
                    'password' => $password,
                ]
            );
        }
    
        $order = new Order();
        $order->fill(
            array_except(
                $data,
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
    
        $cart->remove();
        
        return $order;
    }
}
