<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function printInvoice($invoiceNo)
    {
        $invoice = Invoice::where('invoice_number', $invoiceNo)->first();
        if(is_null($invoiceNo)){
            abort(404);
        }

        if($invoice->invoiceable_type != Order::class){
            abort(404);
        }

        $order = $invoice->invoiceable;

        return view('extra.orderInvoice', compact('invoice', 'order'));
    }
}
