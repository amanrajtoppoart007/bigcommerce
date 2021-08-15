<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_type',
        'member_id',
        'plan_type',
        'membership_fees',
        'membership_status',
        'transaction_id',
        'payment_method',
        'created_at',
        'updated_at',
        'start_date',
        'expiry_date',
    ];

    const MEMBERSHIP_STATUS_RADIO = [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE',
    ];
    protected $guarded = [];

    public function member()
    {
        return $this->morphTo();
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }
}
