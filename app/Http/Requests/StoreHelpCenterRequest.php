<?php

namespace App\Http\Requests;

use App\Models\HelpCenter;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHelpCenterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('help_center_create');
    }

    public function rules()
    {
        return [
            'name'                      => [
                'string',
                'required',
            ],
            'email'                     => [
                'email',
                'unique:help_centers,email',
                'required',
            ],
            'mobile'                    => [
                'unique:help_centers,mobile',
                'required',
                'numeric',
                'digits:10',
//                'regex:/^([6-9]{1}[0-9]{9})$/',
            ],
            'password'                  => [
                'required',
            ],
            'role'                      => [
                'required',
            ],
        ];
    }
}
