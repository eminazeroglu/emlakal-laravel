<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use App\Notifications\UserRegisterNotification;

class UserRegisterListener
{
    public function handle(UserRegisterEvent $event)
    {
        $hash = helper()->enCrypto($event->params->id);
        $link = '';
        try {
            $event->params->notify(new UserRegisterNotification([
                'title'   => 'Profil təstiqi',
                'subject' => 'Profil təstiqi',
                'body'    => 'Zəhmət olmasa aşağdakı linkə keçid edib profilinizi təstiqləyin',
                'button'  => [
                    'text' => 'Təstiqlə',
                    'url'  => $link
                ]
            ]));
        }
        catch (\Exception $e) {

        }
    }
}
