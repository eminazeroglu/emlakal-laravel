<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BaseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $params;
    public $type;

    public function __construct($params, $type = null)
    {
        $this->params = $params;
        $this->type   = $type;
    }
}
