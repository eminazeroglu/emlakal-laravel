<?php

namespace App\Providers;

use App\Events\PaymentSuccessEvent;
use App\Events\UserRegisterEvent;
use App\Listeners\PaymentSuccessListener;
use App\Listeners\UserRegisterListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PaymentSuccessEvent::class => [
            PaymentSuccessListener::class
        ],
        UserRegisterEvent::class => [
            UserRegisterListener::class
        ],
    ];

    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
