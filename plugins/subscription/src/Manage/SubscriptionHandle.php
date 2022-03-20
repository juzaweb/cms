<?php

namespace Juzaweb\Subscription\Manage;

use Juzaweb\Subscription\Models\SubscriptionHistory;
use Juzaweb\Subscription\Models\UserSubscription;

abstract class SubscriptionHandle
{
    public $subscription;
    public $history;
    public $data;

    public function __construct(
        UserSubscription $subscription,
        SubscriptionHistory $history,
        $data
    ) {
        $this->subscription = $subscription;
        $this->history = $history;
        $this->data = $data;
    }

    abstract public function handle();
}
