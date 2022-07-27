<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class UserForgetPasswordNotification extends BaseNotification
{
    use Queueable;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->from($this->mail['email'], $this->mail['name'])
            ->greeting($this->params['title'])
            ->subject($this->params['subject'])
            ->line($this->params['body'])
            ->action($this->params['button']['text'], $this->params['button']['url']);
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
