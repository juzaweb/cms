<?php

namespace Juzaweb\Subscription\Traits;

use Juzaweb\Subscription\Models\SubscriptionHistory;

trait HasSubscription
{
    public function subscriptionHistories()
    {
        return $this->hasMany(SubscriptionHistory::class, 'object_id', 'id');
    }

    abstract public function subscription();
}
