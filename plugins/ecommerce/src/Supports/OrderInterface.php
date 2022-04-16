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

use Illuminate\Support\Collection;
use Juzaweb\CMS\Models\User;
use Juzaweb\Ecommerce\Models\Order;

interface OrderInterface
{
    public function createByCart(CartInterface $cart, User $user, array $data) : Order;
    
    public function createByItems(array $data, array $items, User $user): Order;
    
    public function getCollectionItems(array $items): Collection;
}
