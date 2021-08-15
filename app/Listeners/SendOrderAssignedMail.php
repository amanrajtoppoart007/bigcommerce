<?php

namespace App\Listeners;

use App\Events\OrderAssigned;
use App\Mail\SendOrderAssignedEmailToFranchisee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderAssignedMail implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  OrderAssigned  $event
     * @return void
     */
    public function handle(OrderAssigned $event)
    {
        return Mail::to($event->order->assignee)->send(new SendOrderAssignedEmailToFranchisee($event->order));
    }
}
