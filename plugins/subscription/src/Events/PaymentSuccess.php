<?php

namespace Juzaweb\Subscription\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Juzaweb\Subscription\Models\SubscriptionHistory;
use Juzaweb\Subscription\Models\UserSubscription;

class PaymentSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
}
