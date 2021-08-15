<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FranchiseeRegistrationRequest extends FormRequest
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
                'unique:franchisees,email',
                'required',
            ],
            'mobile'                    => [
                'unique:franchisees,mobile',
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
//                'regex:/^([6-9]{1}[0-9]{9})$/',
                'numeric',
                'digits:10',
            ],
            'organization_street'           => [
                'string',
                'nullable',
            ],
            'organization_address_line_two' => [
                'string',
                'nullable',
            ],
            'organization_pincode_id'          => [
                'nullable',
            ],
            'representative_street'         => [
                'string',
                'nullable',
            ],
            'representative_pincode_id'        => [
                'required',
            ],
        ];
    }
}
