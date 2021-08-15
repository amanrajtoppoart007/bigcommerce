<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_type',
        'fees',
        'member_type',
        'status',
        'created_at',
        'updated_at',
    ];

    const MEMBER_TYPES_RADIO = [
        'HELP_CENTER' => 'Help Center',
        'FRANCHISEE' => 'Franchisee',
    ];

    const STATUS_RADIO = [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE',
    ];
}
