<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Events;

use Juzaweb\CMS\Models\User;
use Juzaweb\Ecommerce\Models\Order;

class OrderSuccess
{
    public $order;
    public $user;
    
    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }
}
