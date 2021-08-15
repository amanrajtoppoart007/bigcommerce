<?php

namespace App\Listeners;

use App\Events\FarmerRegistered;
use App\Mail\UserWelcomeMessage;
use App\Traits\SmsSenderTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendFarmerRegisteredMessage implements ShouldQueue
{
    use SmsSenderTrait;
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
     * @param  FarmerRegistered  $event
     * @return void
     */
    public function handle(FarmerRegistered $event)
    {
        Mail::to($event->data['email'])->send(new UserWelcomeMessage($event->data));
        $this->sendRegisteredUserSms($event->data);
        return true;
    }
}
