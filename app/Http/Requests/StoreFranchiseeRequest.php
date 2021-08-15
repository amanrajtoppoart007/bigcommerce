<?php

namespace App\Http\Requests;

use App\Models\Franchisee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFranchiseeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('franchisee_create');
    }

    public function rules()
    {
        return [
            'name'                      => [
                'string',
                'required',
            ],
            'email'                     => [
                'required',
                'unique:franchisees'
            ],
            'password'                  => [
                'required',
            ],
            'mobile'                    => [
                'required',
                'numeric',
                'digits:10',
//                'regex:/^([6-9]{1}[0-9]{9})$/',
                'unique:franchisees'
            ],
            'email_verified_at'         => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'mobile_verified_at'        => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'verification_token'        => [
                'string',
                'nullable',
            ],
            'mobile_verification_token' => [
                'string',
                'nullable',
            ],
        ];
    }
}
