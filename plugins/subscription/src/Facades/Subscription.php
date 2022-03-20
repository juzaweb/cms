<?php

namespace Juzaweb\Subscription\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Subscription\Contracts\SubscriptionContract;
use Juzaweb\Subscription\Manage\SubscriptionDriver;

/**
 * @method static SubscriptionDriver|null driver(string $driver)
 * @see \Juzaweb\Subscription\Manage\SubscriptionManage
 */
class Subscription extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SubscriptionContract::class;
    }
}
