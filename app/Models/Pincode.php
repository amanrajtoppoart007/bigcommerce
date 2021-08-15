<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Pincode extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'pincodes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'pincode',
        'status',
        'block_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function pincodeAreas()
    {
        return $this->hasMany(Area::class, 'pincode_id', 'id');
    }

    public function pincodeUserAddresses()
    {
        return $this->hasMany(UserAddress::class, 'pincode_id', 'id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }
}
