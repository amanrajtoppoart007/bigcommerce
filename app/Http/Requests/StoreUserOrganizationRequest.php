<?php

namespace App\Http\Requests;

use App\Models\UserOrganization;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserOrganizationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_organization_create');
    }

    public function rules()
    {
        return [
            'gst_number'                 => [
                'string',
                'nullable',
            ],
            'organization_name'          => [
                'string',
                'required',
            ],
            'representative_name'        => [
                'string',
                'required',
            ],
            'representative_designation' => [
                'string',
                'required',
            ],
            'primary_contact'            => [
                'string',
                'required',
            ],
            'secondary_contact'          => [
                'string',
                'required',
            ],
            'work_area'                  => [
                'string',
                'required',
            ],
            'amount_deposited_method'    => [
                'string',
                'nullable',
            ],
            'amount_deposited'           => [
                'string',
                'nullable',
            ],
            'signature'                  => [
                'required',
            ],
            'organization_street'        => [
                'string',
                'nullable',
            ],
            'organization_pincode'       => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'representative_street'      => [
                'string',
                'nullable',
            ],
            'representative_pincode'     => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
