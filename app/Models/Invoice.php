<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'date_time',
        'invoiceable_type',
        'invoiceable_id',
        'userable_type',
        'userable_id',
        'transaction_id',
        'payment_type',
        'amount',
        'gst',
        'discount',
        'total',
    ];

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function userable()
    {
        return $this->morphTo();
    }
}
