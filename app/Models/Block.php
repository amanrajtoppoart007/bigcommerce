<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Block extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'blocks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'district_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function blockPincodes()
    {
        return $this->hasMany(Pincode::class, 'block_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
