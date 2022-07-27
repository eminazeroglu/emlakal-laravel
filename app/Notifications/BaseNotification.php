<?php

namespace App\Notifications;

use App\Services\Models\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification
{
    use Queueable;

    protected $mail;

    public function __construct($params)
    {
        $this->mail          = optional((new SettingService())->getMail())?->value;
        $this->params        = $params;
    }
}
