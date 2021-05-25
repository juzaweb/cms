<?php

namespace Mymo\Core\Events;

use Mymo\Core\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RegisterSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
