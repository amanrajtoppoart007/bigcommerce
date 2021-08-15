<?php

namespace App\Listeners;

use App\Events\HelpCenterRegistered;
use App\Mail\HelpCenterWelcomeMessage;
use App\Mail\UserWelcomeMessage;
use App\Traits\SmsSenderTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendHelpCenterRegisteredMessage
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
     * @param  HelpCenterRegistered  $event
     * @return void
     */
    public function handle(HelpCenterRegistered $event)
    {
        Mail::to($event->data['email'])->send(new HelpCenterWelcomeMessage($event->data));
        $this->sendRegisteredHelpCenterSms($event->data);
        return true;
    }
}
