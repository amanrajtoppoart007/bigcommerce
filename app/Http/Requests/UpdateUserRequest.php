<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
       // return Gate::allows('user_edit');
        return true;
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
                'unique:users,mobile,' . request()->route('user')->id,
//                'regex:/^([6-9]{1}[0-9]{9})$/'
                'numeric',
                'digits:10',
            ],
            'secondary_mobile'             => [
                'required',
//                'regex:/^([6-9]{1}[0-9]{9})$/',
                'numeric',
                'digits:10',
            ],
            'email'              => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'crops.*'            => [
                'integer',
            ],
            'crops'              => [
                'required',
                'array',
            ],
            'mobile_verified_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'referral_code'      => [
                'string',
                'nullable',
            ],
        ];
    }
}
