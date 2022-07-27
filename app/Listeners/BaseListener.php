<?php

namespace App\Listeners;

use App\Services\Models\SettingService;

class BaseListener
{
    public $notifications;

    public function __construct()
    {
        $this->notifications = optional((new SettingService())->getNotification())?->value;
    }
}
