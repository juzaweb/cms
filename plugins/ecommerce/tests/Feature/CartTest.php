<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Tests\Feature;

use Illuminate\Support\Arr;
use Juzaweb\Ecommerce\Models\ProductVariant;
use Juzaweb\Tests\TestCase;

class CartTest extends TestCase
{
    public function testAddToCart()
    {
        $variants = ProductVariant::whereHas(
            'product',
            function ($q) {
                $q->wherePublish();
            }
        )
        ->limit(3)
        ->get();
        
        foreach ($variants as $variant) {
            $response = $this->json(
                'POST',
                'ajax/cart/add-to-cart',
                [
                    'variant_id' => $variant->id,
                    'quantity' => random_int(10, 100),
                ]
            );
    
            $response->assertStatus(200);
            
            $result = json_decode($response->getContent(), true);
    
            $this->assertTrue($result['status']);
    
            $this->assertDatabaseHas(
                'carts',
                ['code' => Arr::get($result, 'data.cart.code')]
            );
        }
    }
}
