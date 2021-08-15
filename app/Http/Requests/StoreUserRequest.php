<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
        //return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'name'               => [
                'string',
                'required',
            ],
            'mobile'             => [
                'required',
                'unique:users',
                'numeric',
                'digits:10',
//                'regex:/^([6-9]{1}[0-9]{9})$/'
            ],
            'secondary_mobile'             => [
                'required',
                'numeric',
                'digits:10',
//                'regex:/^([6-9]{1}[0-9]{9})$/'
            ],
            'email'              => [
                'required',
                'unique:users',
            ],
            'password'           => [
                'required',
            ],

            'mobile_verified_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'referral_code'      => [
                'string',
                'nullable',
            ],
            'crops.*'            => [
                'integer',
            ],
            'crops'              => [
                'required',
                'array',
            ],
            'address'              => [
                'required',
                'string',
            ],
            'area_id' => [
                'required'
            ],
            'help_center_id' => [
                'required'
            ]
        ];
    }
}
