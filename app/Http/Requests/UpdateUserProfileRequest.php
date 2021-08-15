<?php

namespace App\Http\Requests;

use App\Models\UserProfile;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_profile_edit');
    }

    public function rules()
    {
        return [
            'user_id'           => [
                'required',
                'integer',
            ],
            'name'              => [
                'string',
                'nullable',
            ],
            'mobile'   => [
                'string',
                'nullable',
            ],
            'secondary_mobile' => [
                'string',
                'nullable',
            ],
            'agricultural_land' => [
                'numeric',
            ],
        ];
    }
}
