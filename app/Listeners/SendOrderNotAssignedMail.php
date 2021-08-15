<?php

namespace App\Listeners;

use App\Events\OrderNotAssigned;
use App\Mail\SendOrderNotAssignedMailToAdmin;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderNotAssignedMail implements ShouldQueue
{
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
     * @param  OrderNotAssigned  $event
     * @return void
     */
    public function handle(OrderNotAssigned $event)
    {
        $emails = Admin::whereApproved(true)->whereVerified(true)->pluck('email');
        if(empty($emails)) return true;
        return Mail::to($emails)->send(new SendOrderNotAssignedMailToAdmin($event->order));
    }
}
