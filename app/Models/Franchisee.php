<?php

namespace App\Models;

use App\Notifications\Franchisee\ResetPasswordNotification;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Notifications\Notifiable;

class Franchisee extends Authenticatable
{
    use SoftDeletes, Notifiable, Auditable, HasFactory;

    const ROLE_SELECT = [
        'franchisee' => "Franchisee"
    ];

    public $table = 'franchisees';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'mobile_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'email_verified_at',
        'mobile_verified_at',
        'verification_token',
        'mobile_verification_token',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved',
        'verified',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_franchisee');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getMobileVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setMobileVerifiedAtAttribute($value)
    {
        $this->attributes['mobile_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function serviceAreas()
    {
        return $this->hasMany(FranchiseeArea::class);
    }

    public function profile()
    {
        return $this->hasOne(FranchiseeProfile::class);
    }

    public function membership()
    {
        return $this->morphOne(Membership::class, 'member');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function memberships()
    {
        return $this->morphMany(Membership::class, 'member');
    }
}
