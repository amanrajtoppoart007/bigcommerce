<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\SendOrderCreatedMailToAdmin;
use App\Mail\SendOrderCreatedMailToFarmer;
use App\Mail\SendOrderCreatedMailToHelpCenter;
use App\Models\Admin;
use App\Traits\SmsSenderTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedMessage implements ShouldQueue
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $emails = Admin::whereApproved(true)->whereVerified(true)->pluck('email');
        if(!empty($emails)){
            Mail::to($emails)->send(new SendOrderCreatedMailToAdmin($order));
        }

        if(!is_null($order->helpCenter)){
            Mail::to($order->helpCenter)->send(new SendOrderCreatedMailToHelpCenter($order));
        }

        Mail::to($order->user)->send(new SendOrderCreatedMailToFarmer($order));

        $data = [
            'name' => $order->user->name,
            'mobile' => $order->user->mobile,
            'order_number' => $order->user->order_number,
            'date' => Carbon::parse($order->creatred_at)->format('d M Y')
        ];

//        return $this->sendUserOrderPlacedSms($data);
    }
}
