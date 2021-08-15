<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Invoice;
use App\Traits\UniqueIdentityGeneratorTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class GenerateOrderInvoice implements ShouldQueue
{
    use UniqueIdentityGeneratorTrait;

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
     * @param OrderCreated $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {

        $order = $event->order;
        DB::beginTransaction();
        try {
            $invoice = new Invoice();
            $invoice->invoice_number = $this->generateInvoiceNumber();
            $invoice->date_time = Carbon::now()->format('Y-m-d h:i:s');
            $invoice->invoiceable_type = "App\Models\Order";
            $invoice->invoiceable_id = $order->id;
            $invoice->userable_type = "App\Models\User";
            $invoice->userable_id = $order->user_id;
            $invoice->transaction_id = $order->transaction_id;
            $invoice->payment_type = $order->payment_type;
            $invoice->amount = $order->sub_total;
            $invoice->gst = $order->gst;
            $invoice->discount = $order->discount;
            $invoice->total = $order->grand_total;
            $invoice->save();

            $order->is_invoice_generated;
            $order->save();
            DB::commit();
            return true;

        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }

    }
}
