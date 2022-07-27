<?php

namespace App\Listeners;

use App\Events\PaymentSuccessEvent;
use App\Services\System\LogService;

class PaymentSuccessListener
{
    public function handle(PaymentSuccessEvent $event)
    {
        $params = $event->params;
        LogService::payment('Ödəniş tamamlandı');
    }
}
