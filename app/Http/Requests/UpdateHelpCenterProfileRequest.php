<?php

namespace App\Http\Requests;

use App\Models\HelpCenterProfile;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHelpCenterProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('help_center_profile_edit');
    }

    public function rules()
    {
        return [
            'help_center_id'                => [
                'required',
                'integer',
            ],
            'organization_name'             => [
                'string',
                'nullable',
            ],
            'gst_number'                    => [
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
            'email'                         => [
                'string',
                'required',
                'unique:help_centers,email,' .request()->route('help_center_profile')->help_center_id
            ],
            'primary_contact'               => [
                'required',
                'numeric',
                'digits:10',
                'unique:help_centers,mobile,' .request()->route('help_center_profile')->help_center_id
            ],
            'secondary_contact'             => [
                'numeric',
                'digits:10',
                'required',
            ],
            'work_area'                     => [
                'string',
                'nullable',
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
                'required',
            ],
            'representative_pincode_id'        => [
                'required',
            ],
            'payment_method'                => [
                'nullable',
            ],
        ];
    }
}
