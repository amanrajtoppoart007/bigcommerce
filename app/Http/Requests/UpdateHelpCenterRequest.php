<?php

namespace App\Http\Requests;

use App\Models\HelpCenter;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHelpCenterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('help_center_edit');
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
                'required',
                'unique:help_centers,email,' . request()->route('help_center')->id
            ],
            'mobile'                    => [
                'required',
//                'regex:/^([6-9]{1}[0-9]{9})$/',
                'numeric',
                'digits:10',
                'unique:help_centers,mobile,' . request()->route('help_center')->id
            ],

            'role'                      => [
                'required',
            ],
        ];
    }
}
