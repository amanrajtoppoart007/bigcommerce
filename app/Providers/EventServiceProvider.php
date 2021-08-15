<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderAssigned;
use App\Events\OrderNotAssigned;
use App\Events\ProductCreated;
use App\Events\FarmerRegistered;
use App\Events\HelpCenterRegistered;
use App\Events\FranchiseeRegistered;
use App\Events\PushNotificationCreated;
use App\Events\OrderCreated;
use App\Listeners\SendOrderAssignedMail;
use App\Listeners\SendOrderNotAssignedMail;
use App\Listeners\SendProductCreatedPushNotification;
use App\Listeners\PushNotificationCreatedListener;
use App\Listeners\SendFarmerRegisteredMessage;
use App\Listeners\SendHelpCenterRegisteredMessage;
use App\Listeners\SendFranchiseeRegisteredMessage;
use App\Listeners\SendOrderCreatedMessage;
use App\Listeners\GenerateOrderInvoice;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderAssigned::class => [
            SendOrderAssignedMail::class
        ],
        OrderNotAssigned::class => [
            SendOrderNotAssignedMail::class
        ],
        ProductCreated::class => [
            SendProductCreatedPushNotification::class
        ],
        PushNotificationCreated::class => [
            PushNotificationCreatedListener::class
        ],
        FarmerRegistered::class => [
            SendFarmerRegisteredMessage::class
        ],
        HelpCenterRegistered::class => [
            SendHelpCenterRegisteredMessage::class
        ],
        FranchiseeRegistered::class => [
            SendFranchiseeRegisteredMessage::class
        ],
        OrderCreated::class => [
            SendOrderCreatedMessage::class,
            GenerateOrderInvoice::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
