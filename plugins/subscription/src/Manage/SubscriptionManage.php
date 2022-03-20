<?php

namespace Juzaweb\Subscription\Manage;

class SubscriptionManage
{
    /**
     * @param string $driver
     * @return SubscriptionDriver|null
     */
    public function driver($driver)
    {
        switch ($driver) {
            case 'paypal':
                return (new PaypalDriver($driver));
        }

        return null;
    }
}
