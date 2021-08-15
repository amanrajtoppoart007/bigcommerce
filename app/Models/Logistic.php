<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Logistic extends Authenticatable
{
     use SoftDeletes, Notifiable, Auditable, HasFactory;

    public $table = 'logistics';
    public $primaryKey = 'id';

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
        'mobile',
        'password',
        'approved',
        'verified',
        'verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_logistics','logistics_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
