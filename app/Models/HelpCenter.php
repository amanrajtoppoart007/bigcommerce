<?php

namespace App\Models;

use App\Notifications\HelpCenter\ResetPasswordNotification;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HelpCenter extends Authenticatable
{
    use SoftDeletes, Notifiable, Auditable, HasFactory;

    public $table = 'help_centers';

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
        'mobile',
        'password',
        'role',
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

    const ROLE_SELECT = [
        'help_center_platinum' => 'कृषक सेवा प्लैटिनम मेंबर - Seva Platinum Member',
        'help_center_gold' => 'कृषक सेवा गोल्ड मेंबर - Seva Gold Member',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public function users()
    {
        return $this->hasMany(User::class,"help_center_id","id");
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_help_center');
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

    public function profile() {
        return $this->hasOne(HelpCenterProfile::class);
    }

    public function membership()
    {
        return $this->morphOne(Membership::class, 'member');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function memberships()
    {
        return $this->morphMany(Membership::class, 'member');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
