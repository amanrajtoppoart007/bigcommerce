<?php

namespace App\Http\Requests;

use App\Models\Franchisee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFranchiseeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('franchisee_edit');
    }

    public function rules()
    {
        return [
            'name'                      => [
                'string',
                'nullable',
            ],
            'email'                     => [
                'required',
                'unique:franchisees,email,' . request()->route('franchisee')->id
            ],
            'mobile'                    => [
//                'regex:/^([6-9]{1}[0-9]{9})$/',
                'numeric',
                'digits:10',
                'required',
                'unique:franchisees,mobile,' . request()->route('franchisee')->id
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
