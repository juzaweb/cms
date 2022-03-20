<?php

namespace Juzaweb\Notification\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($user, $notification)
    {
        $this->message  = $notification->body;
    }

    public function broadcastOn()
    {
        return ['development'];
    }
}
