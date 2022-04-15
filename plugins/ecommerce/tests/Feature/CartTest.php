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
use Juzaweb\Tests\TestCase;

class CartTest extends TestCase
{
    public function testAddToCart()
    {
        $response = $this->json('POST', 'ajax/cart/add-to-cart', ['variant_id' => 1, 'quantity' => 1]);
        
        $response->assertStatus(200);
        
        $result = json_decode($response->getContent(), true);
        
        $this->assertDatabaseHas(
            'carts',
            ['code' => Arr::get($result, 'data.cart.code')]
        );
    }
}
