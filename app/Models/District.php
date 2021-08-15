<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class District extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'districts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'state_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function districtBlocks()
    {
        return $this->hasMany(Block::class, 'district_id', 'id');
    }

    public function districtCities()
    {
        return $this->hasMany(City::class, 'district_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
