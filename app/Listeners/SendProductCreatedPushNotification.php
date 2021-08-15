<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Models\User;
use App\Traits\FirebaseNotificationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProductCreatedPushNotification implements ShouldQueue
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
     * @param  ProductCreated  $event
     * @return void
     */
    public function handle(ProductCreated $event)
    {
        $imageUrl = asset('assets/assets/images/logo-1.png');
        if(isset($event->product->images[0])){
            $imageUrl = $event->product->images[0]->getUrl('thumb');
        }
        $message = [
            'title' => 'New product arrived',
            'body' => $event->product->name,
            'imageUrl' => $imageUrl
        ];
        $deviceTokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
        if(!empty($deviceTokens)){
            return $this->sendPushNotification($deviceTokens, $message);
        }
        return false;
    }
}
