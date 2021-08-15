<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_edit');
    }

    public function rules()
    {
        return [
            'name'               => [
                'string',
                'required',
            ],
            'role_id.*'            => [
                'required',
                'integer',
            ],
            'password' => [
                'nullable'
            ]
        ];
    }
}
