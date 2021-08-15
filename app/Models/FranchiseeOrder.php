<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseeOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PAYMENT_TYPE_SELECT = [
        'ONLINE' => 'ONLINE',
        'COD'    => 'COD',
    ];

    const STATUS_SELECT_FOR_ADMIN = [
//        'PENDING' => 'PENDING',
        'APPROVED'    => 'APPROVED',
        'CONFIRMED'    => 'CONFIRMED',
        'REJECTED'    => 'REJECTED',
        'DISPATCHED'    => 'DISPATCHED',
        'DELIVERED'    => 'DELIVERED',
    ];

    const STATUS_SELECT_FOR_FRANCHISEE = [
        'PENDING' => 'PENDING',
        'CANCELLED'    => 'CANCELLED',
        'RECEIVED'    => 'RECEIVED',
    ];

    const STATUS_SELECT = [
        'PENDING' => 'PENDING',
        'APPROVED'    => 'APPROVED',
        'CONFIRMED'    => 'CONFIRMED',
        'REJECTED'    => 'REJECTED',
        'DISPATCHED'    => 'DISPATCHED',
        'DELIVERED'    => 'DELIVERED',
        'CANCELLED'    => 'CANCELLED',
        'RECEIVED'    => 'RECEIVED',
    ];

    public function orderItems(){
        return $this->hasMany(FranchiseeOrderItem::class, 'franchisee_order_id', 'id');
    }

    public function franchisee(){
        return $this->belongsTo(Franchisee::class);
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }
}
