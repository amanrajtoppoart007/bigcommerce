<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Order extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'orders';

    const STATUS_SELECT_FOR_ADMIN = [
        'APPROVED'    => 'APPROVED',
        'CONFIRMED'    => 'CONFIRMED',
        'REJECTED'    => 'REJECTED',
        'DISPATCHED'    => 'DISPATCHED',
        'DELIVERED'    => 'DELIVERED',
    ];

    const STATUS_SELECT_FOR_FRANCHISEE = [
        'APPROVED'    => 'APPROVED',
        'CONFIRMED'    => 'CONFIRMED',
        'REJECTED'    => 'REJECTED',
        'DISPATCHED'    => 'DISPATCHED',
        'DELIVERED'    => 'DELIVERED',
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

    const STATUS_SELECT_FOR_HELP_CENTER = [
        'DELIVERED'    => 'DELIVERED',
        'CANCELLED'    => 'CANCELLED',
        'RECEIVED'    => 'RECEIVED',
    ];

    public static $searchable = [
        'payment_type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const PAYMENT_TYPE_SELECT = [
        'ONLINE' => 'ONLINE',
        'COD'    => 'COD',
        'CASH'    => 'CASH',
    ];

    protected $fillable = [
        'order_number',
        'user_id',
        'payment_type',
        'address_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function orderCarts()
    {
        return $this->hasMany(Cart::class, 'order_id', 'id');
    }

    public function orderTransactions()
    {
        return $this->hasMany(Transaction::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function assignee()
    {
        return $this->belongsTo(Franchisee::class, 'franchisee_id');
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

    public function helpCenter()
    {
        return $this->belongsTo(HelpCenter::class, 'help_center_id');
    }
}
