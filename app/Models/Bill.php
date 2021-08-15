<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Bill extends Model
{
    use HasFactory;

    public $table = 'bills';

    protected $fillable = [
        'vendor_id',
        'voucher_date',
        'voucher_number',
        'bill_amount',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function billItems() {
        return $this->hasMany(BillItem::class);
    }
}
