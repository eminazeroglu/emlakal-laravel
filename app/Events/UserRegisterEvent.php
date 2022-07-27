<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;

class UserRegisterEvent extends BaseEvent
{
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
