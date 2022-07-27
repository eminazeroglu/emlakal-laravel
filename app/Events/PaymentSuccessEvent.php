<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;

class PaymentSuccessEvent extends BaseEvent
{
    public function broadcastOn(): \Illuminate\Broadcasting\Channel|PrivateChannel|array
    {
        return new PrivateChannel('channel-name');
    }
}
