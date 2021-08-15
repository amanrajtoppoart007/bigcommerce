<?php

namespace App\Listeners;

use App\Events\PushNotificationCreated;
use App\Traits\FirebaseNotificationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PushNotificationCreatedListener implements ShouldQueue
{
    use FirebaseNotificationTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PushNotificationCreated  $event
     * @return void
     */
    public function handle(PushNotificationCreated $event)
    {
        return $this->sendPushNotification($event->data['device_tokens'], $event->data['message']);
    }
}
