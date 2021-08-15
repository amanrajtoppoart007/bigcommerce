<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Vendor extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'vendors';

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'created_at',
        'updated_at',
        'deleted_at',
        'address',
    ];


     public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_vendor');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
