<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HelpCenterRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
                'digits:10'
//                'regex:/^([6-9]{1}[0-9]{9})$/'
            ],
            'password'                  => [
                'required',
            ],
            'role'                      => [
                'required',
            ],
           'organization_name'             => [
                'string',
                'nullable',
            ],
            'representative_name'           => [
                'string',
                'required',
            ],
            'representative_designation'    => [
                'string',
                'nullable',
            ],
            'secondary_contact'             => [
                'required',
                'numeric',
                'digits:10'
//                'regex:/^([6-9]{1}[0-9]{9})$/'
            ],
            'organization_street'           => [
                'string',
                'nullable',
            ],
            'organization_address_line_two' => [
                'string',
                'nullable',
            ],
            'organization_pincode'          => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'representative_street'         => [
                'string',
                'nullable',
            ],
            'representative_pincode'        => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
