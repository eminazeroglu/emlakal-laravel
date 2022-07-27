<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class UserRegisterNotification extends BaseNotification
{
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
