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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juzaweb\CMS\Models\User;
use Juzaweb\Ecommerce\Models\Order;
use Juzaweb\Ecommerce\Models\PaymentMethod;
use Juzaweb\Ecommerce\Models\ProductVariant;

class DbOrder implements OrderInterface
{
    public function createByCart(
        CartInterface $cart,
        User $user,
        array $data
    ): Order {
        $order = $this->createByItems($data, $cart->getCurrentCart()->items, $user);
    
        $cart->remove();
        
        return $order;
    }
    
    public function createByItems(array $data, array $items, User $user): Order
    {
        $items = $this->getCollectionItems($items);
    
        $order = $this->createOrder($data, $user, $items);
        
        return $order;
    }
    
    public function getCollectionItems(array $items): Collection
    {
        $variantIds = collect($items)
            ->pluck('variant_id')
            ->toArray();
        
        $variants = ProductVariant::with(['product'])
            ->whereIn('id', $variantIds)
            ->get()
            ->map(
                function ($item) use ($items) {
                    $item->quantity = $items[$item->id]['quantity'];
                    $item->line_price = $item->price * $item->quantity;
                    return $item;
                }
            );
    
        if (empty($variants)) {
            throw new \Exception('Product items is empty.');
        }
        
        return $variants;
    }
    
    protected function createOrder(array $data, User $user, Collection $items)
    {
        $paymentMethod = $this->getPaymentMethod($data);
        $filldata = array_except(
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
        );
        
        $order = new Order();
        $order->fill($filldata);
        $order->code = Str::uuid()->toString();
        $order->user_id = $user->id;
        $order->total_price = $items->sum('line_price');
        $order->total = $order->total_price;
        $order->quantity = $items->sum('quantity');
        $order->name = $user->name;
        $order->phone = $user->phone;
        $order->email = $user->email;
        $order->payment_method_name = $paymentMethod->name;
        $order->save();
        
        foreach ($items as $item) {
            /**
             * @var ProductVariant $item
             */
            $order->orderItems()->create(
                [
                    'price' => $item->price,
                    'compare_price' => $item->compare_price,
                    'sku_code' => $item->sku_code,
                    'barcode' => $item->barcode,
                ]
            );
        }
        
        return $order;
    }
    
    protected function getPaymentMethod(array $data): PaymentMethod
    {
        $paymentMethod = PaymentMethod::find(Arr::get($data, 'payment_method_id'));
        
        if (empty($paymentMethod)) {
            throw new \Exception('Payment method does not exist');
        }
        
        return $paymentMethod;
    }
}
